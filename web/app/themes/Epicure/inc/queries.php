<?php
//Dynamically get posts from the "meals" by their "meal time" taxonomy
function get_meals($mealTime)
{
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
            while ($meals->have_posts()):$meals->the_post();
                ?>
                <li class="meal">
                    <a href="<?php esc_html(the_permalink()) ?>">
                        <?php the_post_thumbnail('meal-image'); ?>
                        <h2><?php the_title() ?></h2>
                        <p class="ingredients"> <?php the_content() ?></p>
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

    while ($meals->have_posts()):$meals->the_post(); ?>
        <a href="<?php esc_html(the_permalink()) ?>">
            <?php the_post_thumbnail('meal-image'); ?>
            <h2><?php the_title() ?></h2>
            <p class="ingredients"> <?php the_content() ?></p>
            <div class="price-line">
                <p class="price"><?php echo get_field("price") ?></p>
            </div>
        </a>
    <?php
    endwhile;
    wp_reset_postdata();

}

;