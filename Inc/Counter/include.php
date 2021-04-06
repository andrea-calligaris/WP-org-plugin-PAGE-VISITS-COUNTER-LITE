<?php
/**
* @package Strongetic - count page visits
*/

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}




/**
* INCLUDE ALL COUNTER FILES
*/

// BACKEND
if( file_exists( dirname( __FILE__ ) . '/backend/DashboardWidget.php' ) ) {
    require_once dirname(__FILE__) . '/backend/DashboardWidget.php';
}

// FRONTEND
if( file_exists( dirname( __FILE__ ) . '/frontend/CounterBase.php' ) ) {
    require_once dirname(__FILE__) . '/frontend/CounterBase.php';
}

if( file_exists( dirname( __FILE__ ) . '/frontend/TotalVisits.php' ) ) {
    require_once dirname(__FILE__) . '/frontend/TotalVisits.php';
}

// TESTING
if( file_exists( dirname( __FILE__ ) . '/frontend/Crawlers.php' ) ) {
    require_once dirname(__FILE__) . '/frontend/Crawlers.php';
}


?>
