"use strict";

/**
* AJAX
* DESC: Count:
*               - page visit - (page not refreshed)
*               - website total visits - including page refresh
*               - display response messages in dev tools/console
* @since 1.0.0
*/
var StrCPVisitsAjaxCount = function ($) {

    // DISPLAY STATUSES
    console.log("↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓");
    // JS STATUS
    console.log('Strongetic Page Visits Counter Lite - JS status = OK');

    // PHP STATUS
    if (typeof StrCPVisits_page_data === "undefined") {
        console.log('Strongetic Page Visits Counter Lite - PHP status = FALSE');
    } else {
        console.log('Strongetic Page Visits Counter Lite - PHP status = OK');
    }
    console.log("↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑");

    $.ajax({
        url: STR_CPVISITS.ajax_url,
        type: 'POST',
        data: {
            action: 'StrCPVisits_update_total_visits',
            page_data: StrCPVisits_page_data,
            security: STR_CPVISITS.security
        },
        success: function success(response) {
            // console.log(response);

            //wp_send_json_success
            if (response.success === true) {
                handleResponse(response.data);
            }
        }
    }); // !$.ajax


    function handleResponse(data) {

        // Display page title
        console.log("===================================================================");
        if (typeof StrCPVisits_page_data !== "undefined") {
            console.log(STR_CPVISITS.text_page_name + ": " + StrCPVisits_page_data.title + "");
        } else {
            console.log(STR_CPVISITS.text_cannot_access_page_name);
        }
        console.log("===================================================================");

        // DISPLAY MESSAGE
        if (typeof data.msg != "undefined") {
            console.log(STR_CPVISITS.text_message + ": " + data.msg);
        }

        // DISPLAY TOTAL PAGE VISITS - on refresh
        if (typeof data.page_visits_on_refresh != "undefined") {
            console.log(STR_CPVISITS.text_total_page_visits + ': ' + data.page_visits_on_refresh);
        }

        // DISPLAY TOTAL PAGE VISITS
        if (typeof data.page_visits != "undefined") {
            if (typeof data.page_visits.nr != "undefined") {
                console.log(STR_CPVISITS.text_total_page_visits + ": " + data.page_visits.nr);
            }
        }

        // DISPLAY TOTAL VISITS
        if (typeof data.total_visits != "undefined") {
            if (typeof data.total_visits.nr != "undefined") {
                console.log(STR_CPVISITS.text_total_website_visits + ": " + data.total_visits.nr);
            }
        }
        console.log("===================================================================");
    }
}(jQuery);