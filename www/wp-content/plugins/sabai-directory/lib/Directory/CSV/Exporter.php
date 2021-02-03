<?php
class Sabai_Addon_Directory_CSV_Exporter extends Sabai_Addon_CSV_AbstractExporter
{    
    protected function _csvExporterInfo()
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
    
    public function csvExporterSettingsForm(Sabai_Addon_Entity_Model_Field $field, array $settings, $column, $enclosure, array $parents = array())
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
                        '#title' => __('File name/title separator', 'sabai-directory'),
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
                $form += $this->_getZipFileSettingsForm();
                return $form;
            case 'directory_claim':
                switch ($column) {
                    case 'claimed_at':
                    case 'expires_at':
                        return $this->_getDateFormatSettingsForm($parents);
                    case 'claimed_by':
                        return $this->_getUserSettingsForm();
                }
        }
    }
    
    public function csvExporterDoExport(Sabai_Addon_Entity_Model_Field $field, array $settings, $value, array $columns, array &$files)
    {
        switch ($this->_name) {
            case 'directory_rating':
                foreach ($value as $criteria => $rating) {
                    $ret[] = $criteria . $settings['separator'] . $rating;
                }
                return isset($settings['_separator']) ? implode($settings['_separator'], $ret) : $ret[0];
            case 'directory_photos':
                $ret = array();
                $field_name = $field->getFieldName();
                if (!$this->_doZipFile($settings)
                    || !class_exists('ZipArchive', false)
                    || (!$zip = $this->_getZipFile($field_name, $settings))
                ) {
                    foreach ($value as $photo) {
                        if (!$file = $photo->file_image[0]) continue;
                        
                        $ret[] = $file['name'];
                        if (!empty($file['title']) && $file['name'] !== $file['title']) {
                            $ret[] = $file['name'] . $settings['separator'] . $file['title'];
                        } else {
                            $ret[] = $file['name'];
                        }
                    }
                } else {            
                    if (!in_array($zip->filename, $files)) {
                        $files[] = $zip->filename;
                    }
                    $upload_dir = $this->_application->getAddon('File')->getUploadDir();
                    foreach ($value as $photo) {
                        if (!$file = $photo->file_image[0]) continue;
                        
                        if (!empty($file['title']) && $file['name'] !== $file['title']) {
                            $ret[] = $file['name'] . $settings['separator'] . $file['title'];
                        } else {
                            $ret[] = $file['name'];
                        }
                        $file_path = $upload_dir . '/' . $file['name'];
                        $zip->addFile($file_path, $file['name']);
                    }
                    $zip->close();
                }
                return isset($settings['_separator']) ? implode($settings['_separator'], $ret) : $ret[0];
            case 'directory_claim':
                $ret = parent::csvExporterDoExport($field, $settings, $value, $columns, $files);
                if ($settings['claimed_at']['date_format'] === 'string'
                    && false !== ($date = date($settings['claimed_at']['date_format_php'], $ret['claimed_at']))
                ) {
                    $ret['claimed_at'] = $date;
                }
                if ($settings['expires_at']['date_format'] === 'string'
                    && false !== ($date = date($settings['expires_at']['date_format_php'], $ret['expires_at']))
                ) {
                    $ret['expires_at'] = $date;
                }
                if ($settings['claimed_by']['id_format'] === 'username') {
                    if (!empty($ret['claimed_by'])
                        && ($user = $this->_application->UserIdentity($ret['claimed_by']))
                    ) {
                        $ret['claimed_by'] = $user->username; 
                    } else {
                        $ret['claimed_by'] = null;
                    }
                }
                return $ret;
            default:
                return parent::csvExporterDoExport($field, $settings, $value, $columns, $files);
        }
    }
}