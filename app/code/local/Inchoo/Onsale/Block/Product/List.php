<?php

class Inchoo_Onsale_Block_Product_List extends Mage_Catalog_Block_Product_List
{
    public function getOnSaleCollection(){
        $param = Mage::app()->getRequest()->getParam('sale');

        if(isset($param) && $param==='1'){
            $_productCollection = $this->getLoadedProductCollection()
                                        ->clear()
            ;

            $_productCollection->getSelect()
                                ->where('price_index.final_price < price_index.price');
        }else
        {
            $_productCollection=$this->getLoadedProductCollection();
        }
        return $_productCollection;
    }
}
