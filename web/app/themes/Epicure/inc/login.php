<?php

function loginUser()
{
    if (!is_user_logged_in()) {
        if (isset($_POST['login'])) {
            $email = esc_sql($_POST['email']);
            $password = esc_sql($_POST['password']);
            if ($email !== "" && $password !== "") {
                $userData = array(
                    "user_login" => $email,
                    "user_password" => $password,
                );
                $user = wp_signon($userData, false);

                if (!is_wp_error($user)) {
                    wp_set_current_user($user->ID, $email);
                    do_action('set_current_user');
                    exit();
                } else {
                    return ($user->get_error_code());
                }
            }
        }
    }
}

add_action('init', 'loginUser', 10);

function logoutUser()
{
    do_action('clear_auth_cookie');
}

add_action('wp_logout','logoutUser',10,2);

//Customize Login

//Change to epicure logo
function modify_logo()
{
    $logo_style = '<style type="text/css">';
    $logo_style .= 'h1 a {background-image: url(' . get_template_directory_uri() . '/dist/images/logo/login-logo.png) !important;}';
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

function login_redirect_to_home()
{
    wp_redirect(home_url());
    exit;
}

add_action('wp_login', 'login_redirect_to_home');

function logout_redirect_to_home()
{
    wp_redirect(home_url() . "/login");
    exit;
}

add_action('wp_logout', 'login_redirect_to_home');



//checkout page only for logged in users
function redirect_to_specific_page()
{
    if (is_page('checkout') && !is_user_logged_in()) {
        wp_redirect(home_url(), 301);
        exit;
    }
}

add_action('template_redirect', 'redirect_to_specific_page');