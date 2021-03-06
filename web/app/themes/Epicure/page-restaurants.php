<?php get_header(); ?>

<main class="restaurants">
    <h1 class="title text-center"><?php the_title() ?></h1>
    <!--Category Filter-->
    <ul class="category-filter">
        <li><a class="all-restaurants-page" href='/restaurants'>All</a></li>
        <?php
        $args = array(
            "theme_location" => "restaurants-tabs",
            "container" => "ul",
        );
        wp_nav_menu($args);
        ?>
    </ul>
    <!--Get restaurants function -> restaurants.php -->
    <?php get_restaurants(); ?>
</main>

<?php get_footer() ?>
