<?php

class Inchoo_Lenses_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getAttributeSetNameById($setId)
    {
        $setName = Mage::getModel("eav/entity_attribute_set")
                       ->getCollection()
                       ->addFieldToFilter("attribute_set_id", $setId)
                       ->getFirstItem()
                       ->getAttributeSetName();

        return $setName;
    }
}