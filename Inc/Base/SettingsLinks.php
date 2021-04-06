<?php
/**
* DESCRIPTION: display settings link in plugin aside activate/deactivate option
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\Base;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use \StrCPVisits_Inc\Base\BaseController;



class SettingsLinks extends BaseController {


    public function register() {
        add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) ); // No name conflict - use BaseController class instance
    }


    public function settings_link( $links ) {
        $settings_link = '<a href="options-general.php?page=strongetic-page-visits-counter-lite">Settings</a>';
        array_push( $links, $settings_link);
        return $links;
    }

}
