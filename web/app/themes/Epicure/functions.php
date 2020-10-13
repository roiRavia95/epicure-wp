<?php

//Requiring other php files with functions
// require the queries file
require get_template_directory() . "/inc/queries.php";
//require the get_restaurants function from the file
require get_template_directory() . "/inc/restaurants.php";
//Require the register form handler
require get_template_directory() . "/inc/register.php";
//Require the login form handler
require get_template_directory() . "/inc/login.php";
//require the db initiating function
require get_template_directory() . "/inc/database.php";
//Require the meal form handler
require get_template_directory() . "/inc/meal-submit.php";
//Require the selected meals function
require get_template_directory() . "/inc/get-selected-meals.php";


//Set up scripts
function epicure_scripts()
{
    //Styles
    wp_enqueue_style('style', get_stylesheet_uri(), array(), '1.0.0');

    //Scripts
    //Mix
    wp_enqueue_script("app", get_template_directory_uri() . "/js/app.js", array(""), "1.0.0", true);
    //Mobile menu script
    wp_enqueue_script("mobile-menu", get_template_directory_uri() . "/js/mobile-menu.js", array("jquery"), "1.0.0", true);
    //Session script
    wp_enqueue_script("session-storage", get_template_directory_uri() . "/js/session-storage.js", array("jquery"), "1.0.0", false);
    //Bag script
    wp_enqueue_script("bag", get_template_directory_uri() . "/js/bag.js", array("jquery"), "1.0.0", false);

    wp_enqueue_script("meal-submit", get_template_directory_uri() . "/js/meal-submit.js", array("jquery"), "1.0.0", false);
    //JS Script & Styles for single restaurant page
    if (is_single() && get_post_type() === "restaurants") {
        //Jquery-ui style
        wp_enqueue_style('jquery-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');
        //Dialog
        wp_enqueue_script("dialog", get_template_directory_uri() . "/js/dialog.js", array("jquery"), "1.0.0", true);
        //Restaurant Menu
        wp_enqueue_script("restaurant-meal-menu", get_template_directory_uri() . "/js/restaurant-meal-menu.js", array("jquery"), "1.0.0", true);
        wp_enqueue_script("restaurant-script", get_template_directory_uri() . "/js/restaurant-scripts.js", array("jquery"), "1.0.0", true);
        //Sweet Alert 2
        wp_enqueue_style("sweetalertcss", get_template_directory_uri() . "/css/sweetalert2.min.css");
        wp_enqueue_script("sweetalertjs", get_template_directory_uri() . "/js/sweetalert2.min.js", array("jquery"), "5.5.1");
        //Jquery-ui
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-dialog');
    }
}

add_action('wp_enqueue_scripts', 'epicure_scripts');

//Adding theme support
function epicure_theme_support()
{
    add_image_size('restaurants-image', 342, 212, true);
    add_image_size('restaurant-hero', 1102, 395, true);
    add_image_size('meal-image', 236, 150, true);
    //Add featured images to every post/page
    add_theme_support('post-thumbnails');
    //SEO
    add_theme_support('title-tag');
}

add_action('after_setup_theme', 'epicure_theme_support');

//Register a menu for the navigation bar
function epicure_menu()
{
    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'epicure'),
        'restaurants-tabs' => __('Restaurants Tabs', 'epicure'),
        'mobile-menu-front' => __('Mobile Menu Front', 'epicure'),
        'footer-menu' => __('Footer', 'epicure')
    ));
}

;
add_action('init', 'epicure_menu');

//Custom Login page functions

//Change to epicure logo
function modify_logo()
{
    $logo_style = '<style type="text/css">';
    $logo_style .= 'h1 a {background-image: url(' . get_template_directory_uri() . '/images/logo/login-logo.png) !important;}';
    $logo_style .= '</style>';
    echo $logo_style;
}

add_action('login_head', 'modify_logo');
//Change the Logo's URL
function custom_login_url()
{
    return home_url();
}

add_filter('login_headerurl', 'custom_login_url');

//Add stylesheet to the login page
function custom_login_css()
{
    wp_enqueue_style('login-styles', get_template_directory_uri() . '/css/custom-login.css');
}

add_action('wp_enqueue_scripts', 'custom_login_css');

//Add stylesheet to the register page
function custom_register_css()
{
    wp_enqueue_style('register-styles', get_template_directory_uri() . '/css/custom-register.css');
}

add_action('wp_enqueue_scripts', 'custom_register_css');

function login_redirect_to_home()
{
    wp_redirect(home_url());
//    wp_set_auth_cookie(get_current_user_id());
    exit;
}

add_action('wp_login', 'login_redirect_to_home');


function logout_redirect_to_home()
{
    wp_redirect(home_url() . "/login");
    exit;
}

add_action('wp_logout', 'login_redirect_to_home');

function auto_login_new_user($user_id)
{
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);
    $user = get_user_by('id', $user_id);
    do_action('wp_login', $user->user_login);
    wp_redirect(home_url());
    exit;
}

add_action('user_register', 'auto_login_new_user');

//checkout page only for logged in users
function redirect_to_specific_page()
{
    if (is_page('checkout') && !is_user_logged_in()) {
        wp_redirect(home_url(), 301);
        exit;
    }
}

add_action('template_redirect', 'redirect_to_specific_page');

//add selected meals to user meta

function user_meta_on_register($user_id)
{
    update_user_meta($user_id, 'selected_meals', array());
}
add_action('user_register', 'user_meta_on_register');
add_action('personal_options_update', 'user_meta_on_register');
add_action('edit_user_profile_update', 'user_meta_on_register');
