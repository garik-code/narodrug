<?php
class Sabai_Addon_GoogleMaps extends Sabai_Addon
    implements Sabai_Addon_Form_IFields,
               Sabai_Addon_Field_ITypes,
               Sabai_Addon_Field_IWidgets,
               Sabai_Addon_Field_IRenderers,
               Sabai_Addon_Field_IFilters,
               Sabai_Addon_System_IAdminSettings,
               Sabai_Addon_CSV_IExporters,
               Sabai_Addon_CSV_IImporters
{
    const VERSION = '1.4.9', PACKAGE = 'sabai-googlemaps';
    
    private static $_doneHead = false;
    
    public function csvGetExporterNames()
    {
        return array('googlemaps_marker');
    }
    
    public function csvGetExporter($name)
    {
        require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/CSV/Exporter.php';
        return new Sabai_Addon_GoogleMaps_CSV_Exporter($this->_application, $name);
    }

    public function csvGetImporterNames()
    {
        return array('googlemaps_marker');
    }
    
    public function csvGetImporter($name)
    {
        require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/CSV/Importer.php';
        return new Sabai_Addon_GoogleMaps_CSV_Importer($this->_application, $name);
    }

    public function formGetFieldTypes()
    {
        return array('googlemaps_marker', 'googlemaps_map');
    }

    public function formGetField($name)
    {
        switch ($name) {
            case 'googlemaps_marker':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/LocationFormField.php';
                return new Sabai_Addon_GoogleMaps_LocationFormField($this, $name);
            case 'googlemaps_map':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/MapFormField.php';
                return new Sabai_Addon_GoogleMaps_MapFormField($this, $name);
        }
    }

    public function fieldGetTypeNames()
    {
        return array('googlemaps_marker');
    }

    public function fieldGetType($name)
    {
        switch ($name) {
            case 'googlemaps_marker':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/LocationFieldType.php';
                return new Sabai_Addon_GoogleMaps_LocationFieldType($this, $name);
        }
    }
    
    public function fieldGetFilterNames()
    {
        return array('googlemaps_marker');
    }

    public function fieldGetFilter($name)
    {
        switch ($name) {
            case 'googlemaps_marker':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/LocationFieldFilter.php';
                return new Sabai_Addon_GoogleMaps_LocationFieldFilter($this, $name);
        }
    }
    
    public function fieldGetRendererNames()
    {
        return array('googlemaps_marker', 'googlemaps_map');
    }

    public function fieldGetRenderer($name)
    {
        switch ($name) {
            case 'googlemaps_marker':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/AddressFieldRenderer.php';
                return new Sabai_Addon_GoogleMaps_AddressFieldRenderer($this, $name);
            case 'googlemaps_map':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/MapFieldRenderer.php';
                return new Sabai_Addon_GoogleMaps_MapFieldRenderer($this, $name);
        }
    }

    public function fieldGetWidgetNames()
    {
        return array('googlemaps_marker');
    }

    public function fieldGetWidget($name)
    {
        switch ($name) {
            case 'googlemaps_marker':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/LocationFieldWidget.php';
                return new Sabai_Addon_GoogleMaps_LocationFieldWidget($this, $name);
        }
    }
    
    public function onSabaiWebResponseRenderHtmlLayout(Sabai_Context $context, &$content)
    { 
        if (self::$_doneHead) return;
        
        // The main stylesheet should already have been included by the platform if not requesting the full page content
        if ($context->getContainer() !== '#sabai-content') return;

        $this->_application->LoadCss(
            $this->_application->getPlatform()->isAdmin() ? 'admin.min.css' : 'main.min.css',
            'sabai-googlemaps',
            'sabai',
            'sabai-googlemaps'
        );
        
        self::$_doneHead = true;
    }
    
    public function getDefaultConfig()
    {
        return array(
            'api' => array('type' => 'free'),
        );
    }
    
    public function systemGetAdminSettingsForm()
    {
        return array(
            'api' => array(
                '#tree' => true,
                'no' => array(
                    '#type' => 'checkbox',
                    '#title' => __('Do not load Google Maps API', 'sabai-googlemaps'),
                    '#default_value' => !empty($this->_config['api']['no'])
                ),
                'no_admin' => array(
                    '#type' => 'checkbox',
                    '#title' => __('Do not load Google Maps API in admin dashboard', 'sabai-googlemaps'),
                    '#default_value' => !empty($this->_config['api']['no_admin'])
                ),
                'js_key' => array(
                    '#type' => 'textfield',
                    '#title' => __('Google Maps API browser key', 'sabai-googlemaps'),
                    '#description_no_escape' => true,
                    '#description' => sprintf(__('The API key for Google Maps API can be obtained from the following URL: %s. Make sure Google Maps JavaScript API, Google Maps Geocoding API, Google Places API Web Service, and Google Maps Directions API are enabled for the API key.', 'sabai-googlemaps'), '<code>https://developers.google.com/maps/documentation/javascript/get-api-key</code>'),
                    '#default_value' => isset($this->_config['api']['js_key']) ? $this->_config['api']['js_key'] : (isset($this->_config['api']['key']) ? $this->_config['api']['key'] : null),
                ),
                'key' => array(
                    '#type' => 'textfield',
                    '#title' => __('Google Maps API server key', 'sabai-googlemaps'),
                    '#description_no_escape' => true,
                    '#description' => sprintf(__('The API key for Google Maps API can be obtained from the following URL: %s. Make sure Google Maps Geocoding API is enabled for the API key.', 'sabai-googlemaps'), '<code>https://developers.google.com/maps/documentation/javascript/get-api-key</code>'),
                    '#default_value' => isset($this->_config['api']['key']) ? $this->_config['api']['key'] : null,
                ),
            ),
        );
    }
}