<?php
/**
 *
 * @category   Inovarti
 * @package    Inovarti_CustomRolepermissions
 * @author     Suporte <suporte@inovarti.com.br>
 */
class Inovarti_CustomRolepermissions_Model_Resource_Rule extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('customrolepermissions/rule', 'rule_id');
    }
}
