<?php
class Sabai_Addon_PaidListings_Model_OrderItemGateway extends Sabai_Addon_PaidListings_Model_Base_OrderItemGateway
{
    public function getByMeta($key, $value)
    {
        $sql = sprintf('
            SELECT oi.* FROM %1$spaidlistings_orderitemmeta oim
            LEFT JOIN %1$spaidlistings_orderitem oi ON oim.orderitemmeta_orderitem_id = oi.orderitem_id
            WHERE oim.orderitemmeta_key = %2$s AND oim.orderitemmeta_value = %3$s',
            $this->_db->getResourcePrefix(),
            $this->_db->escapeString($key),
            $this->_db->escapeString($value)    
        );
        return $this->_db->query($sql);
    }
    
    public function getOrderIdsByMeta($key, array $values)
    {
        $sql = sprintf('
            SELECT oi.orderitem_order_id AS order_id, oim.orderitemmeta_value AS meta_value FROM %1$spaidlistings_orderitemmeta oim
            LEFT JOIN %1$spaidlistings_orderitem oi ON oim.orderitemmeta_orderitem_id = oi.orderitem_id
            WHERE oim.orderitemmeta_key = %2$s AND oim.orderitemmeta_value IN (%3$s)',
            $this->_db->getResourcePrefix(),
            $this->_db->escapeString($key),
            implode(',', array_map(array($this->_db, 'escapeString'), $values))   
        );
        $rs = $this->_db->query($sql);
        $ret = array();
        foreach ($rs as $row) {
            $ret[$row['meta_value']] = $row['order_id'];
        }
        return $ret;
    }
}