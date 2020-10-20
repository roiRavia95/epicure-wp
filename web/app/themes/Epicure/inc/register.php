<?php
function registerUser()
{
    if (isset($_POST['register'])) {
        //Get hold of data submitted form
        $name = esc_sql($_POST['name']);
        $email = esc_sql($_POST['email']);
        $password = esc_sql($_POST['password']);
        $confirm_password = esc_sql($_POST['confirm_password']);

        //Validate
        $error = array();
        if (empty($name)) {
            $error['username_empty'] = "Needed Username must";
        }
        if (email_exists($email)) {
            $error['email_existence'] = "Email already exists";
        }
        if (strcmp($password, $confirm_password) !== 0) {
            $error['password'] = "Password didn't match";
        }
        if (count($error) === 0) {
            wp_create_user($name, $password, $email);
            wp_redirect(home_url());
            exit();
        } else {
            print_r($error);
        }
    }
}

add_action('init', 'registerUser');

//Change register url in the login page
function register_url($link)
{
    return str_replace(site_url('wp-login.php?action=register', 'login'), home_url('register', 'login'), $link);
}

add_filter('register', 'register_url');


//Custom Register page

//Add stylesheet to the register page
function custom_register_css()
{
    wp_enqueue_style('register-styles', get_template_directory_uri() . '/dist/css/custom-register.css');
}

add_action('wp_enqueue_scripts', 'custom_register_css');



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
