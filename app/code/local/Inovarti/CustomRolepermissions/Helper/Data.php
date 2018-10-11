<?php
/**
 *
 * @category   Inovarti
 * @package    Inovarti_CustomRolepermissions
 * @author     Suporte <suporte@inovarti.com.br>
 */
class Inovarti_CustomRolepermissions_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function currentRule()
    {
        if (($rule = Mage::registry('current_customrolepermissions_rule')) == null)
        {
            $rule = Mage::getModel('customrolepermissions/rule')->loadCurrent();
            Mage::register('current_customrolepermissions_rule', $rule);
        }
        //pasta helper maiuscula
        return $rule;
    }
    public function addRulesTabs($block)
    {
        $role = Mage::registry('current_role');

        $rule = Mage::getModel('customrolepermissions/rule')->load($role->getId(), 'role_id');
        if (!$rule->getId())
            $rule->setRoleId($role->getId());

        Mage::register('current_rule', $rule);

        $block->addTab(
            'customrolepermissions_scope',
            $block->getLayout()->createBlock('customrolepermissions/adminhtml_tab_scope')
        );
    }

}