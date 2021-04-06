<?php
/*
* AJAX DELETE PAGE - CALLBACK
* DESC: delete page from option "strcpv_visits_by_page" with all its data and respond.
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\Ajax\DashboardWidget;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use StrCPVisits_Inc\DB\Options;



class DeletePage extends Options {



    public function register() {
        add_action( 'wp_ajax_StrCPVisits_delete_page', [$this, 'StrCPVisits_delete_page'] ); // Logged in users
    }




    public function StrCPVisits_delete_page() {


        // Check if data are submited from coresponding form (by using wp_nonce)
        if( !check_ajax_referer( 'StrCPVisits_settings', 'security' ) ) {
            return;
        }


        // Prevent form data submision for none admin users
        if( !current_user_can( 'manage_options' ) ) {
            return;
        }


        /**
        * PAGE NAME - it should be set - else return an error message
        * INFO: No need for hard core security because it is only going to be compared
        *       with asoc-array keys retrieved from the DB option.
        * VALIDATION: page_name can be anything.
        *             There is no point to restriciting the max nr of characters as it is
        *             only going to be compared with asoc-array keys retrieved from the DB option.
        * @since 1.0.0
        */
        if( isset( $_POST['page_name'] ) ) {
            $page_name = sanitize_text_field( $_POST['page_name'] );
        } else {
            wp_send_json_error( esc_html__("Error - Page name missing!", "page-visits-counter-lite") ); // Abort
        }


        // DELETE PAGE FROM OPTION VALUE and SEND AJAX RESPONSE
        $response = $this->deletePageFromOptionValue( $page_name );

        if ( $response === true ) {
            wp_send_json_success( esc_html__("Page deleted!", "page-visits-counter-lite") );
        } else {
            wp_send_json_error( esc_html__("There was an error!", "page-visits-counter-lite") );
        }




        die();

    }// ! save settings()

}// ! class
