<?php
function get_selected_meals($id){
    //Get data from db
    global $wpdb;
    $table = $wpdb->prefix . "selected_meals";
    $data = $wpdb->get_results("SELECT meal_id from $table WHERE user_id = $id ",ARRAY_A);

//    print_r(count($data));
    foreach($data as $meal){
        $args = array(
            "post_type"=>"meals"
        );
    }
}