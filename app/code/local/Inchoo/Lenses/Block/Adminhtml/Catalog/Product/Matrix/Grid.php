<?php

    class Inchoo_Lenses_Block_Adminhtml_Catalog_Product_Matrix_Grid extends Mage_Adminhtml_Block_Widget_Grid
    {

        /**
         * Set grid params
         *
         */
        public function __construct()
        {
            parent::__construct();
            $this->setId('up_sell_product_grid');
            $this->setDefaultSort('entity_id');
            $this->setUseAjax(true);
            if ($this->_getProduct()->getId()) {
                $this->setDefaultFilter(array('in_products'=>1));
            }
            if ($this->isReadonly()) {
                $this->setFilterVisibility(false);
            }
        }

        /**
         * Retirve currently edited product model
         *
         * @return Mage_Catalog_Model_Product
         */
        protected function _getProduct()
        {
            return Mage::registry('current_product');
        }

        /**
         * Add filter
         *
         * @param object $column
         * @return Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Upsell
         */
        protected function _addColumnFilterToCollection($column)
        {
            // Set custom filter for in product flag
            if ($column->getId() == 'in_products') {
                $productIds = $this->_getSelectedProducts();
                if (empty($productIds)) {
                    $productIds = 0;
                }
                if ($column->getFilter()->getValue()) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
                } else {
                    if($productIds) {
                        $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$productIds));
                    }
                }
            } else {
                parent::_addColumnFilterToCollection($column);
            }
            return $this;
        }

        /**
         * Checks when this block is readonly
         *
         * @return boolean
         */
        public function isReadonly()
        {
            return $this->_getProduct()->getUpsellReadonly();
        }

        /**
         * Prepare collection
         *
         * @return Mage_Adminhtml_Block_Widget_Grid
         */
        protected function _prepareCollection()
        {
            $collection = Mage::getModel('catalog/product_link')->useUpSellLinks()
                              ->getProductCollection()
                              ->setProduct($this->_getProduct())
                              ->addAttributeToSelect('*');

            if ($this->isReadonly()) {
                $productIds = $this->_getSelectedProducts();
                if (empty($productIds)) {
                    $productIds = array(0);
                }
                $collection->addFieldToFilter('entity_id', array('in'=>$productIds));
            }

            $this->setCollection($collection);
            return parent::_prepareCollection();
        }

        /**
         * Add columns to grid
         *
         * @return Mage_Adminhtml_Block_Widget_Grid
         */
        protected function _prepareColumns()
        {
            if (!$this->_getProduct()->getUpsellReadonly()) {
                $this->addColumn('in_products', array(
                    'header_css_class' => 'a-center',
                    'type'      => 'checkbox',
                    'name'      => 'in_products',
                    'values'    => $this->_getSelectedProducts(),
                    'align'     => 'center',
                    'index'     => 'entity_id'
                ));
            }

            $this->addColumn('type', array(
                'header'    => Mage::helper('catalog')->__('Power'),
                'width'     => 100,
                'index'     => 'type_id',
                'type'      => 'options',
                'sortable'  => 'true',
                'options'   => Mage::getSingleton('catalog/product_type')->getOptionArray(),
            ));

            $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
                        ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
                        ->load()
                        ->toOptionHash();

            $this->addColumn('set_name', array(
                'header'    => Mage::helper('catalog')->__('Diameter'),
                'width'     => 130,
                'index'     => 'attribute_set_id',
                'type'      => 'options',
                'options'   => $sets,
            ));

            $this->addColumn('status', array(
                'header'    => Mage::helper('catalog')->__('Base Curve'),
                'width'     => 90,
                'index'     => 'status',
                'type'      => 'options',
                'options'   => Mage::getSingleton('catalog/product_status')->getOptionArray(),
            ));

            $this->addColumn('sku', array(
                'header'    => Mage::helper('catalog')->__('SKU Extension'),
                'width'     => 80,
                'index'     => 'sku'
            ));


            //$this->addExportType('*/*/exportInchooCsv', $Mage::helper('catalog')->__('CSV'));
            //$this->addExportType('*/*/exportInchooExcel', $Mage::helper('catalog')->__('Excel XML'));
            // @TODO: fix export types
            return parent::_prepareColumns();
        }

        /**
         * Rerieve grid URL
         *
         * @return string
         */
        public function getGridUrl()
        {
            return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/upsellGrid', array('_current'=>true));
            // @TODO: fix grid action when an option is checked
        }

        /**
         * Retrieve selected upsell products
         *
         * @return array
         */
        protected function _getSelectedProducts()
        {
            $products = $this->getProductsUpsell();
            if (!is_array($products)) {
                $products = array_keys($this->getSelectedUpsellProducts());
            }
            return $products;
        }

        /**
         * Retrieve upsell products
         *
         * @return array
         */
        public function getSelectedUpsellProducts()
        {
            $products = array();
            foreach (Mage::registry('current_product')->getUpSellProducts() as $product) {
                $products[$product->getId()] = array('position' => $product->getPosition());
            }
            return $products;
        }

    }
