<?php
/**
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc\Base;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}




class Deactivate
{
    public static function deactivate() {
        flush_rewrite_rules();
    }

}
