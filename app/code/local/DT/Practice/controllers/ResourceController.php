<?php
// echo 111; die();
class DT_Practice_ResourceController extends Mage_Core_Controller_Front_Action
{
    
    protected function indexAction()
    {
        echo "<pre>";
        $resource = new Mage_Core_Model_Resource();
        // print_r(get_class_methods($resource));
        // print_r($resource->getConnection('pratice'));
        // print_r($resource->getConnections());
        // print_r($resource->getConnectionTypeInstance('practice'));
        // print_r($resource->getEntity('practice','resource'));
        // print_r($resource)
        // print_r($resource->getTableName('resource'));
        // print_r($resource->createConnection('practice','resource','index'));
        // print_r($resource->getAutoUpdate());


        // ----query----------
        // print_r($resource->getIdxName());

        // print_r($resource->)





        
        
        die();


          

  



    }
}


// Total method present in that array
// Array
// (
//     [0] => getConnection
//     [1] => getConnections
//     [2] => getConnectionTypeInstance
//     [3] => getEntity
//     [4] => getTableName
//     [5] => setMappedTableName
//     [6] => getMappedTableName
//     [7] => cleanDbRow
//     [8] => createConnection
//     [9] => checkDbConnection
//     [10] => getAutoUpdate
//     [11] => setAutoUpdate
//     [12] => getIdxName
//     [13] => getFkName
// )

   