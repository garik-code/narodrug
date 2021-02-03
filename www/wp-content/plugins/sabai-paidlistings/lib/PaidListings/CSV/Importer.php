<?php
class Sabai_Addon_PaidListings_CSV_Importer extends Sabai_Addon_CSV_AbstractImporter
{
    protected $_photos;
    
    protected function _csvImporterInfo()
    {
        switch ($this->_name) {
            case 'paidlistings_plan':
                $columns = array(
                    'plan_id' => __('Plan ID', 'sabai-paidlistings'),
                    'addon_features' => __('Add-on features', 'sabai-paidlistings'),
                    'recurring_payment_id' => __('Recurring payment ID', 'sabai-paidlistings'),
                );
                break;
            default:
                $columns = null;
        }
        return array(
            'field_types' => array($this->_name),
            'columns' => $columns,
        );
    }
    
    public function csvImporterSettingsForm(Sabai_Addon_Entity_Model_Field $field, array $settings, $column, $enclosure, array $parents = array())
    {
        switch ($this->_name) {
            case 'paidlistings_plan':
                if ($column === 'plan_id') {
                    return array(
                        'type' => array(
                            '#type' => 'select',
                            '#title' => __('Plan ID data type', 'sabai-paidlistings'),
                            '#description' => __('Select the type of data used to specify plan IDs.', 'sabai-paidlistings'),
                            '#options' => array(
                                'id' => __('ID number', 'sabai-paidlistings'),
                                'name' => __('Plan name', 'sabai-paidlistings'),
                            ),
                            '#default_value' => 'id',
                            '#horizontal' => true,
                        ),
                    );  
                }
        }
    }
    
    public function csvImporterDoImport(Sabai_Addon_Entity_Model_Field $field, array $settings, $column, $value)
    {
        switch ($this->_name) {
            case 'paidlistings_plan':
                if ($column === 'plan_id') {
                    switch ($settings['type']) {
                        case 'id':
                            if (!$this->_application->PaidListings_Plan($value)) return;
                            break;
                        case 'name':
                            if (!$plan = $this->_application->getModel('Plan', 'PaidListings')->entityBundleName_is($field->Bundle->name)->name_is($value)->fetchOne()) return;
                            $value = $plan->id;
                            break;
                    }
                } elseif ($column === 'addon_features') {
                    if (empty($value)
                        || (!$value = unserialize($value))
                    ) return;
                }
                return parent::csvImporterDoImport($field, $settings, $column, $value);
        }
    }
}