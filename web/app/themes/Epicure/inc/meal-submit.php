<?php
function save_selected_meal()
{
    check_ajax_referer('nonce_name');
    global $wpdb;

    if (isset($_POST) && $_SERVER['REQUEST_METHOD']=='POST') {
        $user_id = $_POST["user_id"];
        $meal_id = $_POST["meal_id"];
        $changes = $_POST["changes"];
        $sides = $_POST["sides"];
        $quantity = $_POST["quantity"];
        $order_id = $_POST["order_id"];


        $table = $wpdb->prefix . 'selected_meals';
        $data = array(
            'user_id'=>$user_id,
            'meal_id'=>$meal_id,
            'changes'=>json_encode($changes),
            'sides'=>json_encode($sides),
            'order_id'=>$order_id
        );
        $format = array(
            '%d',
            '%d',
            '%s',
            '%s',
            '%s'
        );
        //Insert according to the quantity the user has selected
        for($i = 0; $i<$quantity;$i++){
        $wpdb->insert($table, $data, $format);
        }
        wp_die('sent');
    }
}

//add_action("init","save_selected_meal");
add_action('wp_ajax_mealSubmit', 'save_selected_meal');
add_action('wp_ajax_nopriv_mealSubmit', 'save_selected_meal');
