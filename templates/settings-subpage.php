<?php
//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



/**
* DISPLAY SETTINGS PAGE
* DESC: Displays the HTML content on the admin subpage called "Page Visits Counter Light"
*       under admin menu setting option.
* @param $base_controller_data   :   asoc.array
* @since 1.1.0
*/
function strongeticSubpageVisitsCounterLight( $base_controler_data ){

      // Setting varibale
      // Make key available to the template parts
      set_query_var( 'StrCPVisits_base_controler_data', $base_controler_data );
?>

    <!-- HTML CONTENT -->
    <div class="StrCPVisits_main-wrapper">
        <h1><?php esc_html_e("Page Visits Counter Lite - Settings", "page-visits-counter-lite"); ?></h1>
        <br>

        <!-- LIGHT TABS -->
        <div class="StrCPVisits-light-tabs" data-active-class="StrCPVisits-form-tab-active">

            <ul>
                <li class="StrCPVisits-form-tab-active"><?php esc_html_e("Settings", "page-visits-counter-lite"); ?></li>
                <li><?php esc_html_e("Counter", "page-visits-counter-lite"); ?></li>
                <li><?php esc_html_e("Documentation", "page-visits-counter-lite"); ?></li>
                <li><?php esc_html_e("Screenshot", "page-visits-counter-lite"); ?></li>
                <li><?php esc_html_e("Installation", "page-visits-counter-lite"); ?></li>
                <li><?php esc_html_e("Debugging", "page-visits-counter-lite"); ?></li>
                <li><?php esc_html_e("FAQ", "page-visits-counter-lite"); ?></li>
                <li><?php esc_html_e("About", "page-visits-counter-lite"); ?></li>
            </ul>

            <!-- SETTINGS -->
            <div class="StrCPVisits-form-tab">
                <br>
                <!-- INCLUDE SETTINGS TAB CONTENT -->
                <?php
                if( file_exists( dirname( __FILE__ ) . '/template-parts/settings-tab.php' ) ) {
                    require_once( dirname(__FILE__) . '/template-parts/settings-tab.php' );
                } ?>
            </div>

            <!-- COUNTER -->
            <div class="StrCPVisits-form-tab">
                <br>
                <!-- INCLUDE COUNTER TAB CONTENT -->
                <?php
                if( file_exists( dirname( __FILE__ ) . '/template-parts/counter-tab.php' ) ) {
                    require_once( dirname(__FILE__) . '/template-parts/counter-tab.php' );
                } ?>
            </div>

            <!-- DOCUMENTATION -->
            <div class="StrCPVisits-form-tab">
                <br>
                <!-- INCLUDE DOCUMENTATION TAB CONTENT -->
                <?php
                if( file_exists( dirname( __FILE__ ) . '/template-parts/documentation-tab.php' ) ) {
                    require_once( dirname(__FILE__) . '/template-parts/documentation-tab.php' );
                } ?>
            </div>

            <!-- SCREENSHOT -->
            <div class="StrCPVisits-form-tab">
                <br>
                <!-- INCLUDE SCREENSHOT TAB CONTENT -->
                <?php
                if( file_exists( dirname( __FILE__ ) . '/template-parts/screenshot-tab.php' ) ) {
                    require_once( dirname(__FILE__) . '/template-parts/screenshot-tab.php' );
                } ?>
            </div>

            <!-- INSTALLATION -->
            <div class="StrCPVisits-form-tab">
                <br>
                <!-- INCLUDE INSTALLATION TAB CONTENT -->
                <?php
                if( file_exists( dirname( __FILE__ ) . '/template-parts/installation-tab.php' ) ) {
                    require_once( dirname(__FILE__) . '/template-parts/installation-tab.php' );
                } ?>
            </div>

            <!-- DEBUGGING -->
            <div class="StrCPVisits-form-tab">
                <br>
                <!-- INCLUDE DEBUGING TAB CONTENT -->
                <?php
                if( file_exists( dirname( __FILE__ ) . '/template-parts/debugging-tab.php' ) ) {
                    require_once( dirname(__FILE__) . '/template-parts/debugging-tab.php' );
                } ?>
            </div>

            <!-- FAQ -->
            <div class="StrCPVisits-form-tab">
                <br>
                <!-- INCLUDE FAQ TAB CONTENT -->
                <?php
                if( file_exists( dirname( __FILE__ ) . '/template-parts/faq.php' ) ) {
                    require_once( dirname(__FILE__) . '/template-parts/faq.php' );
                } ?>
            </div>

            <!-- ABOUT -->
            <div class="StrCPVisits-form-tab">
                <br>
                <!-- INCLUDE ABOUT TAB CONTENT -->
                <?php
                if( file_exists( dirname( __FILE__ ) . '/template-parts/about-tab.php' ) ) {
                    require_once( dirname(__FILE__) . '/template-parts/about-tab.php' );
                } ?>
            </div>

        </div>

    </div> <!-- main wrapper end -->

    <!-- HTML CONTENT END -->
<?php
// ADD JS and AJAX scripts
wp_enqueue_script('StrCPVisits_js');
wp_enqueue_script('StrCPVisits_ajax');
// DO NOT WRITE ANYTHING BELOW THIS LINE
}
?>
