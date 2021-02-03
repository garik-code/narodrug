<?php
class Sabai_Addon_Directory_Model_ClaimGateway extends Sabai_Addon_Directory_Model_Base_ClaimGateway
{
    public function getStatusCountByCriteria(SabaiFramework_Criteria $criteria)
    {
        $criterions = array();
        $criteria->acceptVisitor($this, $criterions);
        $sql = sprintf('
            SELECT claim_status, COUNT(*) AS cnt FROM %1$sdirectory_claim WHERE %2$s GROUP BY claim_status',
            $this->_db->getResourcePrefix(),
            implode(' ', $criterions)
        );
        $rs = $this->_db->query($sql);
        $ret = array();
        foreach ($rs as $row) {
            $ret[$row['claim_status']] = $row['cnt'];
        }
        return $ret;
    }
}