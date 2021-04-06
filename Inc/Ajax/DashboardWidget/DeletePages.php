<?php
/*
* AJAX DELETE PAGES - CALLBACK
* DESC: Delete all selected pages from option "strcpv_visits_by_page" with all its data and respond.
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\Ajax\DashboardWidget;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use StrCPVisits_Inc\DB\Options;



class DeletePages extends Options {



    public function register() {
        add_action( 'wp_ajax_StrCPVisits_delete_pages', [$this, 'StrCPVisits_delete_pages'] ); // Logged in users
    }




    public function StrCPVisits_delete_pages() {


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





        // DELETE PAGE-S FROM OPTION VALUE and SEND AJAX RESPONSE
        $response = $this->deletePagesFromOptionValue( $page_names_arr );

        if ( $response === true ) {
            wp_send_json_success( esc_html__("Pages deleted!", "page-visits-counter-lite") );
        } else {
            wp_send_json_error( esc_html__("There was an error!", "page-visits-counter-lite") );
        }




        die();

    }// ! save settings()

}// ! class
