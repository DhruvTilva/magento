<?php

/**
 * 
 */
class Ccc_Practice_Block_Adminhtml_Four_Renderer_Thumb extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract        
{
    
    function render($row)
    {
        $name = $row->getThumbnail();
        $path = Mage::getBaseUrl('media').DS.'catalog/product'.DS.$name;
        $path = "<img src='$path' alt='img' width='50' height='60'>";
        return $path;
    }
}