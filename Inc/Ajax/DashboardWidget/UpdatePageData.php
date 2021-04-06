<?php
/*
* AJAX UPDATE PAGE DATA - CALLBACK
* DESC: Update page data in option "strcpv_visits_by_page".
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\Ajax\DashboardWidget;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use StrCPVisits_Inc\DB\Options;



class UpdatePageData extends Options {



    public function register() {
        add_action( 'wp_ajax_StrCPVisits_update_page_data', [$this, 'StrCPVisits_update_page_data'] ); // Logged in users
    }




    public function StrCPVisits_update_page_data() {


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


        // NEW NUMBER OF VISTIS
        if( isset( $settings_data['StrCPVisits-dblist-page-visits-nr'] ) ){

            // Is numeric
            if ( is_numeric( $settings_data['StrCPVisits-dblist-page-visits-nr'] ) ) {
                $new_number = sanitize_text_field( $settings_data['StrCPVisits-dblist-page-visits-nr'] );

                // Throw error if number > 1bil.
                if ( $new_number > 1000000000) {
                    wp_send_json_error( esc_html__('Error - number too big!', "page-visits-counter-lite") );
                }

            } else {
                wp_send_json_error( esc_html__('Error - not a number!', "page-visits-counter-lite") ); // Abort
            }

        } else {
            wp_send_json_error( esc_html__('Error - no data set!', "page-visits-counter-lite") ); // Abort
        }


        // PAGE NAME - it should be set - else return error message.
        // INFO: No need for hard core security becasue it is going to be compared with another data.
        if( isset( $settings_data['StrCPVisits-dblist-page-name'] ) ) {
            $page_name = $settings_data['StrCPVisits-dblist-page-name'];
        } else {
            wp_send_json_error( esc_html__('Page name missing!', "page-visits-counter-lite") );
        }



        // UPDATE OPTION VALUE and SEND AJAX RESPONSE
        $response = $this->updatePageVisitsNr( $page_name, $new_number );

        if ( $response === true ) {
            wp_send_json_success( esc_html__("Changes saved!", "page-visits-counter-lite") );
        } else {
            wp_send_json_error( esc_html__("No changes to save...", "page-visits-counter-lite") );
        }




        die();

    }// ! save settings()

}// ! class
