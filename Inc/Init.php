<?php
/**
* @package Strongetic - count page visits
*/

namespace StrCPVisits_Inc;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



final class Init { // Final -> it will never get extended -> used by another class


    /********************************************************
    ** AUTOMATIZE call of REGISTER METHODES in all classes **
    *********************************************************/

    /**
     * GET SERVICES
     * DESC: Store all the classes inside an array.
     * @return array Full list of classes
     * @since 1.0.0
    **/
    public static function get_services() {
        // To be able to use register_services methode we need to
        // get all classes from BASE and COUNTER folders and save/return them as array.
        return [
            Base\Enqueue::class, //Declare the class that we wish to initialize
            Base\SettingsLinks::class,
            Counter\frontend\TotalVisits::class,
            Counter\backend\DashboardWidget::class,
            API\SettingsApi::class,
            Ajax\Counter\TotalVisits::class,
            Ajax\SettingsPage\SaveSettings::class,
            Ajax\DashboardWidget\UpdateTotalVisitsNr::class,
            Ajax\DashboardWidget\UpdatePageData::class,
            Ajax\DashboardWidget\DeletePages::class,
            Ajax\DashboardWidget\DeletePage::class,
            Ajax\DashboardWidget\reset\ResetAll::class,
            Ajax\DashboardWidget\reset\ResetPageType::class,
            Ajax\DashboardWidget\ToggleHiddenReports::class,
        ];
        // From php 5.4 we can use []
    }




    /**
     *  REGISTER SERVICES
     *  DESC: Loop trough the classes, initialize them, and call the register() method if it exist.
     *  @since 1.0.0
    **/
    public static function register_services() {
        foreach ( self::get_services() as $class ) {
            $service = self::instantiate( $class );
            if( method_exists( $service, 'register') ) {
                $service->register();
            }
        }
    }




    /**
     *  INSTANTIATE
     *  DESC: Initialize the class
     *  @param   class $class      class from the services array
     *  @return  class instance    new instance of the class
     *  @since 1.0.0
    **/
    private static function instantiate( $class ) {
        return new $class;
    }



} // !class Init
