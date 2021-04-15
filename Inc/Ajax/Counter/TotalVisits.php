<?php
/*
* AJAX COUNT TOTAL VISITS - CALLBACK
* DESC: Increase the number of TOTAL INDEPENDENT visits BY ONE.
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\Ajax\Counter;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use StrCPVisits_Inc\DB\Options;



class TotalVisits extends Options {



    public function register() {
        add_action( 'wp_ajax_nopriv_StrCPVisits_update_total_visits', [$this,'StrCPVisits_update_total_visits'] ); // Not logged in users
        add_action( 'wp_ajax_StrCPVisits_update_total_visits', [$this, 'StrCPVisits_update_total_visits'] ); // Logged in users
    }




    public function StrCPVisits_update_total_visits() {


        // DISABLED - so it will work properly if website is cashed
        // // Check if data are submited from coresponding ajax request. (by using wp_nonce)
        // if( !check_ajax_referer( 'StrCPVisits_frontend', 'security' ) ) {
        //     return; // Abort
        // }


        $final_response = [];




        /**
        * $page_name - sanitize
        * INFO: No need for hard core security because it is only going to be compared
        *       with asoc-array keys retrieved from the DB option.
        * VALIDATION: page_name can be anything.
        *             There is no point to restriciting the max nr of characters as it is
        *             only going to be compared with asoc-array keys retrieved from the DB option.
        * @since 1.0.0
        */
        if ( isset( $_POST['page_data']['title'] )) {
            $page_name = sanitize_text_field( $_POST['page_data']['title'] );
        } else {
            $final_response['msg'] = esc_html__("Error - title prop. missing!", "page-visits-counter-lite");
            wp_send_json_success( $final_response ); // Abort
        }





        /**
        * ABORT BY USER TYPE
        * PROBLEM: User can have custom admin roles in use which visits we shouldn't count.
        * SOLUTION: Check by logged out state and for logged in roles that we are going to count.
        * DESC: Count only if is a visitor or logged in role: subscriber, customer, author, contributor, and pending_user.
        *       Do not count if is logged in role: admin, editor, suspended, shop-manager or any other custom role.
        * @since 1.0.0
        */
        if ( is_user_logged_in() ){

            $user_role = wp_get_current_user()->roles[0];
            if ( $user_role != "subscriber" &&      // allow subscriber
                 $user_role != "customer" &&        // allow custome
                 $user_role != "author" &&          // allow author
                 $user_role != "contributor" &&     // allow contributor
                 $user_role != "pending_user") {    // allow pending_user



                     // SET RESPONSES:

                     // Logged in with not counting user role
                     $final_response['msg'] = esc_html__("Logged in with a not counting user role!", "page-visits-counter-lite");
                     // Not counting this page response
                     if ( isset( $_POST['page_data']['abort'] )) {
                         if ( $_POST['page_data']['abort'] === "true" ) {
                             // Set response
                             $final_response['msg_not_counting_the_page'] = esc_html__("Not counting this page!", "page-visits-counter-lite");
                         }
                     }
                     // Get total visits response
                     $final_response['total_visits']['update'] = false;
                     $final_response['total_visits']['nr'] = esc_html( get_option( STRCPV_OPT_NAME['total_visits'] ) );
                     // Get total page visits response
                     $final_response['page_visits'] = false;
                     $final_response['page_visits']['nr'] = esc_html( $this->getVisitsNrByPageName( $page_name ) );

                     wp_send_json_success( $final_response ); // Abort
            }
        }




        // Update total visits number (+1)
        $final_response['total_visits'] = $this->countTotalVisits();




        /**
        * GET REAL USER IP ADDRESS
        * INFO: The purpose of getting the us user ip address is only for checking if page is refreshed.
        *       User IP address is going to be cashed in memory for up to one hour.
        * @since 1.0.0
        */
        if( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }




        /**
        * PAGE DATA - it should be set - else abort
        * DATA TYPE: Asoc. array
        * @since 1.0.0
        */
        if( !isset( $_POST['page_data'] ) ) {
            $final_response['msg'] = esc_html__("Error - Page data missing!", "page-visits-counter-lite");
            wp_send_json_success( $final_response ); // Abort
        }


        // ONLY CHECK - "ABORT" KEY VALUE -  ( If value = true -> abort )
        if ( isset( $_POST['page_data']['abort'] )) {
            if ( $_POST['page_data']['abort'] === "true" ) {
                // Delete transient so if previos site visited or
                // back button clicked it will not count as refresh
                delete_transient('strcpv_page_refreshed_data');
                // Set response
                $final_response['msg'] = esc_html__("Not counting this page!", "page-visits-counter-lite");
                // Respond
                wp_send_json_success( $final_response ); // Abort
            }
        } else {
            $final_response['msg'] = esc_html__("Error - abort prop. missing!", "page-visits-counter-lite");
            wp_send_json_success( $final_response ); // Abort
        }




        /**
        * IS PAGE REFRESHED
        * DESC: If page is refreshed abort and send response with page total visits nr and message.
        * @since 1.0.0
        */
        // CHECK IF PAGE IS REFRESHED in parent class DB/Options
        $page_refreshed = $this->isPageRefreshed( $ip, $page_name );
        // ABORT if page is refreshed
        if ($page_refreshed === true) {
            // GET PAGE VISITS NR
            $page_visits_nr = $this->getVisitsNrByPageName( $page_name );
            // Set final response
            $final_response['page_visits_on_refresh'] = esc_html( $page_visits_nr );
            $final_response['msg'] = esc_html__("Not counting - page refreshed!", "page-visits-counter-lite");
            // Respond
            wp_send_json_success( $final_response ); // ABORT
        }




        // Increase page visit by one
        $final_response['page_visits'] = $this->countVisitsPerPage( $ip, $page_name );




        // Send final response for Total Visits and Page Visits
        wp_send_json_success($final_response);




        die();

    }// ! save settings()
}// ! class
