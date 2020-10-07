<?php get_header();
if (have_posts()) {
    while (have_posts()) :
        the_post();
        if (has_post_thumbnail()) {
            $thumbnailURL = get_the_post_thumbnail_url();
        }
        $owner = get_field("owner")
        ?>
        <main class="restaurant">
            <div class="hero">
                <?php the_post_thumbnail("restaurant-hero"); ?>
            </div>
            <h1><?php the_title() ?></h1>
            <h2><?php echo $owner->post_title ?></h2>

            <?php
            //Show open now if category 'open now' is checked;
            $categories = get_the_category(get_the_ID());
            foreach ($categories as $category) {
                if (strtolower($category->name) === "open now") {
                    ?>
                    <p class="open-now">
                        <img src="<?php echo get_template_directory_uri() ?>/images/open-now/clock-icon@2x.png">Open now
                    </p>
                    <?php
                }
            }
            ?>

            <?php
            //Print relevant navigation menu for the menu
            $meal_times = get_field("meal_times");
            ?>
            <nav class="meal-nav sticky-nav">
                <?php
                if ($meal_times && count($meal_times) > 1) {
                    ?>
                    <ul>
                        <?php
                        foreach ($meal_times as $i => $time) {
                            if ($i === 0) {
                                ?>
                                <li>
                                    <a class="current-menu" href="#"
                                       id="<?php echo $time->slug ?>"><?php echo $time->name ?></a>
                                </li>
                                <?php
                            } else {
                                ?>
                                <li>
                                    <a href="#" id="<?php echo $time->slug ?>"><?php echo $time->name ?></a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                    <?php
                } ?>

            </nav>
            <?php
            //This function gets the meals of the specific meal time
            if ($meal_times) {
                ?>
                <?php
                foreach ($meal_times as $time) {
                    $meals = get_meals($time->slug);
                    //Only if mealtime has meals, use it for getting data from fields in the dialog
                    if ($meals->found_posts) {
                        $meal_with_posts = $meals;
                    }
                }
                ?>
                <div class="overlay">
                    <div class="dialog-wrapper">
                        <a class="exit-button" href="#"><img
                                    src="<?php echo get_template_directory_uri() ?>/images/exit-icon/x.svg" alt=""></a>
                        <div class="dialog">
                            <div class="meal-content">
                                <!--Content injected by JS-->
                            </div>
                            <?php
                            //Make sure to loop only over mealtimes with meals to avoid bugs
                            while ($meal_with_posts->have_posts()):$meal_with_posts->the_post();
                                //Add logic to make specific for each meal
                                $side_1 = get_field("side_1");
                                $side_2 = get_field("side_2");

                                $change_1 = get_field("change_1");
                                $change_2 = get_field("change_2");

                                $quantity = get_field("quantity");
                                $quantity = 1;
                                break;
                            endwhile;
                            wp_reset_postdata();
                            ?>
                            <form method="POST">
                                <h3>Choose a side</h3>
                                <div class="side">
                                    <input id="side-1" class="checkbox" type="checkbox" name="side-1"
                                           value="<?php echo $side_1 ?>">
                                    <label for="side-1"><?php echo $side_1 ?></label>
                                </div>
                                <div class="side">
                                    <input id="side-2" class="checkbox" type="checkbox" name="side-2"
                                           value="<?php echo $side_2 ?>">
                                    <label for="side-2"><?php echo $side_2 ?></label>
                                </div>
                                <h3>Changes</h3>
                                <div class="change">
                                    <input id="change-1" class="checkbox" type="checkbox" name="change-1"
                                           value="<?php echo $change_1 ?>">
                                    <label for="change-1"><?php echo $change_1 ?></label>
                                </div>
                                <div class="change">
                                    <input id="change-2" class="checkbox" type="checkbox" name="change-2"
                                           value="<?php echo $change_2 ?>">
                                    <label for="change-2"><?php echo $change_2 ?></label>
                                </div>
                                <h3>Quantity</h3>
                                <div class="quantity">
                                    <button type="button" class="minus"><img
                                                src="<?php echo get_template_directory_uri() ?>/images/quantity/minus.png"
                                                alt="-"></button>
                                    <input id="quantity" type="number" name="quantity" value="<?php echo $quantity ?>"
                                           min="1">
                                    <button type="button" class="plus"><img
                                                src="<?php echo get_template_directory_uri() ?>/images/quantity/plus.png"
                                                alt="+"></button>
                                </div>
                                <button id="submit" type="submit"> ADD TO BAG</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="no-meals">
                    <h3>This restaurant doesn't have any meals yet!</h3>
                    <a href="javascript:history.back()">Back to the Restaurants list</a>
                </div>
                <?php
            }
            ?>
        </main>
    <?php
    endwhile;
}
get_footer() ?>
