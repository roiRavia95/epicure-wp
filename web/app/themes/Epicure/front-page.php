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
                    <h1 class="hero-content-text"><?php echo get_field("hero_content") ?></h1>
                    <?php echo get_template_part("templates/searchbar") ?>
                </div>
            </div>
        </section>
        <section class="front-page-menu">
            <?php
            $args = array(
                'theme-location' => 'main-menu',
                'container' => 'nav',
                'container_class' => 'main-nav',
            );
            wp_nav_menu($args);
            ?>
        </section>
        <section class="popular-restaurants">
            <h1>The Popular Restaurants in Epicure:</h1>
            <?php
            $restaurants = get_restaurants("Most Popular", 3);

            $restaurants_page = get_page_by_title('Restaurants');

            ?>
            <a class="all-restaurants" href="<?php the_permalink($restaurants_page->ID) ?>">All Restaurants >></a>
        </section>

        <section class="signature-dishes">
            <h1>Signature Dish of:</h1>
            <ul>
                <?php
                while ($restaurants->have_posts()):
                    $restaurants->the_post();
                    ?>
                    <li class="signautre-dish">
                        <h2 class="restaurant"><?php the_title(); ?></h2>
                        <?php
                        get_signature_meal(get_the_title());
                        ?>
                    </li>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </ul>
        </section>
        <section class="our-icons">
            <h1>The meaning of our icons :</h1>
            <?php
            $spicyIcon = get_template_directory_uri() . '/images/meal-icons/spicy.svg';
            $veganIcon = get_template_directory_uri() . '/images/meal-icons/vegan.svg';
            $vegetarianIcon = get_template_directory_uri() . '/images/meal-icons/vegetarian.svg';
            ?>
            <div class="icons-container">
                <div class="icon spicy">
                    <img class="info-icon" src="<?php echo $spicyIcon ?>" alt="spicy">
                    <h2>Spicy</h2>
                </div>
                <div class="icon vegitarian">
                    <img class="info-icon" src="<?php echo $vegetarianIcon ?>" alt="vegetarian">
                    <h2>Vegetarian</h2>
                </div>
                <div class="icon vegan">
                    <img class="info-icon" src="<?php echo $veganIcon ?>" alt="vegan">
                    <h2>Vegan</h2>
                </div>
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
                <div class="chef-info">
                    <div class="chef-profile">
                        <?php the_post_thumbnail(); ?>
                        <h2><?php echo $chef ?></h2>
                    </div>

                    <?php
                    the_content();
                    ?>
                </div>
                <h2 class="chef-restaurants"><?php
                    //Get only the first name
                    echo explode(" ", $chef)[0];
                    ?>'s restaurants :</h2>
                <?php
                $args = array(
                    "post_type" => "restaurants",
                );

                $restaurants = new WP_query($args);
                ?>
                <ul class="chef-restaurants-ul">
                    <?php
                    while ($restaurants->have_posts()):$restaurants->the_post();
                        $owner = get_field("owner");
                        if ($owner->post_title === $chef) { ?>
                            <li>
                                <a href="<?php esc_html(the_permalink()) ?>">
                                    <?php the_post_thumbnail("restaurants-image"); ?>
                                    <h3><?php the_title() ?></h3>
                                </a>
                            </li>
                            <?php
                        }

                    endwhile;
                    wp_reset_postdata();
                    ?>
                </ul>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </section>
        <section class="about-us" id="about-us">
            <div class="about-us-div">
                <div class="about-us-text">
                    <h1>About us :</h1>
                    <div class="about-us-content">
                        <p><?php the_content() ?></p>
                    </div>
                </div>
                <?php $aboutLogo = get_template_directory_uri() . '/images/about-logo/about-logo@3x.png' ?>
                <img src="<?php echo $aboutLogo ?>" alt="logo">
            </div>
            <div class="download-buttons">
                <a href="#">
                    <button><img src="<?php echo get_template_directory_uri() ?>/images/download-buttons/apple.png"
                                 alt="apple">Download on the <span>App Store</span></button>
                </a>
                <a href="#">
                    <button><img src="<?php echo get_template_directory_uri() ?>/images/download-buttons/google.png"
                                 alt="apple">
                        Get it on <span>Google Play</span></button>
                </a>
            </div>

        </section>
    </main>

<?php
endwhile;
wp_reset_postdata();
get_footer();

?>
