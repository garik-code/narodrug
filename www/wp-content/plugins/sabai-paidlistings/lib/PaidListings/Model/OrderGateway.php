<?php
class Sabai_Addon_PaidListings_Model_OrderGateway extends Sabai_Addon_PaidListings_Model_Base_OrderGateway
{
    public function getStatusCountByCriteria(SabaiFramework_Criteria $criteria)
    {
        $criterions = array();
        $criteria->acceptVisitor($this, $criterions);
        $sql = sprintf('
            SELECT order_status, COUNT(*) AS cnt FROM %1$spaidlistings_order WHERE %2$s GROUP BY order_status',
            $this->_db->getResourcePrefix(),
            implode(' ', $criterions)
        );
        $rs = $this->_db->query($sql);
        $ret = array();
        foreach ($rs as $row) {
            $ret[$row['order_status']] = $row['cnt'];
        }
        return $ret;
    }
}