<?php
class Sabai_Addon_Directory_CSV_Importer extends Sabai_Addon_CSV_AbstractImporter
{
    protected $_photos;
    
    protected function _csvImporterInfo()
    {
        switch ($this->_name) {
            case 'directory_contact':
                $columns = array(
                    'phone' => __('Phone Number', 'sabai-directory'),
                    'mobile' => __('Mobile Number', 'sabai-directory'),
                    'fax' => __('Fax Number', 'sabai-directory'),
                    'email' => __('E-mail Address', 'sabai-directory'),
                    'website' => __('Website', 'sabai-directory'),
                );
                break;
            case 'directory_social':
                $columns = array(
                    'twitter' => __('Twitter', 'sabai-directory'),
                    'facebook' => __('Facebook URL', 'sabai-directory'),
                    'googleplus' => __('Google+ URL', 'sabai-directory'),
                );
                break;
            case 'directory_claim':
                $columns = array(
                    'claimed_at' => __('Claim Date', 'sabai-directory'),
                    'expires_at' => __('End Date', 'sabai-directory'),
                    'claimed_by' => __('Owner', 'sabai-directory'),
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
            case 'directory_rating':
                $form = array(
                    'separator' => array(
                        '#type' => 'textfield',
                        '#title' => __('Rating criteria/value separator', 'sabai-directory'),
                        '#description' => __('Enter the character used to separate the rating criteria and value.', 'sabai-directory'),
                        '#default_value' => '|',
                        '#horizontal' => true,
                        '#min_length' => 1,
                        '#required' => true,
                        '#weight' => 1,
                    ),
                );
                return $form + $this->_acceptMultipleValues($enclosure, $parents, array('separator' => $form['separator']['#title']));
            case 'directory_photos':
                $form = array(
                    'separator' => array(
                        '#type' => 'textfield',
                        '#title' => $title = __('File name/title separator', 'sabai-directory'),
                        '#description' => __('Enter the character used to separate the file name and title.', 'sabai-directory'),
                        '#default_value' => '|',
                        '#horizontal' => true,
                        '#min_length' => 1,
                        '#required' => true,
                        '#weight' => 1,
                        '#size' => 5,
                    ),
                );
                $form += $this->_acceptMultipleValues($enclosure, $parents, array('separator' => $form['separator']['#title']));
                $form += $this->_application->File_LocationSettingsForm($parents);
                return $form;
            case 'directory_claim':
                switch ($column) {
                    case 'claimed_at':
                    case 'expires_at':
                        return $this->_getDateFormatSettingsForm($parents);
                }
        }
    }
    
    public function csvImporterDoImport(Sabai_Addon_Entity_Model_Field $field, array $settings, $column, $value)
    {
        switch ($this->_name) {
            case 'directory_rating':
                if (!empty($settings['_multiple'])) {
                    if (!$values = explode($settings['_separator'], $value)) {
                        return;
                    }
                } else {
                    $values = array($value);
                }
                $ret = array();
                foreach ($values as $value) {
                    if ($value = explode($settings['separator'], $value)) {
                        $ret[(string)$value[0]] = $value[1];
                    }
                }
                return $ret;
            case 'directory_photos':
                if (!empty($settings['_multiple'])) {
                    if (!$values = explode($settings['_separator'], $value)) {
                        return;
                    }
                } else {
                    $values = array($value);
                }
                $files = array();
                foreach ($values as $value) {
                    if ($value = explode($settings['separator'], $value)) {
                        $files[] = array(
                            'name' => $value[0],
                            'title' => isset($value[1]) ? $value[1] : '',
                        );
                    }
                }
                if (empty($files)) return;

                if ($settings['location'] === 'none') {
                    $photos = $this->_application->File_LocationSettingsForm_saveFiles($settings, $files);
                } else {     
                    if (!isset($this->_fileDir)) {
                        if (!$this->_fileDir = $this->_application->File_LocationSettingsForm_uploadDir($settings)) {
                            $this->_fileDir = false;
                        }
                    }
                    if (!$this->_fileDir) return;
                    
                    $photos = $this->_application->File_LocationSettingsForm_saveFiles(
                        $settings,
                        $files,
                        array('image_only' => true),
                        $this->_fileDir
                    );
                }
                return array('_photos' => $photos);
            case 'directory_claim':
                if (in_array($column, array('claimed_at', 'expires_at'))) {
                    if ($settings['date_format'] === 'string'
                        && false === ($value = strtotime($value))
                    ) {
                        return null;
                    }
                }
                return array(array($column => $value));
            default:
                return parent::csvImporterDoImport($field, $settings, $column, $value);
        }
    }
    
    public function getPhotos()
    {
        return $this->_photos;
    }
}