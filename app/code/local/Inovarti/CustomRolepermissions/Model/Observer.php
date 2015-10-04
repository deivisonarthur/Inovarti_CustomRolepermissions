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

        if ($block instanceof Mage_Adminhtml_Block_Permissions_Editroles) Mage::helper('customrolepermissions')->addRulesTabs($block);


    }
    public function saveRolesPermissions($observer)
    {
        $object = $observer->getObject();
        $request = $observer->getEvent()->getRequest();
        $data = $request->getPost('customrolepermissions');

        $scopeWebsites =isset($data['scope_websites']) ? implode(",", $data['scope_websites']) : null;
        $scopeStoreviews = isset($data['scope_storeviews']) ? implode(",", $data['scope_storeviews']) : null;
        $rule = Mage::getModel('customrolepermissions/rule')->load($object->getRoleId(), 'role_id');

        if ($rule){
            $rule->setRoleId($object->getRoleId());
            $rule->setScopeWebsites($scopeWebsites);
            $rule->setScopeStoreviews($scopeStoreviews);
            $rule->save();

        }else{
            $rule->setRoleId($data['role_id']);
            $rule->setScopeWebsites($scopeWebsites);
            $rule->setScopeStoreviews($scopeStoreviews);
            $rule->save();
        }
    }

	public function restrictCollection($observer)
	{

		$collection = $observer->getCollection();

		if ($collection instanceof Mage_Core_Model_Resource_Store_Collection) return;

		$rule = Mage::helper('customrolepermissions')->currentRule();
        //var_dump($collection);
        //exit;


        if ($rule->getScopeStoreviews()) {
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
                    //echo $restrict.'<br>';

                    $stores = $rule->getScopeStoreviews();
                    //print_r($stores);

                    if ($restrict=='Mage_Sales_Model_Resource_Order_Grid_Collection') {
                        $collection->addFieldToFilter('main_table.store_id', array('in' => $stores), 'inner');
                    }else if ($restrict=='Mage_Catalog_Model_Resource_Product_Collection'){
                        //$collection->setStore($stores);
                        //$collection->addStoreFilter($stores);
                        //echo $collection->getSelect().'<br>';
                    }else {
                        //$collection->addAttributeToSelect('store_id', array('in' => $stores));
                        $collection->addFieldToFilter('store_id', array('in' => $stores),'inner');
                    }
				}
			}
		}

	}
}