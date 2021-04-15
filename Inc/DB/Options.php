<?php
/*
* DATABASE MANGE OPTIONS
* DESC: Save settings and responde
* INFO: Used for Ajax requests
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\DB;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class Options {


    /**
    * UPDATE OPTION VALUE
    * DESC: Update option value and respond with TRUE on update success.
    *       Else respond with FALSE.
    * @since 1.0.0
    */

    public function updateOptionValue( $option_name, $value ) {
        $response = update_option( $option_name, $value );
        return $response; // TRUE || FALSE
    }




    /**
    * GET VISITS-BY-PAGE DATA
    * DESC: Retrieve serialized data from option visits_by_page and unserialize them.
    * RETURNS: An array - ['page-name1' => vistis_nr1, 'page-name2'=>visits_nr2, ... ]
    * @since 1.0.0
    */
    public function getVisitsByPageData(){
        $data_ser = get_option( STRCPV_OPT_NAME['visits_by_page'] );
        if ($data_ser === false) {
            return [];
        } else {
            return maybe_unserialize( $data_ser );
        }
    }




    /**
    * SET VISITS-BY-PAGE DATA
    * DESC: Accept data_array argument and serialize it before updating option visits_by_page
    * @param $data_arr  -  ['page-name1' => vistis_nr1, 'page-name2'=>visits_nr2, ... ]
    * @since 1.0.0
    */
    public function setVisitsByPageData( $data_arr ){
        // Serialize data
        $data_ser = maybe_serialize( $data_arr );
        // UPDATE OPTION
        $response = $this->updateOptionValue( STRCPV_OPT_NAME['visits_by_page'], $data_ser);
        return $response; // TRUE || FALSE
    }




    /**
    * GET VISITS NR BY PAGE NAME
    * DESC: Retrieve page visits nr from visits_by_page option.
    * RETURNS: Nr of visits || NULL
    * @since 1.0.0
    * Last update:  1.1.0 ( ADDED - if array key exist and if not - return null )
    */
    public function getVisitsNrByPageName( $page_name ){
        // Retrieve serialized data from option visits_by_page and unserialize them.
        $page_visits_arr = $this->getVisitsByPageData();
        if ( array_key_exists( $page_name, $page_visits_arr ) ){
            return $page_visits_arr[ $page_name ];
        }
        // Page name doesn't exist as key in array
        return null;
    }





    /**
    * DELETE PAGE FROM OPTION VALUE - option "strcpv_visits_by_page"
    * DESC: Retrieve visits_by_page option data and remove key with page name.
    *       Update option value with updated asoc array.
    * @since 1.0.0
    */
    public function deletePageFromOptionValue( $page_name ) {

        // GET VISITS BY PAGE OPTION DATA
        $data_arr = $this->getVisitsByPageData();

        // CHECK IF PAGE WITH THAT NAME EXIST IN ASSOC ARRAY
        if ( !array_key_exists( $page_name, $data_arr ) ){
            return false;
        }

        // DELETE PAGE NAME FROM ASOC: ARRAY
        unset($data_arr[ $page_name ]);

        // REMOVE PAGES FROM HIDDEN REPORTS LIST
        $this->removeFromHiddenReports( [$page_name] );

        // SET DATA
        return $this->setVisitsByPageData( $data_arr ); // TRUE || FALSE
    }




    /**
    * DELETE PAGE-S FROM OPTION VALUE - option "strcpv_visits_by_page"
    * DESC: Delete pages by the names provided in the argument.
    * @param $page_names_arr  ->  array  ->  page names ['page-name1', 'page-name2']
    * @since 1.0.0
    */
    public function deletePagesFromOptionValue( $page_names_arr ){

        // GET VISITS BY PAGE OPTION DATA
        $data_arr = $this->getVisitsByPageData();

        // DELETE pages
        foreach ( $page_names_arr as $page_name ) {

            // CHECK IF PAGE WITH THAT NAME EXIST IN ASSOC ARRAY
            if ( array_key_exists( $page_name, $data_arr ) ){

                // DELETE PAGE NAME FROM ASOC. ARRAY
                unset($data_arr[ $page_name ]);
            }
        }


        // REMOVE PAGES FROM HIDDEN REPORTS LIST
        $this->removeFromHiddenReports( $page_names_arr ); // true || false

        // SET DATA
        return $this->setVisitsByPageData( $data_arr ); // TRUE || FALSE

    }




    /**
    * UPDATE PAGE VISITS NUMBER
    * DESC: Retrieve visits_by_page option data and find an array key with the page name.
    *       Change the visits number.
    *       Update option value with updated asoc array.
    * @since 1.0.0
    */
    public function updatePageVisitsNr( $page_name, $new_number ) {

        // GET VISITS BY PAGE OPTION DATA
        $data_arr = $this->getVisitsByPageData();

        // CHECK IF PAGE WITH THAT NAME EXIST IN ASSOC ARRAY
        if ( !array_key_exists( $page_name, $data_arr ) ){
            return false;
        }

        // UPDATE NUMBER
        $data_arr[ $page_name ] = $new_number;
        // SET DATA
        return $this->setVisitsByPageData( $data_arr ); // TRUE || FALSE
    }




    /**
    * RESET ALL PAGE VISITS
    * DESC: Reset all page visits nr to zero.
    * @since 1.0.0
    */
    public function resetAllPageVisits() {

        // GET VISITS BY PAGE OPTION DATA
        $data_arr = $this->getVisitsByPageData();

        // RESET each page value to zero
        foreach ( $data_arr as $page_name => $visits_nr ) {
            $data_arr[ $page_name ] = 0;
        }

        // SET DATA
        return $this->setVisitsByPageData( $data_arr ); // TRUE || FALSE
    }




    /**
    * RESET PAGE TYPE VISIT
    * DESC Reset pages by the names provided in argument.
    * @param $page_names_arr  ->  array  ->  page names ['page-name1', 'page-name2']
    * @since 1.0.0
    */
    public function resetPageTypeVisits( $page_names_arr ){

        // GET VISITS BY PAGE OPTION DATA
        $data_arr = $this->getVisitsByPageData();

        // RESET each page value to zero
        foreach ( $page_names_arr as $page_name ) {
            // Set its value to zero
            $data_arr[ $page_name ] = 0;
        }

        // SET DATA
        return $this->setVisitsByPageData( $data_arr ); // TRUE || FALSE
    }




    /**
    * COUNT TOTAL VISITS
    * DESC: Get total_visits option value (nr.), increase it by one and update it.
    *       If there is no total_visits option, create it and add value zero.
    * @since 1.0.0
    */
    public function countTotalVisits(){

        $option_name = STRCPV_OPT_NAME["total_visits"];

        // Get counting (option) data
    	$all_page_visits = get_option( $option_name );
    	$type_of_response = gettype($all_page_visits);

        // If there is no option with given name
    	if( $all_page_visits == false && $type_of_response == "BOOLEAN" ){
            $new_visit = 1;
    		$response = add_option( $option_name, $new_visit );
    	} else {
    		$new_visit = (int)$all_page_visits + 1;
    		// ECHO "TOTAL_VISITS: " . $new_visit;
    		$response = update_option( $option_name, $new_visit );
    	}
        // Respond
        return [
                "update" => $response, // true || false
                "nr" => $new_visit // number of visits
        ];
    }




    /**
    * IS PAGE REFRESHED - transient option
    * DESC: On page load save the user ip address and loaded page name into the transient with expiration time of 1h.
    *       On page refresh check if there is a user ip address with current page name and if it is,
    *       return true - which means that page is refreshed
    * INFO: First time visiting, there will be no ip address with current page name.
    * @since 1.0.0
    */
    public function isPageRefreshed( $ip_address, $current_page_name ){

        // Check if there is transient
        $page_refreshed_data_arr = get_transient('strcpv_page_refreshed_data');
        if( $page_refreshed_data_arr === false ){

            // THERE IS NO TRANSIENT - SET TRANSIENT
            $page_refreshed_data_arr = [ $ip_address=>$current_page_name ];

        } else {

            // THERE IS TRANSIENT
            $last_page_name = $page_refreshed_data_arr[$ip_address];

            // Check if page is refreshed
            if ( $last_page_name === $current_page_name) {
                // Page is refreshed
                return true; // Abort

            } else {

                // Another page loaded - update transient page name
                $page_refreshed_data_arr[$ip_address] = $current_page_name;
            }

        }
        set_transient('strcpv_page_refreshed_data', $page_refreshed_data_arr, HOUR_IN_SECONDS);
    }




    /**
    * COUNT VISITS PER PAGE
    * DESC: Check user type and ABORT if not VISITOR, SUBSCRIBER, CUSTOMER, AUTHOR, CONTRIBUTOR, AND PENDING_USER.
    *       Create visits by page option if doesn't exist.
    *       Update vist number by page name.
    * @since 1.0.0
    */
    public function countVisitsPerPage( $ip, $page_name ){

        $option_name = STRCPV_OPT_NAME["visits_by_page"];
        $visits_by_page_data_arr = [];

        // Get counting (option) data
    	$visits_by_page_data_ser = get_option($option_name);
    	$type_of_response = gettype( $visits_by_page_data_ser );

        // If OPTION DOES NOT EXIST with the given name
    	if( $visits_by_page_data_ser == false && $type_of_response == "BOOLEAN" ){
            // OPTION DOES NOT EXIST
            $visits_by_page_data_arr[ $page_name ] = 1;
            // Create option with given name and set value to page-name = 1
    		$response = add_option( $option_name, $visits_by_page_data_arr );
            // Respond
            return [
                "update" => $response, // true || false
                "nr" => 1 // number of visits for this page
            ];

        } else {
            // OPTION EXIST - and it holds at least an emypty serialized array.
			// ( We have some data )
			$visits_by_page_data_arr = maybe_unserialize( $visits_by_page_data_ser );
			if ( isset( $visits_by_page_data_arr[ $page_name ] ) ) {
					// Value has a record of page data
					$new_nr_of_visits = (int)$visits_by_page_data_arr[ $page_name ] + 1; // Increase visit by one
					$visits_by_page_data_arr[ $page_name ] = $new_nr_of_visits;

			} else {
					// Value doesn't have records - (probably deleted...)
                    $new_nr_of_visits = 1;
					$visits_by_page_data_arr[ $page_name ] = $new_nr_of_visits;
			}
    	}
        // UPDATE "visits by page" OPTION
        $visits_by_page_data_ser = maybe_serialize( $visits_by_page_data_arr );
        $response = update_option($option_name, $visits_by_page_data_ser);
        // Respond
        return [
            "update" => $response, // true || false
            "nr" => $new_nr_of_visits // number of visits for this page
        ];
    }




    // ======== HIDDEN & VISIBLE REPORTS =========




    /**
    * GET HIDDEN-PAGE-REPORTS DATA
    * DESC: Retrieve serialized data from option hidden_page_reports and unserialize them.
    * RETURNS: An array - ['page-name1', 'page-name2', ... ]
    * @since 1.0.0
    */
    public function getHiddenPageReportsData(){
        $data_ser = get_option( STRCPV_OPT_NAME['hidden_page_reports'] );
        if ( $data_ser !== false ) {
            return maybe_unserialize( $data_ser );
        } else {
            return [];
        }
    }




    /**
    * SET HIDDEN-PAGE-REPORTS DATA
    * DESC: Accept data_array argument and serialize it before updating option hidden_page_reports.
    * @param $data_arr  -  ['page-name1', 'page-name2', ... ]
    * @since 1.0.0
    */
    public function setHiddenPageReportsData( $data_arr ){
        // Serialize data
        $data_ser = maybe_serialize( $data_arr );
        // UPDATE OPTION
        $response = $this->updateOptionValue( STRCPV_OPT_NAME['hidden_page_reports'], $data_ser );
        return $response; // TRUE || FALSE
    }





    /**
    * SET AS HIDDEN REPORTS
    * DESC: Set (selected) pages as hidden - add them to "hidden-page-reports" option.
    * @param $page_names_arr  ->  array  ->  page names ['page-name1', 'page-name2', ...]
    * @since 1.0.0
    */
    public function setAsHiddenReports( $page_names_arr ){
        // Get hidden-page-reports data
        $hidden_page_reports_arr = $this->getHiddenPageReportsData();
        // Merge arrays
        $merged_data_arr = array_merge( $hidden_page_reports_arr, $page_names_arr );
        // Update option is going to create an option if option doesn't exist - no need for add_option()
        return $this->setHiddenPageReportsData( $merged_data_arr ); // TRUE || FALSE

    }




    /**
    * REMOVE FROM HIDDEN REPORTS
    * DESC: Remove (selected) pages from "hidden-page-reports" option.
    * @param $page_names_arr  ->  array  ->  page names ['page-name1', 'page-name2']
    * @since 1.0.0
    */
    public function removeFromHiddenReports( $page_names_arr ){
        // Get hidden-page-reports data
        $hidden_page_reports_arr = $this->getHiddenPageReportsData();
        // Remove selected page-names from retrieved data
        $data_arr = array_diff( $hidden_page_reports_arr, $page_names_arr );
        // Update option is going to create an option if option doesn't exist - no need for add_option()
        return $this->setHiddenPageReportsData( $data_arr ); // TRUE || FALSE
    }


}
?>
