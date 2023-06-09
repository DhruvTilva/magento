<?php

class DT_Brand_Block_Brand extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getBrands()
    {
        $brands = Mage::getModel('brand/brand')->getCollection();
        $brands->addFieldToFilter('status',1);
        $brands->setOrder('sort_order','ASC');
        return $brands;
    }

    public function getBrand()
    {
        $brandId = $this->getRequest()->getParam('brand_id');
        $brand = Mage::getModel('brand/brand')->load($brandId);
        return $brand;
    }

    public function getProductsByBrand()
    {

        $brandAttributeCode = 'brand';
        $brandAttribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $brandAttributeCode);

        $brandValue = $this->getRequest()->getParam('brand_id');
        $productCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter($brandAttributeCode, $brandValue)
            ->getAllIds();

        $products = Mage::getModel('catalog/product')->getCollection()
            ->addIdFilter($productCollection)
            ->addAttributeToSelect('*');
        return $products;
    }

    public function getProductUrl($product)
    {
        $productId = $product->getId(); 
        $rewrite = Mage::getModel('core/url_rewrite')->load($productId,'product_id');
        $requestPath = $rewrite->getRequestPath();
        return $requestPath;
    }

}