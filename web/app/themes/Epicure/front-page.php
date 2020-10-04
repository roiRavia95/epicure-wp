<?php
get_header();

while (have_posts()):
    the_post();

    ?>
    <main class="main-content">
        <section class="hero">
            <?php
            if (has_post_thumbnail()) {
                $thumbnailURL = get_the_post_thumbnail_url();
            }
            
            ?>

            <div class="hero-image" style="background-image:url(<?php echo $thumbnailURL ?>)">
                <div class="hero-content">
                    <h2 class="hero-content-text"><?php echo get_field("hero_content") ?></h2>
                    <?php echo get_template_part("templates/searchbar") ?>
                </div>
            </div>
        </section>
        <!--TODO: add css to all below-->
        <section class="popular-restaurants">
            <h1>The Popular Restaurants in Epicure</h1>
            <?php
            $restaurants = get_restaurants("Most Popular", 3);

            $restaurants_page = get_page_by_title('Restaurants');

            ?>
            <a href="<?php the_permalink($restaurants_page->ID) ?>">All Restaurants</a>
        </section>

        <section class="popular-restaurants">
            <h1>Signature Dish of:</h1>
            <?php
            while ($restaurants->have_posts()):
                $restaurants->the_post();
                the_title();
                get_signature_meal(get_the_title());
            endwhile;
            wp_reset_postdata();
            ?>
        </section>
        <section class="our-icons">
            <h1>The meaning of our icons :</h1>
            <div class="icon spicy">
                <img src="" alt="">
                <h3></h3>
            </div>
            <div class="icon vegitarian">
                <img src="" alt="">
                <h3></h3>
            </div>
            <div class="icon vegan">
                <img src="" alt="">
                <h3></h3>
            </div>
        </section>
        <section class="chef">
            <h1>Chef of the week :</h1>
            <?php
            $args = array(
                "post_type" => "chefs",
                "category_name" => "chef of the week",

            );
            $chefs = new WP_Query($args);

            while ($chefs->have_posts()):
                $chefs->the_post();
                $chef = get_the_title();
                ?>
                <div class="chef-profile">
                    <?php the_post_thumbnail(); ?>
                    <h2><?php the_title() ?></h2>
                </div>

                <?php
                the_content();
                ?>
                <h2><?php the_title() ?>'s restaurants :</h2>
                <?php
                $args = array(
                    "post_type" => "restaurants",
                );

                $restaurants = new WP_query($args);

                while ($restaurants->have_posts()):$restaurants->the_post();
                    $owner = get_field("owner");
                    if ($owner->post_title === $chef) {
                        the_title();
                    }

                endwhile;
                wp_reset_postdata();
                ?>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>


        </section>

    </main>

<?php
endwhile;
wp_reset_postdata();
get_footer();

?>
