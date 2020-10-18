<?php
function get_past_orders($id)
{
    //Get data from db
    global $wpdb;
    $table = $wpdb->prefix . "past_orders";
    $data = $wpdb->get_results("SELECT * from $table WHERE user_id = $id", ARRAY_A);
    ?>
    <?php

    //logic for presenting data
    $div_closed = true;

    // Go over each doc and retrieve the relevant data
    foreach ($data as $index => $meal) {
        //If the next order id is not the same, seperate the orders
        if ($index === 0 || $data[$index]["order_id"] !== $data[$index - 1]["order_id"]) {
            //If the div is closed that means that its the first order
            //OR
            // Its a different order that will be rendered.
            if ($div_closed) {
                ?>
            <div class="order">
                <h2>Order num: <?php echo $meal["order_id"] ?></h2>
                <ul class="past-meals">
                <?php
                $div_closed = false;
                //If the div is opened, then the next time there is a different order is next-
                // close the last order's div and initiate its own div.
            } else {
                ?>
                </ul>
                </div>
                <div class="order">
                <h2>Order num: <?php echo $meal["order_id"] ?></h2>
                <ul class="past-meals">
                    <?php
            }
        }?>

        <?php

        //get the retrieved data
        $changes = json_decode($meal["changes"]);
        $sides = json_decode($meal["sides"]);
        //Get each meal's data from wp
        get_meal_by_id($meal["meal_id"], $changes, $sides);

        //Close the div
        if ($index !== 0 && $data[$index]["order_id"] !== $data[$index - 1]["order_id"]) {
            //If the next meal is in the same order, dont close the div
            if($index < count($data) - 1 && $data[$index]["order_id"] !== $data[$index + 1]["order_id"]){
            ?>
                </ul>
            </div>
                    <?php
            $div_closed = true;
            }
        }
    }
}
