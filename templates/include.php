<?php
/**
* @package Strongetic - count page visits
*/

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}




/**
* INCLUDE ALL TEMPLATES FILES
*/

// BACKEND
if( file_exists( dirname( __FILE__ ) . '/settings-subpage.php' ) ) {
    require_once dirname(__FILE__) . '/settings-subpage.php';
}


?>
