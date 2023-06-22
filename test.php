<?php
require_once('app/Mage.php');

umask(0);
Mage::app();


// enable user error handling
libxml_use_internal_errors(true);

// adjust template path
$dir = "app/design/adminhtml/default/default/layout/*";

foreach(glob($dir) as $file) {
    $xml = simplexml_load_file($file);
    foreach (libxml_get_errors() as $error) {
        print_r($error);
        // Mage::log($error);
    echo 123;
    }
    libxml_clear_errors();
}