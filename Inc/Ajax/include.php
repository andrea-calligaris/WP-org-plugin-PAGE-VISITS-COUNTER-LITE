<?php
/**
* @package Strongetic - count page visits
*/

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
* INCLUDE ALL AJAX FILES
*/




// COUNTER
if( file_exists( dirname( __FILE__ ) . '/Counter/TotalVisits.php' ) ) {
    require_once dirname(__FILE__) . '/Counter/TotalVisits.php';
}




// SETTINGS PAGE
if( file_exists( dirname( __FILE__ ) . '/SettingsPage/SaveSettings.php' ) ) {
    require_once dirname(__FILE__) . '/SettingsPage/SaveSettings.php';
}




// DASHBOARD
if( file_exists( dirname( __FILE__ ) . '/DashboardWidget/UpdateTotalVisitsNr.php' ) ) {
    require_once dirname(__FILE__) . '/DashboardWidget/UpdateTotalVisitsNr.php';
}

if( file_exists( dirname( __FILE__ ) . '/DashboardWidget/UpdatePageData.php' ) ) {
    require_once dirname(__FILE__) . '/DashboardWidget/UpdatePageData.php';
}

if( file_exists( dirname( __FILE__ ) . '/DashboardWidget/DeletePages.php' ) ) {
    require_once dirname(__FILE__) . '/DashboardWidget/DeletePages.php';
}

if( file_exists( dirname( __FILE__ ) . '/DashboardWidget/DeletePage.php' ) ) {
    require_once dirname(__FILE__) . '/DashboardWidget/DeletePage.php';
}

if( file_exists( dirname( __FILE__ ) . '/DashboardWidget/reset/ResetAll.php' ) ) {
    require_once dirname(__FILE__) . '/DashboardWidget/reset/ResetAll.php';
}

if( file_exists( dirname( __FILE__ ) . '/DashboardWidget/reset/ResetPageType.php' ) ) {
    require_once dirname(__FILE__) . '/DashboardWidget/reset/ResetPageType.php';
}

if( file_exists( dirname( __FILE__ ) . '/DashboardWidget/ToggleHiddenReports.php' ) ) {
    require_once dirname(__FILE__) . '/DashboardWidget/ToggleHiddenReports.php';
}

?>
