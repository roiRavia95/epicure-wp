<?php

//Requiring other php files with functions
// require the queries file
require get_template_directory() . "/inc/queries.php";
//require the get_restaurants function from the file
require get_template_directory() . "/inc/restaurants.php";
//require the db initiating function
require get_template_directory() . "/inc/database.php";
//Require the meal form handler
require get_template_directory() . "/inc/meal-submit.php";
//Require the selected meals function
require get_template_directory() . "/inc/get-selected-meals.php";
//Require the selected meals function
require get_template_directory() . "/inc/get-past-orders.php";
//Require the checkout functionality
require get_template_directory() . "/inc/checkout.php";
//Require the register form handler
require get_template_directory() . "/inc/register.php";
//Require the login form handler
require get_template_directory() . "/inc/login.php";

//Require the scripts from  enqueue-script.php
require get_template_directory() . "/inc/enqueue-scripts.php";

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
