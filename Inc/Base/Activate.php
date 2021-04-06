<?php
/**
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\Base;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Activate {



    public static function activate() {
        flush_rewrite_rules();
        self::addOptionDeletePluginData();
    }




    /**
    * ADD OPTION DELETE PLUGIN DATA
    * DESC: If there is no option with given name create it and set default value to YES
    * INFO: Manage/change this option value in setting page
    * PURPOSE: Either leave or delete plugin data on plugin delete/uninstall
    * OPT_VALUES: "NO" || "YES"
    * @since 1.0.0
    */
    public static function addOptionDeletePluginData(){
        $option = get_option( STRCPV_OPT_NAME["delete_plugin_data"] );
        if( $option === false ) {
            // Create option with the given name and set its value to "YES".
            add_option( STRCPV_OPT_NAME["delete_plugin_data"], "YES" );
        }
    }
}
