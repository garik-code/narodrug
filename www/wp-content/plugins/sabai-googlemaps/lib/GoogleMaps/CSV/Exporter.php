<?php
class Sabai_Addon_GoogleMaps_CSV_Exporter extends Sabai_Addon_CSV_AbstractExporter
{    
    protected function _csvExporterInfo()
    {
        switch ($this->_name) {
            case 'googlemaps_marker':
                return array(
                    'field_types' => array('googlemaps_marker'),
                    'columns' => array(
                        'address' => __('Full Address', 'sabai-googlemaps'),
                        'street' => __('Address Line 1', 'sabai-googlemaps'),
                        'city' => __('City', 'sabai-googlemaps'),
                        'state' => __('State / Province / Region', 'sabai-googlemaps'),
                        'zip' => __('Postal / Zip Code', 'sabai-googlemaps'),
                        'country' => __('Country', 'sabai-googlemaps'),
                        'lat' => __('Latitude', 'sabai-googlemaps'),
                        'lng' => __('Longitude', 'sabai-googlemaps'),
                    ),
                );
        }
    }
    
    public function csvExporterSettingsForm(Sabai_Addon_Entity_Model_Field $field, array $settings, $column, $enclosure, array $parents = array())
    {   
        switch ($this->_name) {
            case 'googlemaps_marker':
                return $this->_acceptMultipleValues($enclosure, $parents);
        }
    }
    
    public function csvExporterDoExport(Sabai_Addon_Entity_Model_Field $field, array $settings, $value, array $columns, array &$files)
    {
        switch ($this->_name) {
            case 'googlemaps_marker':
                $ret = array();
                foreach ($columns as $column) {
                    if (!isset($settings[$column]['_separator'])) {
                        $ret[$column] = $value[0][$column];
                    } else {
                        foreach ($value as $i => $_value) {
                            $ret[$column][$i] = $_value[$column];
                        }
                        $ret[$column] = implode($settings[$column]['_separator'], $ret[$column]);
                    }
                }
                return $ret;
        }
    }
}