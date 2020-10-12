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
                    <!--Meal ID for connecting meal to dialog-->
                    <a href="<?php the_permalink() ?>">
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