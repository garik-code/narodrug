<?php
/* This file has been auto-generated. Do not edit this file directly. */

abstract class Sabai_Addon_PaidListings_Model_Base_OrderItemMetaGateway extends SabaiFramework_Model_Gateway
{
    public function getName()
    {
        return 'paidlistings_orderitemmeta';
    }

    public function getFields()
    {
        return array('orderitemmeta_key' => SabaiFramework_Model::KEY_TYPE_VARCHAR, 'orderitemmeta_value' => SabaiFramework_Model::KEY_TYPE_TEXT, 'orderitemmeta_id' => SabaiFramework_Model::KEY_TYPE_INT, 'orderitemmeta_created' => SabaiFramework_Model::KEY_TYPE_INT, 'orderitemmeta_updated' => SabaiFramework_Model::KEY_TYPE_INT, 'orderitemmeta_orderitem_id' => SabaiFramework_Model::KEY_TYPE_INT);
    }

    protected function _getIdFieldName()
    {
        return 'orderitemmeta_id';
    }

    protected function _getSelectByIdQuery($id, $fields)
    {
        return sprintf(
            'SELECT %s FROM %spaidlistings_orderitemmeta WHERE orderitemmeta_id = %d',
            empty($fields) ? '*' : implode(', ', $fields),
            $this->_db->getResourcePrefix(),
            $id
        );
    }

    protected function _getSelectByIdsQuery($ids, $fields)
    {
        return sprintf(
            'SELECT %s FROM %spaidlistings_orderitemmeta WHERE orderitemmeta_id IN (%s)',
            empty($fields) ? '*' : implode(', ', $fields),
            $this->_db->getResourcePrefix(),
            implode(', ', array_map('intval', $ids))
        );
    }

    protected function _getSelectByCriteriaQuery($criteriaStr, $fields)
    {
        return sprintf(
            'SELECT %1$s FROM %2$spaidlistings_orderitemmeta paidlistings_orderitemmeta WHERE %3$s',
            empty($fields) ? '*' : implode(', ', $fields),
            $this->_db->getResourcePrefix(),
            $criteriaStr
        );
    }

    protected function _getInsertQuery(&$values)
    {
        $values['orderitemmeta_created'] = time();
        $values['orderitemmeta_updated'] = 0;
        return sprintf('INSERT INTO %spaidlistings_orderitemmeta(orderitemmeta_key, orderitemmeta_value, orderitemmeta_id, orderitemmeta_created, orderitemmeta_updated, orderitemmeta_orderitem_id) VALUES(%s, %s, %s, %d, %d, %d)', $this->_db->getResourcePrefix(), $this->_db->escapeString($values['orderitemmeta_key']), $this->_db->escapeString($values['orderitemmeta_value']), empty($values['orderitemmeta_id']) ? 'NULL' : intval($values['orderitemmeta_id']), $values['orderitemmeta_created'], $values['orderitemmeta_updated'], $values['orderitemmeta_orderitem_id']);
    }

    protected function _getUpdateQuery($id, $values)
    {
        $last_update = $values['orderitemmeta_updated'];
        $values['orderitemmeta_updated'] = time();
        return sprintf('UPDATE %spaidlistings_orderitemmeta SET orderitemmeta_key = %s, orderitemmeta_value = %s, orderitemmeta_updated = %d, orderitemmeta_orderitem_id = %d WHERE orderitemmeta_id = %d AND orderitemmeta_updated = %d', $this->_db->getResourcePrefix(), $this->_db->escapeString($values['orderitemmeta_key']), $this->_db->escapeString($values['orderitemmeta_value']), $values['orderitemmeta_updated'], $values['orderitemmeta_orderitem_id'], $id, $last_update);
    }

    protected function _getDeleteQuery($id)
    {
        return sprintf('DELETE FROM %1$spaidlistings_orderitemmeta WHERE orderitemmeta_id = %2$d', $this->_db->getResourcePrefix(), $id);
    }

    protected function _getUpdateByCriteriaQuery($criteriaStr, $sets)
    {
        $sets['orderitemmeta_updated'] = 'orderitemmeta_updated=' . time();
        return sprintf('UPDATE %spaidlistings_orderitemmeta paidlistings_orderitemmeta SET %s WHERE %s', $this->_db->getResourcePrefix(), implode(', ', $sets), $criteriaStr);
    }

    protected function _getDeleteByCriteriaQuery($criteriaStr)
    {
        return sprintf('DELETE paidlistings_orderitemmeta FROM %1$spaidlistings_orderitemmeta paidlistings_orderitemmeta WHERE %2$s', $this->_db->getResourcePrefix(), $criteriaStr);
    }

    protected function _getCountByCriteriaQuery($criteriaStr)
    {
        return sprintf('SELECT COUNT(*) FROM %1$spaidlistings_orderitemmeta paidlistings_orderitemmeta WHERE %2$s', $this->_db->getResourcePrefix(), $criteriaStr);
    }

    protected function _afterInsert1($id, array $new)
    {
    }

    protected function _afterDelete1($id, array $old)
    {
    }

    protected function _afterUpdate1($id, array $new, array $old)
    {
    }

    protected function _afterInsert($id, array $new)
    {
        $this->_afterInsert1($id, $new);
    }

    protected function _afterUpdate($id, array $new, array $old)
    {
        $this->_afterUpdate1($id, $new, $old);
    }

    protected function _afterDelete($id, array $old)
    {
        $this->_afterDelete1($id, $old);
    }
}