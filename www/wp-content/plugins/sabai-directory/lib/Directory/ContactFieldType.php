<?php
class Sabai_Addon_Directory_ContactFieldType extends Sabai_Addon_Field_Type_AbstractType implements Sabai_Addon_Field_IPersonalData, Sabai_Addon_Field_IPersonalDataIdentifier
{
    protected function _fieldTypeGetInfo()
    {
        return array(
            'label' => 'Contact Info',
            'default_renderer' => $this->_name,
            'default_widget' => $this->_name,
        );
    }

    public function fieldTypeGetSchema(array $settings)
    {
        return array(
            'columns' => array(
                'phone' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'notnull' => true,
                    'length' => 50,
                    'was' => 'phone',
                    'default' => '',
                ),
                'mobile' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'notnull' => true,
                    'length' => 50,
                    'was' => 'mobile',
                    'default' => '',
                ),
                'fax' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'notnull' => true,
                    'length' => 50,
                    'was' => 'fax',
                    'default' => '',
                ),
                'email' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'notnull' => true,
                    'length' => 100,
                    'was' => 'email',
                    'default' => '',
                ),
                'website' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'notnull' => true,
                    'length' => 255,
                    'was' => 'website',
                    'default' => '',
                ),
            ),
        );
    }

    public function fieldTypeOnSave(Sabai_Addon_Field_IField $field, array $values, array $currentValues = null)
    {
        $ret = array();
        foreach ($values as $weight => $value) {
            if (!is_array($value)) {
                continue;
            }
            if (strlen((string)@$value['phone']) || strlen((string)@$value['mobile']) || strlen((string)@$value['fax']) || strlen((string)@$value['email']) || strlen((string)@$value['website'])) {
                $ret[] = $value;
            }
        }
        return $ret;
    }

    public function fieldPersonalDataExport(Sabai_Addon_Field_IField $field, Sabai_Addon_Entity_IEntity $entity)
    {
        if (!$value = $entity->getSingleFieldValue($field->getFieldName())) return;

        $ret = array();
        foreach (array(
            'phone' => __('Phone Number', 'sabai'),
            'mobile' => __('Mobile Number', 'sabai'),
            'fax' => __('Fax Number', 'sabai'),
            'email' => __('E-mail', 'sabai'),
            'website' => __('Website', 'sabai')
        ) as $key => $name) {
            if (!strlen($value[$key])) continue;

            $ret[$key] = array('name' => $name, 'value' => $value[$key]);
        }
        return $ret;
    }

    public function fieldPersonalDataErase(Sabai_Addon_Field_IField $field, Sabai_Addon_Entity_IEntity $entity)
    {
        if (!$value = $entity->getSingleFieldValue($field->getFieldName())) return true; // delete

        return array(
            'phone' => strlen($value['phone']) ? $this->_addon->getApplication()->getPlatform()->anonymizeText($value['phone']) : '',
            'mobile' => strlen($value['mobile']) ? $this->_addon->getApplication()->getPlatform()->anonymizeText($value['mobile']) : '',
            'fax' => strlen($value['fax']) ? $this->_addon->getApplication()->getPlatform()->anonymizeText($value['fax']) : '',
            'email' => strlen($value['email']) ? $this->_addon->getApplication()->getPlatform()->anonymizeEmail($value['email']) : '',
            'website' => strlen($value['website']) ? $this->_addon->getApplication()->getPlatform()->anonymizeUrl($value['website']) : '',
        );
    }

    public function fieldPersonalDataQuery(Sabai_Addon_Field_IQuery $query, $fieldName, $email, $userId)
    {
        $query->fieldIs($fieldName, $email, 'email');
    }

    public function fieldPersonalDataAnonymize(Sabai_Addon_Field_IField $field, Sabai_Addon_Entity_IEntity $entity)
    {
        $value = $entity->getSingleFieldValue($field->getFieldName());
        return array(
            'phone' => strlen($value['phone']) ? $this->_addon->getApplication()->getPlatform()->anonymizeText($value['phone']) : '',
            'mobile' => strlen($value['mobile']) ? $this->_addon->getApplication()->getPlatform()->anonymizeText($value['mobile']) : '',
            'fax' => strlen($value['fax']) ? $this->_addon->getApplication()->getPlatform()->anonymizeText($value['fax']) : '',
            'email' => $this->_addon->getApplication()->getPlatform()->anonymizeEmail($value['email']),
            'website' => strlen($value['url']) ? $this->_addon->getApplication()->getPlatform()->anonymizeUrl($value['website']) : '',
        );
    }
}