<?php
/**
 *
 * @category   Inovarti
 * @package    Inovarti_CustomRolepermissions
 * @author     Suporte <suporte@inovarti.com.br>
 */
class Inovarti_CustomRolepermissions_Model_Rule extends Mage_Core_Model_Abstract
{
    protected $_partialWs = null;

    public function _construct()
    {
        parent::_construct();
        $this->_init('customrolepermissions/rule');
    }

    public function loadCurrent()
    {
        $user = Mage::getSingleton('admin/session')->getUser();


        if (!$user) return $this;

        $roleId = $user->getRole()->getId();

        $roles = $this->load($roleId, 'role_id');


        if (!$roles->getData()) return $this;

        $fields = array('scope_storeviews', 'scope_websites');

        foreach($fields as $field)
        {
            $data = $this->getData($field);
            if ($data){
                $this->setData($field, $data);
            }
        }

        $websites = explode(',',$this->getScopeWebsites());
        $stores = explode(',',$this->getScopeStoreviews());

        if (count($websites)>1) {
            if (!$stores){
                $storesColletion = Mage::getResourceModel('core/store_collection')
                    ->addWebsiteFilter($websites)
                ;
                $stores = array();
                foreach ($storesColletion as $data):
                    $stores[]= $data->getStoreId();
                endforeach;

                if ($stores){
                    $this->setScopeStoreviews($stores);
                }
            }
        }else{
            if (count($stores)>1){
                $this->setScopeStoreviews($stores);
            }
        }

        return $this;
    }
}
