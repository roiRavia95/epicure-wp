<?php
function save_order()
{
    check_ajax_referer('nonce_name');
    global $wpdb;

        $clicked = $_POST["clicked"];
        $order_id = $_POST["order_id"];
        $current_user_id = wp_get_current_user()->ID;

        //If "Finish Order" has been clicked, initiate db adjustments

    if ($clicked && is_user_logged_in()) {
        //Get the relevant tables
        $past_orders_table = $wpdb->prefix . 'past_orders';
        $selected_meals_table = $wpdb->prefix . 'selected_meals';

        //Create the sql query to get the data from the db
        $selected_meals_query = "SELECT * FROM $selected_meals_table WHERE order_id = $order_id";
        $query = "INSERT INTO $past_orders_table $selected_meals_query";

        //Run the query
        $wpdb->query($query);

        //If meals we're added before the user was logged in, update the db
        $wpdb->update($past_orders_table,array('user_id'=>$current_user_id),array('order_id'=>$order_id));

        //Remove data from selected_meals table
        $remove_from_selected = "DELETE FROM $selected_meals_table WHERE order_id = $order_id";
        $wpdb->query("$remove_from_selected");
    }
        die();
}

//add_action("init","save_selected_meal");
add_action('wp_ajax_checkout', 'save_order', 10, 2);
add_action('wp_ajax_nopriv_checkout', 'save_order', 10, 2);
