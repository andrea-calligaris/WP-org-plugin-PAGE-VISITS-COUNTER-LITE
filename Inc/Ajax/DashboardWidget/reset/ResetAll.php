<?php
/*
* AJAX RESET ALL VISITS NR - CALLBACK
* DESC: Reset all page visit numbers in option "strcpv_visits_by_page".
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\Ajax\DashboardWidget\reset;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use StrCPVisits_Inc\DB\Options;



class ResetAll extends Options {



    public function register() {
        add_action( 'wp_ajax_StrCPVisits_db_reset_all', [$this, 'StrCPVisits_db_reset_all'] ); // Logged in users
    }




    public function StrCPVisits_db_reset_all() {


        // Check if data are submited from coresponding form (by using wp_nonce)
        if( !check_ajax_referer( 'StrCPVisits_settings', 'security' ) ) {
            return;
        }


        // Prevent form data submision for none admin users
        if( !current_user_can( 'manage_options' ) ) {
            return;
        }


        //  ==== ABORT OR CONTINUE SECTION ====
        // ABORT IF DATA NOT SET
        if( isset( $_POST[ 'data' ] ) ){

            // ABORT IF VALUE NOT "RESET ALL"
            if ( $_POST[ 'data' ] !== "RESET-ALL" ) {
                wp_send_json_error( esc_html__("Reset all error!", "page-visits-counter-lite") );
            }

        } else {
            wp_send_json_error( esc_html__("Error - data not set!", "page-visits-counter-lite") ); // Abort
        }
        // ====  CONTINUE WITHOUT ANY DATA ====



        // UPDATE OPTION VALUE and SEND AJAX RESPONSE
        $response = $this->resetAllPageVisits();

        if ( $response === true ) {
            wp_send_json_success( esc_html__("Changes saved!", "page-visits-counter-lite") );
        } else {
            wp_send_json_error( esc_html__("No changes to save...", "page-visits-counter-lite") );
        }




        die();

    }// ! save settings()

}// ! class
