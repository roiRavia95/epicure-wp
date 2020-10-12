<?php
function epicure_database(){
    // get global wp database
    global $wpdb;

    global $epicure_db_version;
    $epicure_db_version = '1.0';
    //Name the table
    $table = $wpdb->prefix . 'selected_meals';

    $charset_collate = $wpdb->get_charset_collate();

    //SQL
    //Create SQL table structure for relevant table
    //If one of the requirenments isn't met, the form doesn't get posted to the db
    $sql = "CREATE TABLE $table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id varchar(50) NOT NULL,
        meal_id varchar(50) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

}
add_action("after_setup_theme","epicure_database")
?>

