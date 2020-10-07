<?php

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
    wp_enqueue_script("session", get_template_directory_uri() . "/js/session.js", array("jquery"), "1.0.0", false);

    //bag script
    wp_enqueue_script("bag", get_template_directory_uri() . "/js/bag.js", array("jquery"), "1.0.0", false);

    //JS Script & Styles for single restaurant page
    if (is_single() && get_post_type() === "restaurants") {
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

//Requiring other php files with functions
// require the queries file
require get_template_directory() . "/inc/queries.php";
//require the get_restaurants function from the file
require get_template_directory() . "/inc/restaurants.php";