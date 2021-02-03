<?php
class Sabai_Addon_PaidListings_CSV_Exporter extends Sabai_Addon_CSV_AbstractExporter
{    
    protected function _csvExporterInfo()
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
    
    public function csvExporterSettingsForm(Sabai_Addon_Entity_Model_Field $field, array $settings, $column, $enclosure, array $parents = array())
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
    
    public function csvExporterDoExport(Sabai_Addon_Entity_Model_Field $field, array $settings, $value, array $columns, array &$files)
    {
        switch ($this->_name) {
            case 'paidlistings_plan':
                $ret = parent::csvExporterDoExport($field, $settings, $value, $columns, $files);
                if (empty($ret['plan_id'])
                    || (!$plan = $this->_application->PaidListings_Plan($ret['plan_id']))
                ) return;

                switch ($settings['plan_id']['type']) {
                    case 'name':
                        $ret['plan_id'] = $plan->name;
                        break;
                }
                $ret['addon_features'] = serialize($ret['addon_features']);
                return $ret;
        }
    }
}