<?php
/**
* SETTINGS - SCREENSHOT TAB
* DESC: Displays screenshot tab html content - image/s
* @since 1.0.0
*/

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



// Getting variable on template part:
// Get $key variable from parent template
$base_controler_data = get_query_var( 'StrCPVisits_base_controler_data' );
?>


<img src="<?php echo $base_controler_data['plugin_url']; ?>assets/img/strongetic-page-visits-counter-lite-v1-0-0.jpg" alt="strongetic-page-visits-counter-light plugin screenshot">
