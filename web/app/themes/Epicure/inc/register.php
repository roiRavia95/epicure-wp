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


//This currently doesn't work
function loginUser()
{
    if (!is_user_logged_in()) {
        if (isset($_POST['login'])) {
            $email = esc_sql($_POST['email']);
            $password = esc_sql($_POST['password']);
            $remember = esc_sql($_POST['remember']);
            if ($email !== "" && $password !== "") {
                $userData = array(
                    "user_login" => $email,
                    "user_password" => $password,
                    "remember" => $remember
                );
                $user = wp_signon($userData, false);

                if (!is_wp_error($user)) {
                    wp_set_current_user($user->ID, $email);
                    do_action('set_current_user');
                    exit();
                } else {
                    print_r($user->get_error_code());
                    exit();
                }
            }
        } else {
            echo "unchecked";
        }
    } else {
        print_r("User already Logged in!");
    }

}

add_action('wp_login', 'loginUser', 10);


function logoutUser()
{
    $user = wp_get_current_user();
}

add_action('clear_auth_cookie', 'logoutUser', 10, 2);