<?php
/**
*  Triger this file on Plugin uninstall
*
*  @package Strongetic - count page visits
*/

//if uninstall not called from WordPress exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}




// Clear Database stored data
STRCPV_deletePluginData();




/**
* DELETE PLUGIN DATA
* DESC: Delete plugin data if settings option
*       "Do not delete plugin data on plugin delete/uninstall" is unchecked.
* @since 1.0.0
*/
function STRCPV_deletePluginData(){

    // Check "Do not delete plugin data on plugin delete/uninstall" option value
    $delete_plugin_data = get_option( 'strcpv_delete_plugin_data' );
    if ( $delete_plugin_data === "NO") {
        return ; // Abort
    }

    // DELETE OPTIONS
    delete_option( 'strcpv_total_visits' );
    delete_option( 'strcpv_visits_by_page' );
    delete_option( 'strcpv_hidden_page_reports' );
    delete_option( 'strcpv_count_refresh' );
    delete_option( 'strcpv_delete_plugin_data' );

    // DELETE TRANSIENTS
    delete_transient('strcpv_page_refreshed_data');
}
?>
