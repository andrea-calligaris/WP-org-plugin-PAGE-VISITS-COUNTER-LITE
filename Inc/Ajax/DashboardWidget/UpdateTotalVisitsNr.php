<?php
/*
* AJAX UPDATE TOTAL VISITS NR - CALLBACK
* DESC: Update total visits data in option "strcpv_total_visits".
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\Ajax\DashboardWidget;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use StrCPVisits_Inc\DB\Options;



class UpdateTotalVisitsNr extends Options {



    public function register() {
        add_action( 'wp_ajax_StrCPVisits_update_total_visits_nr', [$this, 'StrCPVisits_update_total_visits_nr'] ); // Logged in users
    }




    public function StrCPVisits_update_total_visits_nr() {


        // Check if data are submited from coresponding form (by using wp_nonce)
        if( !check_ajax_referer( 'StrCPVisits_settings', 'security' ) ) {
            return;
        }


        // Prevent form data submision for none admin users
        if( !current_user_can( 'manage_options' ) ) {
            return;
        }


        // NEW NUMBER OF VISTIS
        if( isset( $_POST[ 'data' ] ) ){

            // Is numeric
            if ( is_numeric( $_POST[ 'data' ] ) ) {
                $new_number = sanitize_text_field( $_POST[ 'data' ] );

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




        // UPDATE OPTION VALUE and SEND AJAX RESPONSE
        $response = $this->updateOptionValue( STRCPV_OPT_NAME['total_visits'], $new_number);

        if ( $response === true ) {
            wp_send_json_success( esc_html__("Changes saved!", "page-visits-counter-lite") );
        } else {
            wp_send_json_error( esc_html__("No changes to save...", "page-visits-counter-lite") );
        }




        die();

    }// ! save settings()

}// ! class
