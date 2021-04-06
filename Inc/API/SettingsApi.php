<?php
/*
* DESCRIPTION: Create admin menu pages/subpages
* @package Strongetic - count page visits
*/
namespace StrCPVisits_Inc\API;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use StrCPVisits_Inc\Counter\frontend\CounterBase;



class SettingsApi extends CounterBase {




    public function register() {
        // Register submenu page under Settings
        add_action( 'admin_menu', [$this, 'strongetic_register_settings_option'] );
    }




    /**
    * REGISTER ADMIN PAGES AND SUBPAGES - under this comment
    * DESC: PLace register_menu_page() and register_submenu_page methodes under this comment.
    * @since 1.0.0
    */

    public function strongetic_register_settings_option(){
        add_submenu_page('options-general.php', 'strongetic-page-visits-counter-lite', 'Page Visits Counter Lite', 'manage_options', 'strongetic-page-visits-counter-lite', [$this, 'generateSubpageVisitsCounterLight']);
    }




    /**
    * INVOKE PAGE TEMPLATE FUNCTIONS - under this comment
    * DESC: This is required for passing all BASE CONTROLLER data
    * INFO: Param. $this->getAllData is retrieveing all data from the base controller class.
    *       Param type is asoc. array
    * @since 1.0.0
    */

    public function generateSubpageVisitsCounterLight(){
        strongeticSubpageVisitsCounterLight( $this->getAllData() );
    }

}
