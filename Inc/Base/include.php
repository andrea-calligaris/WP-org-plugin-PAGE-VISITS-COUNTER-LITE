<?php
/**
* @package Strongetic - count page visits
*/

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



/**
* INCLUDE ALL BASE FILES
*/
if( file_exists( dirname( __FILE__ ) . '/Activate.php' ) ) {
    require_once dirname(__FILE__) . '/Activate.php';
}

if( file_exists( dirname( __FILE__ ) . '/Deactivate.php' ) ) {
    require_once dirname(__FILE__) . '/Deactivate.php';
}

if( file_exists( dirname( __FILE__ ) . '/BaseController.php' ) ) {
    require_once dirname(__FILE__) . '/BaseController.php';
}

if( file_exists( dirname( __FILE__ ) . '/Enqueue.php' ) ) {
    require_once dirname(__FILE__) . '/Enqueue.php';
}

if( file_exists( dirname( __FILE__ ) . '/SettingsLinks.php' ) ) {
    require_once dirname(__FILE__) . '/SettingsLinks.php';
}


?>
