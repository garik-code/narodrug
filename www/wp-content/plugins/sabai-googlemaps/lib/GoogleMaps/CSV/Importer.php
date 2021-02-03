<?php
class Sabai_Addon_GoogleMaps_CSV_Importer extends Sabai_Addon_CSV_AbstractImporter
{
    protected static $_geocodeCount = 0;
    
    protected function _csvImporterInfo()
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
    
    public function csvImporterSettingsForm(Sabai_Addon_Entity_Model_Field $field, array $settings, $column, $enclosure, array $parents = array())
    {
        switch ($this->_name) {
            case 'googlemaps_marker':
                $form = array();
                if ($column === 'address') {
                    $form += array(
                        'geocode' => array(
                            '#type' => 'checkbox',
                            '#title' => __('Geocode address', 'sabai-googlemaps'),
                            '#description' => __('Use the Google geocoding service to resolve the latitude/longitude coordinate from the address. This will populate all other address components of the field.', 'sabai-googlemaps'),
                            '#default_value' => true,
                            '#horizontal' => true,
                        ),
                    );
                }
                return $form + $this->_acceptMultipleValues($enclosure, $parents);
        }
    }
    
    public function csvImporterDoImport(Sabai_Addon_Entity_Model_Field $field, array $settings, $column, $value)
    {
        switch ($this->_name) {
            case 'googlemaps_marker':
                if (!empty($settings['_multiple'])) {
                    if (!$values = explode($settings['_separator'], $value)) {
                        return;
                    }
                } else {
                    $values = array($value);
                }
                $ret = array();
        
                switch ($column) {
                    case 'address':
                        foreach ($values as $value) {
                            $value = trim($value);
                            if (!strlen($value)) continue;

                            $value = array(
                                'address' => $value,
                            );
                            if ($settings['geocode']) {
                                try {
                                    $geocode_result = $this->_application->GoogleMaps_GoogleGeocode($value['address']);
                                } catch (Sabai_Addon_Google_GeocodeException $e) {
                                    $this->_application->LogError($e);
                                    continue;
                                }
                                $value += array(
                                    'city' => $geocode_result['city'],
                                    'state' => $geocode_result['state'],
                                    'zip' => $geocode_result['zip'],
                                    'country' => $geocode_result['country'],
                                    'lat' => $geocode_result['lat'],
                                    'lng' => $geocode_result['lng'],
                                );
                                ++self::$_geocodeCount;
                                if (self::$_geocodeCount % 10 === 0) {
                                    sleep(1); // this is to prevent rate limit of 10 requests per second
                                }
                            }
                            $ret[] = $value;
                        }
                        break;
                    default:
                        foreach ($values as $value) {
                            $ret[] = array($column => $value);
                        }
                }
        
                return $ret;
        }
    }
}