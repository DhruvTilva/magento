<?php
class DT_Vendor_Model_Resource_Vendor_Address extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        //address resource
        $this->_init('vendor/vendor_address' ,'address_id');
    }
}