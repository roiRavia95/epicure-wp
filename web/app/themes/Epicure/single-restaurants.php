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
                foreach ($meal_times as $time) {
                    $meals = get_meals($time->slug);
                }
                ?>
                <div class="overlay">
                    <div class="dialog-wrapper">
                        <a class="exit-button" href="#"><img
                                    src="<?php echo get_template_directory_uri() ?>/images/exit-icon/x.svg" alt="exit"></a>
                        <div class="dialog">
                            <div class="meal-content">
                                <!--Content injected by JS-->
                            </div>
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
    wp_reset_postdata();
}
get_footer() ?>
