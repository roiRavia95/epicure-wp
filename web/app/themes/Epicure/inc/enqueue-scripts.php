<?php
//Set up scripts
function epicure_scripts()
{

    $json = file_get_contents(get_template_directory() . "/dist/mix-manifest.json");
    $dist_assets = json_decode($json, true);
    //Styles
    wp_enqueue_style('style', get_template_directory_uri() . "/dist" . $dist_assets['/css/style.css']);
    wp_enqueue_style('normalize', get_template_directory_uri() . "/dist" . $dist_assets['/css/normalize.css']);

    if(is_page(get_page_by_title('login'))){
        wp_enqueue_style('login-styles', get_template_directory_uri() . "/dist" . $dist_assets['/css/custom-login.css']);
    }
    if(is_page(get_page_by_title('register'))) {
        wp_enqueue_style('register-styles', get_template_directory_uri() . "/dist" . $dist_assets['/css/custom-register.css']);
    }
    //Scripts
    //Mix
    //Mobile menu script
    wp_enqueue_script("mobile-menu", get_template_directory_uri() . "/dist" . $dist_assets["/js/mobile-menu.js"], array("jquery"), "1.0.0", true);
    //Session script
    wp_enqueue_script("session-storage", get_template_directory_uri() . "/dist" . $dist_assets["/js/session-storage.js"], array("jquery"), "1.0.0", false);
    //Bag script
    wp_enqueue_script("bag", get_template_directory_uri() ."/dist" . $dist_assets["/js/bag.js"], array("jquery"), "1.0.0", false);

    //Meal Submit script
    wp_enqueue_script("meal-submit", get_template_directory_uri() ."/dist" . $dist_assets["/js/meal-submit.js"], array("jquery"), "1.0.0", false);

    //Bag Checkout script
    if (is_page(get_page_by_title("bag"))) {
        wp_enqueue_script("checkout", get_template_directory_uri() ."/dist" . $dist_assets["/js/checkout.js"], array("jquery"), "1.0.0", false);
    };
    //JS Script & Styles for single restaurant page
    if (is_single() && get_post_type() === "restaurants") {
        //Jquery-ui style
        wp_enqueue_style('jquery-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');
        //Dialog
        wp_enqueue_script("dialog", get_template_directory_uri() ."/dist" . $dist_assets["/js/dialog.js"], array("jquery"), "1.0.0", false);
        //Restaurant Menu
        wp_enqueue_script("restaurant-meal-menu", get_template_directory_uri() ."/dist" . $dist_assets["/js/restaurant-meal-menu.js"], array("jquery"), "1.0.0", false);
        wp_enqueue_script("restaurant-script", get_template_directory_uri() ."/dist" . $dist_assets["/js/restaurant-scripts.js"], array("jquery"), "1.0.0", true);
        //Sweet Alert 2
        wp_enqueue_style("sweetalertcss", get_template_directory_uri() . "/css/sweetalert2.min.css");
        wp_enqueue_script("sweetalertjs", get_template_directory_uri() . "/js/sweetalert2.min.js", array("jquery"), "5.5.1", false);
        //Jquery-ui
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-dialog');
    }
    wp_localize_script("js", "localized", array(
        "ajaxURL"=> admin_url('admin-ajax.php'),
        "nonce" =>wp_create_nonce('nonce_name'),
        "isLoggedIn"=> is_user_logged_in()
    ));
}

add_action('wp_enqueue_scripts', 'epicure_scripts');