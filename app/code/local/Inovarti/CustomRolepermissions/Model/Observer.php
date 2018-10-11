<?php
/**
 *
 * @category   Inovarti
 * @package    Inovarti_CustomRolepermissions
 * @author     Suporte <suporte@inovarti.com.br>
 */
class Inovarti_CustomRolepermissions_Model_Observer
{
    public function blockPrepareLayoutAfter($observer)
    {
        $block = $observer->getBlock();

        if ($block instanceof Mage_Adminhtml_Block_Permissions_Editroles) {
            Mage::helper('customrolepermissions')->addRulesTabs($block);
        }

        return $this;

    }
    public function saveRolesPermissions($observer)
    {
        $object = $observer->getObject();
        $request = $observer->getEvent()->getRequest();
        $data = $request->getPost('customrolepermissions');

        $scopeWebsites = isset($data['scope_websites']) ? implode(",", $data['scope_websites']) : null;
        $scopeStoreviews = isset($data['scope_storeviews']) ? implode(",", $data['scope_storeviews']) : null;

        $rule = Mage::getModel('customrolepermissions/rule')->load($object->getRoleId(), 'role_id');

        if ($scopeWebsites || $scopeStoreviews) {
            $roleId = $object->getRoleId() ?: (isset($data['role_id']) ? $data['role_id'] : null);

            if ($roleId) {
                $rule->setRoleId($roleId);
                $rule->setScopeWebsites($scopeWebsites);
                $rule->setScopeStoreviews($scopeStoreviews);
                $rule->save();
            }
        }
    }

	public function restrictCollection($observer)
	{
        $stores = null;
		$collection = $observer->getCollection();

		if (
		    $collection instanceof Mage_Core_Model_Resource_Store_Collection
            || $collection instanceof Mage_Core_Model_Resource_Store_Group_Collection
        ) {
            return $this;
        }

		$rule = Mage::helper('customrolepermissions')->currentRule();

        if ($rule->getScopeWebsites() || $rule->getScopeStoreviews()) {

            if ($rule->getScopeWebsites()) {
                $stores = $this->getStores($rule->getScopeWebsites());
            } else if ($rule->getScopeStoreviews()) {
                $stores = $rule->getScopeStoreviews();
            }

            if ($stores) {
                $restricts = array(
                    'Mage_Widget_Model_Resource_Widget_Instance_Collection',
                    'Mage_Cms_Model_Resource_Page_Collection',
                    'Mage_Cms_Model_Resource_Block_Collection',
                    'Mage_Poll_Model_Resource_Poll_Collection',
                    'Mage_Rating_Model_Resource_Rating_Collection',
                    'Mage_Review_Model_Resource_Review_Collection',
                    'Mage_Checkout_Model_Resource_Agreement_Collection',
                    'Mage_Catalog_Model_Resource_Product_Collection',
                    'Mage_Customer_Model_Resource_Customer_Collection',
                    'Mage_Sales_Model_Resource_Order_Grid_Collection',
                    'Mage_Newsletter_Model_Resource_Subscriber_Collection',
                    //'Mage_Eav_Model_Entity_Collection_Abstract',
                );
                foreach ($restricts as $restrict) {
                    if ($collection instanceof $restrict) {
                        if ($restrict == 'Mage_Sales_Model_Resource_Order_Grid_Collection') {
                            $collection->addFieldToFilter('main_table.store_id', array('in' => $stores), 'inner');
                        } else if ($restrict == 'Mage_Catalog_Model_Resource_Product_Collection') {
                            //$collection->setStore($stores);
                            //$collection->addStoreFilter($stores);
                            //echo $collection->getSelect().'<br>';
                        } else {
                            //$collection->addAttributeToSelect('store_id', array('in' => $stores));
                            $collection->addFieldToFilter('store_id', array('in' => $stores), 'inner');
                        }
                    }
                }
            }
        }

        return $this;

	}

    /**
     * Get the stores based upon website
     *
     * @param string $websites
     * @return string
     */
	protected function getStores($websites = '')
    {
        $stores = Mage::registry('customrolepermissions_stores');
        if (!$stores) {
            $stores = [];
            if (is_string($websites)) {
                $websiteIds = explode(',', $websites);
                foreach ($websiteIds as $websiteId) {
                    /** @var Mage_Core_Model_Website $website */
                    $website = Mage::getModel('core/website')->load($websiteId);
                    if ($website->getId()) {
                        $stores = array_merge($stores, $website->getStoreIds());
                    }
                }

            }
            $stores = implode(',', $stores);
            Mage::register('customrolepermissions_stores', $stores);
        }

        return $stores;
    }
}