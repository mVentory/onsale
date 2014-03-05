<?php

class Inchoo_Onsale_Model_Observer
{
    public function getOnSaleCollection($observer)
    {
        $param = Mage::app()->getRequest()->getParam('sale');

        $event = $observer->getEvent();
        $collection = $event->getCollection();

        if(isset($param) && $param==='1'){
            $collection ->addFinalPrice()
                        ->getSelect()
                        ->where('price_index.final_price < price_index.price');
        }
        return $collection;
    }
}
