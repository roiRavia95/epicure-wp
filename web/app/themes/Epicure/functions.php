<?php

//Set up scripts
function epicure_scripts()
{
    //Styles
    wp_enqueue_style('style', get_stylesheet_uri(), array(), '1.0.0');


    //Scripts

    //JS Script & Styles for single restaurant page
    if (is_single() && get_post_type() === "restaurants") {
        wp_enqueue_style('jquery-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');

//        wp_enqueue_script('jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'), '1.12.1');
        wp_enqueue_script("scripts", get_template_directory_uri() . "/js/restaurant-scripts.js", array("jquery"), "1.0.0", true);

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
        'mobile-menu-front' => __('Mobile Menu Front', 'epicure')
    ));
}

;
add_action('init', 'epicure_menu');

//Requiring other php files with functions
// require the queries file
require get_template_directory() . "/inc/queries.php";
//require the get_restaurants function from the file
require get_template_directory() . "/inc/restaurants.php";