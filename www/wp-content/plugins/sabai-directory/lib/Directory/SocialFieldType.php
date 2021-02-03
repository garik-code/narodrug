<?php
class Sabai_Addon_Directory_SocialFieldType extends Sabai_Addon_Field_Type_AbstractType implements Sabai_Addon_Field_IPersonalData
{
    protected function _fieldTypeGetInfo()
    {
        return array(
            'label' => 'Social Accounts',
            'default_widget' => $this->_name,
        );
    }

    public function fieldTypeGetSchema(array $settings)
    {
        return array(
            'columns' => array(
                'twitter' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'notnull' => true,
                    'length' => 20,
                    'was' => 'twitter',
                    'default' => '',
                ),
                'facebook' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'notnull' => true,
                    'length' => 255,
                    'was' => 'facebook',
                    'default' => '',
                ),
                'googleplus' => array(
                    'type' => Sabai_Addon_Field::COLUMN_TYPE_VARCHAR,
                    'notnull' => true,
                    'length' => 255,
                    'was' => 'googleplus',
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
            if (strlen((string)@$value['twitter']) || strlen((string)@$value['facebook']) || strlen((string)@$value['googleplus'])) {
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
            'twitter' => __('Twitter', 'sabai'),
            'facebook' => __('Facebook URL', 'sabai'),
            'googleplus' => __('Google+ URL', 'sabai')
        ) as $key => $name) {
            if (!strlen($value[$key])) continue;

            $ret[$key] = array('name' => $name, 'value' => $value[$key]);
        }
        return $ret;
    }

    public function fieldPersonalDataErase(Sabai_Addon_Field_IField $field, Sabai_Addon_Entity_IEntity $entity)
    {
        return true; //delete
    }
}