<?php
//Dynamically get posts from the "meals" by their "meal time" taxonomy
function get_meals($mealTime)
{
    //Set the arguments for the query to get relevant meals
    $args = array(
        "post_type" => "meals",
        "tax_query" => array(
            "relation" => "AND",
            array(
                "taxonomy" => "restaurants",
                "field" => "name",
                "terms" => get_the_title()
            ),
            array(
                "taxonomy" => "meal_times",
                "field" => "slug",
                "terms" => $mealTime
            ),
        ),
        "order" => "ASC"
    );

    $meals = new WP_Query($args);
    ?>
    <section class="restaurant-menu" id="<?php echo $mealTime ?>">

        <?php if ($mealTime !== "breakfast") { ?>
            <div class="title-line">
                <h2><?php echo ucfirst($mealTime) ?></h2>
            </div>
        <?php } ?>
        <ul class="meals">
            <?php
            while ($meals->have_posts()) :
                $meals->the_post();
                ?>
                <li class="meal">
                    <a href="#">
                        <!--Meal ID for connecting meal to dialog-->
                        <span class="meal_id" style="display: none"><?php echo get_the_ID(); ?></span>
                        <?php the_post_thumbnail('full'); ?>

                        <h2><?php the_title() ?></h2>
                        <p class="ingredients"> <?php the_content() ?></p>
                        <div class="extra-info">
                            <?php
                            //Add icon logic
                            $spicyIcon = get_template_directory_uri() . '/images/meal-icons/spicy.svg';
                            $veganIcon = get_template_directory_uri() . '/images/meal-icons/vegan.svg';
                            $vegetarianIcon = get_template_directory_uri() . '/images/meal-icons/vegetarian.svg';

                            if (get_field("extra-info")["spicy"]) { ?>
                                <img class="info-icon" src="<?php echo $spicyIcon ?>" alt="spicy">
                            <?php }
                            if (get_field("extra-info")["vegetarian"]) { ?>
                                <img class="info-icon" src="<?php echo $vegetarianIcon ?>" alt="vegetarian">

                            <?php }
                            if (get_field("extra-info")["vegan"]) {
                                ?>
                                <img class="info-icon" src="<?php echo $veganIcon ?>" alt="vegan">
                            <?php } ?>
                        </div>
                        <?php
                        ?>
                        <div class="price-line">
                            <p class="price"><?php echo get_field("price") ?></p>
                        </div>

                        <!--Changes and submit form-->
                        <?php
                        $side_1 = get_field("side_1");
                        $side_2 = get_field("side_2");

                        $change_1 = get_field("change_1");
                        $change_2 = get_field("change_2");

                        $quantity = get_field("quantity");
                        $quantity = 1;
                        ?>

                        <form method="post" style="display:none;">
                            <h3>Choose a side</h3>
                            <div class="side">
                                <input class="side-1 checkbox" type="checkbox" name="side-1"
                                       value="<?php echo $side_1 ?>">
                                <label for="side-1"><?php echo $side_1 ?></label>
                            </div>
                            <div class="side">
                                <input class="side-2 checkbox" type="checkbox" name="side-2"
                                       value="<?php echo $side_2 ?>">
                                <label for="side-2"><?php echo $side_2 ?></label>
                            </div>
                            <h3>Changes</h3>
                            <div class="change">
                                <input class="change-1 checkbox" type="checkbox" name="change-1"
                                       value="<?php echo $change_1 ?>">
                                <label for="change-1"><?php echo $change_1 ?></label>
                            </div>
                            <div class="change">
                                <input class="change-2 checkbox" type="checkbox" name="change-2"
                                       value="<?php echo $change_2 ?>">
                                <label for="change-2"><?php echo $change_2 ?></label>
                            </div>
                            <h3>Quantity</h3>
                            <div class="quantity">
                                <button type="button" class="minus"><img
                                            src="<?php echo get_template_directory_uri() ?>/images/quantity/minus.png"
                                            alt="-"></button>
                                <input class="quantity" type="number" name="quantity" value="<?php echo $quantity ?>"
                                       min="1">
                                <button type="button" class="plus"><img
                                            src="<?php echo get_template_directory_uri() ?>/images/quantity/plus.png"
                                            alt="+"></button>
                            </div>
                            <input type="hidden" name='user_id' value='<?php echo get_current_user_id() ?>'>
                            <input type="hidden" class="meal_id" name='meal_id' value='<?php echo get_the_ID() ?>'>
                            <button type="submit" class="submit" name="mealSubmit"> ADD TO BAG</button>
                        </form>
                    </a>
                </li>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </ul>
    </section>
    <?php
    return $meals;
}

//This function is for the front page meals. presents meals with the category "signature"
function get_signature_meal($restaurant)
{
    $args = array(
        "post_type" => "meals",
        "category_name" => "signature",
        "tax_query" => array(
            array(
                "taxonomy" => "restaurants",
                "field" => "name",
                "terms" => $restaurant
            )
        )
    );
    $meals = new WP_query($args);


    while ($meals->have_posts()) :
        $meals->the_post();
        //Send user to the restaurant page of the selected meal.
        $link = get_permalink();
        $restaurant_name = get_the_terms(get_post(), 'restaurants')[0]->slug;
        $restaurant_page = get_page_by_title("restaurants");

        $link = get_permalink($restaurant_page->ID) . $restaurant_name;
        ?>


        <a href="<?php echo esc_html($link) ?>">
            <?php the_post_thumbnail('full'); ?>
            <h2><?php the_title() ?></h2>
            <p class="ingredients"> <?php the_content() ?></p>
            <div class="extra-info">
                <?php
                //Add icon logic
                $spicyIcon = get_template_directory_uri() . '/images/meal-icons/spicy.svg';
                $veganIcon = get_template_directory_uri() . '/images/meal-icons/vegan.svg';
                $vegetarianIcon = get_template_directory_uri() . '/images/meal-icons/vegetarian.svg';

                if (get_field("extra-info")["spicy"]) { ?>
                    <img class="info-icon" src="<?php echo $spicyIcon ?>" alt="spicy">
                <?php }
                if (get_field("extra-info")["vegetarian"]) { ?>
                    <img class="info-icon" src="<?php echo $vegetarianIcon ?>" alt="vegetarian">

                <?php }
                if (get_field("extra-info")["vegan"]) {
                    ?>
                    <img class="info-icon" src="<?php echo $veganIcon ?>" alt="vegan">
                <?php } ?>
            </div>
            <div class="price-line">
                <p class="price"><?php echo get_field("price") ?></p>
            </div>
        </a>
    <?php
    endwhile;
    wp_reset_postdata();
}

;
//This function retrieves a meal by its id and is used for getting data from the db in "get_selected_meals() function"
function get_meal_by_id($id, $changes, $sides)
{
    $args = array(
        "post_type" => "meals",
        "p" => $id
    );
    $meal = new WP_Query($args);

    if ($meal->have_posts()) :
        $meal->the_post();
        ?>
        <li class='meal'>
            <?php the_post_thumbnail('full'); ?>
            <div class="meal-content">
                <div class="main-content">
                    <h2><?php the_title() ?></h2>
                    <p class="ingredients"> <?php the_content() ?></p>
                </div>
                <div class="extra-info-bag">
                    <?php
                    if (isset($changes)) {
                        ?>
                        <div class='changes'>
                            <h3>Changes: </h3>
                            <?php
                            foreach ($changes as $change) {
                                ?>
                                <p><?php echo $change ?></p>
                                <?php
                            }
                            ?>
                        </div>
                    <?php }
                    if (isset($sides)) {
                    ?>
                    <div class='sides'>
                        <h3>Sides: </h3>
                        <?php
                        foreach ($sides as $side) {
                            ?>
                            <p><?php echo $side ?></p>
                            <?php
                        }
                        ?>
                    </div>
                        <?php }?>
                </div>

                <p class="price"><?php echo get_field("price") ?></p>
            </div>
        </li>
    <?php
    endif;
}