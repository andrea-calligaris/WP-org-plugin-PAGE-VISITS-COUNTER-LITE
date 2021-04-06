<?php
/**
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\Base;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Prevent name conflicts with another plugin using same names for variables
 */

class BaseController {


    public $plugin_path;
    public $plugin_url;
    public $plugin;




    public function __construct() {
        // PLUGIN
        $this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) ); // 2 is a number of child folders away from the parrent. (Child folderi: 1.Inc,  2.Base )
        $this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
        $this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/strongetic-page-visits-counter-lite.php';
    }




    public function getAllData(){
        $data = [
            "plugin_path" => $this->plugin_path,
            "plugin_url" => $this->plugin_url,
            "plugin" => $this->plugin
        ];
        return $data;
    }
}
