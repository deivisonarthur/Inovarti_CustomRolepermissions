<?php
/**
 *
 * @category   Inovarti
 * @package    Inovarti_CustomRolepermissions
 * @author     Suporte <suporte@inovarti.com.br>
 */
class Inovarti_CustomRolepermissions_Block_Adminhtml_Tab_Scope extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    const MODE_NONE = 0;
    const MODE_SITE = 1;
    const MODE_VIEW = 2;

    public function getTabLabel()
    {
        return $this->__('Advanced Permissions: Scope');
    }


    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    public function _beforeToHtml() {
        $this->_initForm();

        return parent::_beforeToHtml();
    }

    protected function _initForm()
    {
        $form = new Varien_Data_Form();

        $model = Mage::registry('current_rule');

        $fieldset = $form->addFieldset('access_scope_fieldset', array('legend'=>$this->__('Choose Access Scope')));

        $fieldset->addField('role_id', 'hidden',
            array(
                'name' => 'customrolepermissions[role_id]',
            )
        );

        if ($model->getScopeWebsites())
            $model->setScopeMode(self::MODE_SITE);
        else if ($model->getScopeStoreviews())
            $model->setScopeMode(self::MODE_VIEW);
        else
            $model->setScopeMode(self::MODE_NONE);

        $mode = $fieldset->addField('scope_mode', 'select',
            array(
                'label' => $this->__('Limit access to'),
                'id'    => 'scope_mode',
                'values'=> array(
                    self::MODE_NONE => $this->__('Allow All Stores'),
                    self::MODE_SITE => $this->__('Specified Websites'),
                    self::MODE_VIEW => $this->__('Specified Store Views'),
                ),
            )
        );

        $websites = array();
        foreach (Mage::getResourceModel('core/website_collection') as $id => $ws)
            $websites []= array('label' => $ws->getName(), 'value' => $ws->getWebsiteId());

        $websites = $fieldset->addField('scope_websites', 'multiselect',
            array(
                'name'  => 'customrolepermissions[scope_websites]',
                'label' => $this->__('Websites'),
                'title' => $this->__('Websites'),
                'values'=> $websites,
            )
        );

        $views = $fieldset->addField('scope_storeviews', 'multiselect', array(
            'name'      => 'customrolepermissions[scope_storeviews]',
            'label'     => $this->__('Store Views'),
            'title'     => $this->__('Store Views'),
            'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
        ));

        $form->setValues($model->getData());
        $this->setForm($form);

        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
                ->addFieldMap($mode->getHtmlId(), $mode->getName())
                ->addFieldMap($websites->getHtmlId(), $websites->getName())
                ->addFieldMap($views->getHtmlId(), $views->getName())
                ->addFieldDependence(
                    $websites->getName(),
                    $mode->getName(),
                    self::MODE_SITE
                )
                ->addFieldDependence(
                    $views->getName(),
                    $mode->getName(),
                    self::MODE_VIEW
                )
        );

        return parent::_prepareForm();
    }
}
