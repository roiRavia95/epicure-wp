<?php

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
        }
    }
}

add_action('init', 'loginUser', 10);

//Not ready
function logoutUser()
{
    do_action('clear_auth_cookie');
}

add_action('wp_logout','logoutUser',10,2);