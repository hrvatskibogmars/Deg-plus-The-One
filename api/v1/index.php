<?php
/**
 * 
 * PVTistes Mobile API
 * Version: 0.1
 * 
 */
namespace app;
/**
 * Starting point for API.
 * Use Flight framework, WP core and load models for API.
 */
 
// to fix VB API problem with post - error "The file(s) uploaded were too large to process"
define('VB_API', 'allow');

include_once "../../wp-load.php";
include_once '../ApiAutoloader.php';
require 'flight/Flight.php';

/**
 * Include all composed files from autoloader.
 *
 *
 * -> This didn't work from ApiAutoloader class file (which is why it is set here).
 */
foreach(ApiAutoloader::getIncludeFolders() as $include){
    $inc = '..' . $include;
    include_once $inc;
}

/**
 * Define usages
 */
use app\models\NodeFactory;
use app\models\base\BaseNodeModel as BaseNodeModel;
use \Flight as Flight;


#region Web redirect
Flight::route('POST /licitation/add', function(){
    $factory = new NodeFactory();
    $node = $factory->generate( NodeFactory::LICITATION_NODE );
    $data = array(
        "amount" => \Flight::request()->data->amount,
        "tableId" => \Flight::request()->data->tableId,
    );
    $node->put( $data );
    $node->output();
});
#endregion

Flight::start();


/**
 * @return array
 */
function receiveFromInput(){
    $vars = array();
    parse_str(file_get_contents("php://input"),$vars);
    return $vars;
}