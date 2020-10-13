<?php
function get_selected_meals($id)
{
    //Get data from db
    global $wpdb;
    $table = $wpdb->prefix . "selected_meals";
    $data = $wpdb->get_results("SELECT * from $table WHERE user_id = $id ", ARRAY_A);

//    print_r(count($data));
    foreach ($data as $meal) {
        $changes = json_decode($meal["changes"]);
        $sides = json_decode($meal["sides"]);
        get_meal_by_id($meal["meal_id"],$changes,$sides);
    }
}
