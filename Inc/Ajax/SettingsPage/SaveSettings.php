<?php
/*
* AJAX SAVE SETTINGS - CALLBACK
* DESC: save settings and responde
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\Ajax\SettingsPage;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use StrCPVisits_Inc\DB\Options;



class SaveSettings extends Options {



    public function register() {
        add_action( 'wp_ajax_StrCPVisits_save_settings', [$this, 'StrCPVisits_save_settings'] ); // Logged in users
    }




    public function StrCPVisits_save_settings() {


        // Check if data are submited from coresponding form (by using wp_nonce)
        if( !check_ajax_referer( 'StrCPVisits_settings', 'security' ) ) {
            return;
        }


        // Prevent form data submision for none admin users
        if( !current_user_can( 'manage_options' ) ) {
            return;
        }


        // WP AJAX uses data as object and becasue of that serializes data twice.
        // Therefore we need to parse data once more, so we can access them.
        if( isset( $_POST[ 'settings_data' ] ) ) {
            parse_str( $_POST[ 'settings_data' ], $settings_data );
        }




        // CHECKBOX - Do not delete plugin data on plugin delete/uninstall
        if( isset( $settings_data['StrCPVisits-chk-plugin-data'] ) && $settings_data['StrCPVisits-chk-plugin-data'] === "on"){
            // Option turned ON - Do not delete plugin data
            $value = "NO";

        } else {
            // Option turned OFF - Delete plugin data
            $value = "YES";
        }



        // Save all responses data into asoc. array
        $response_data = [];




        // Update DELETE-OPTION-VALUE and SEND AJAX responses
        $response = $this->updateOptionValue( STRCPV_OPT_NAME["delete_plugin_data"], $value );

        if ( $response === true ) {
             $response_data["delete_plugin_data"] = [
                                                         "success" => true,
                                                         "msg" =>esc_html__("Changes saved successfully!", "page-visits-counter-lite"),
                                                     ];
        } else {
            $response_data["delete_plugin_data"] = [
                                                        "success" => false,
                                                        "msg" =>esc_html__("No changes to save...", "page-visits-counter-lite")
                                                    ];
        }




        // // Update ANOTHER-OPTION-VALUE and SEND AJAX responses
        // $response = $this->updateOptionValue( STRCPV_OPT_NAME["delete_plugin_data"], $value );
        //
        // if ( $response === true ) {
        //      $response_data["another_data"] = [
        //                                                  "success" => true,
        //                                                  "msg" =>esc_html__("Changes saved successfully!", "page-visits-counter-lite"),
        //                                              ];
        // } else {
        //     $response_data["another_data"] = [
        //                                                 "success" => false,
        //                                                 "msg" =>esc_html__("No changes to save...", "page-visits-counter-lite")
        //                                             ];
        // }









        wp_send_json_success( $response_data );



        die();

    }// ! save settings()

}// ! class
