<?php
class Sabai_Addon_GoogleMaps_Helper_GoogleGeocode extends Sabai_Helper
{
    /**
     * @param Sabai $application
     * @param string $query
     * @param bool $latlng
     * @throw Sabai_RuntimeException
     */
    public function help(Sabai $application, $query, $isLatLng = false, array $params = array())
    {
        $params += array(
            'language' => $application->GoogleMaps_Language(),
            $isLatLng ? 'latlng' : 'address' => $query,
        );
        $url = $application->GoogleMaps_ApiUrl('/maps/api/geocode/json', $params);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!$application->Filter('googlemaps_geocode_curl_ssl_verify', true)) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($result !== false && $http_status == 200) {
            curl_close($ch);
            if ($geocode = json_decode($result)) {
                switch ($geocode->status) {
                    case 'OK':
                        $geometry = $geocode->results[0]->geometry;
                        return array(
                            'lat' => $geometry->location->lat,
                            'lng' => $geometry->location->lng,
                            'address' => $geocode->results[0]->formatted_address,
                            'viewport' => array(
                                $geometry->viewport->southwest->lat,
                                $geometry->viewport->southwest->lng, 
                                $geometry->viewport->northeast->lat,
                                $geometry->viewport->northeast->lng,
                            ),
                        ) + $this->_getAddressComponents($geocode->results[0]->address_components);
                    default:
                        require_once dirname(__FILE__) . '/../GeocodeException.php';
                        $error = isset($geocode->error_message) ? $geocode->error_message : 'An error occurred while querying Google geocoding service.';
                        throw new Sabai_Addon_GoogleMaps_GeocodeException($query, $error . ' Requested URL: ' . $url . ' Returned status: ' . $geocode->status, $geocode->status);
                }
            } else {
                require_once dirname(__FILE__) . '/../GeocodeException.php';
                throw new Sabai_Addon_GoogleMaps_GeocodeException($query, 'Failed parsing result returned from Google gecoding service.');
            }
        } else {
            $curl_error = curl_error($ch);
            curl_close($ch);
            require_once dirname(__FILE__) . '/../GeocodeException.php';
            throw new Sabai_Addon_GoogleMaps_GeocodeException($query, 'Failed requesting Google geocoding service. Returned HTTP status: ' . $http_status . '; Curl error: ' . $curl_error);
        }
    }
    
    protected function _getAddressComponents($components)
    {
        $ret = array('city' => '', 'state' => '', 'zip' => '', 'country' => '');
        foreach ($components as $component) {
            if (in_array('country', $component->types)) {
                $ret['country'] = $component->short_name;
            } elseif (in_array('postal_code', $component->types)) {
                $ret['zip'] = $component->long_name;
            } elseif (in_array('administrative_area_level_1', $component->types)) {
                $ret['state'] = $component->long_name;
            } elseif (in_array('locality', $component->types)) {
                $ret['city'] = $component->long_name;
            } elseif (in_array('sublocality', $component->types)) {
                $ret['city'] = $component->long_name;
            }
        }
        return $ret;
    }
}
