<?php
/*
* AJAX TOGGLE HIDDEN REPORTS - CALLBACK
* DESC: Set selected page-reports as hiden and viceversa in option named "strcpv_hidden_page_reports".
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\Ajax\DashboardWidget;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use StrCPVisits_Inc\DB\Options;



class ToggleHiddenReports extends Options {



    public function register() {
        add_action( 'wp_ajax_StrCPVisits_db_toggle_hidden_reports', [$this, 'StrCPVisits_db_toggle_hidden_reports'] ); // Logged in users
    }




    public function StrCPVisits_db_toggle_hidden_reports() {

        // Check if data are submited from coresponding form (by using wp_nonce)
        if( !check_ajax_referer( 'StrCPVisits_settings', 'security' ) ) {
            return;
        }


        // Prevent form data submision for none admin users
        if( !current_user_can( 'manage_options' ) ) {
            return;
        }


        // ABORT IF DATA NOT SET
        if( !isset( $_POST[ 'data' ] ) ){
            wp_send_json_error( esc_html__("Error - data not set!", "page-visits-counter-lite") ); // Abort
        }

        // ABORT IF IS NOT ARRAY
        if ( !is_array( $_POST[ 'data' ] ) ) {
            wp_send_json_error( esc_html__("Error - not array!", "page-visits-counter-lite") ); // Abort
        }

        // CREATE NEW ARRAY and SANITIZE EACH VALUE
        $page_names_arr = [];
        foreach ( $_POST[ 'data' ] as $page_name ) {
            /**
            * PAGE NAME
            * INFO: No need for hard core security because it is only going to be compared
            *       with asoc-array keys retrieved from the DB option.
            * VALIDATION: page_name can be anything.
            *             There is no point to restriciting the max nr of characters as it is
            *             only going to be compared with asoc-array keys retrieved from the DB option.
            * @since 1.0.0
            */
            $page_name = sanitize_text_field( $page_name );
            array_push( $page_names_arr, $page_name );
        }




        // CHECK LIST TYPE - HIDDEN OR VISIBLE
        if( !isset( $_POST[ 'list' ] ) ){
            wp_send_json_error( esc_html__("Error - data not set!", "page-visits-counter-lite") ); // Abort
        }


        if ( $_POST[ 'list' ] === "hidden" ) {

            // SET AS HIDDEN
            $response = $this->setAsHiddenReports( $page_names_arr );

        } else if( $_POST[ 'list' ] === "visible" ){

            // REMOVE FROM HIDDEN
            $response = $this->removeFromHiddenReports( $page_names_arr );

        } else {
            // ABORT
            wp_send_json_error( esc_html__("Error - not expected value!", "page-visits-counter-lite") );
        }




        // SEND AJAX RESPONSE
        if ( $response === true ) {
            wp_send_json_success( esc_html__("Success!", "page-visits-counter-lite") );
        } else {
            wp_send_json_error( esc_html__("There was an error!", "page-visits-counter-lite") );
        }




        die();

    }// ! save settings()

}// ! class
