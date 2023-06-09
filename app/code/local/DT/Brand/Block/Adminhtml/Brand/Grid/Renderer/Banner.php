<?php
class DT_Brand_Block_Adminhtml_Brand_Grid_Renderer_Banner extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $imagePath = $row->getBannerImage();
        $imageUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $imagePath;
        
        return '<img src="' . $imageUrl . '" width="285" height="125" />';
    }
}