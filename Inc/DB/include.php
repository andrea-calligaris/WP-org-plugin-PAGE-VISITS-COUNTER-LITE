<?php
/**
* @package Strongetic - count page visits
*/

/**
* INCLUDE ALL API FILES
*/

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}




// BACKEND
if( file_exists( dirname( __FILE__ ) . '/Options.php' ) ) {
    require_once dirname(__FILE__) . '/Options.php';
}


?>
