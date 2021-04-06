<?php
/**
* @package Strongetic - count page visits
*/

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}




/**
* INCLUDE ALL include.php files found in Inc sub-folders
* @since 1.0.0
*/


if( file_exists( dirname( __FILE__ ) . '/Base/include.php' ) ) {
require_once dirname(__FILE__) . '/Base/include.php';
}

if( file_exists( dirname( __FILE__ ) . '/Counter/include.php' ) ) {
  require_once dirname(__FILE__) . '/Counter/include.php';
}

if( file_exists( dirname( __FILE__ ) . '/Init.php' ) ) {
  require_once dirname(__FILE__) . '/Init.php';
}

if( file_exists( dirname( __FILE__ ) . '/API/include.php' ) ) {
require_once dirname(__FILE__) . '/API/include.php';
}

if( file_exists( dirname( __FILE__ ) . '/DB/include.php' ) ) {
    require_once dirname(__FILE__) . '/DB/include.php';
}

if( file_exists( dirname( __FILE__ ) . '/Ajax/include.php' ) ) {
    require_once dirname(__FILE__) . '/Ajax/include.php';
}

?>
