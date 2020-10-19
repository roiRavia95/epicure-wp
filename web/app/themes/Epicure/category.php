<?php
get_header();
?>

<?php
$category = get_queried_object();

?>

    <main class="restaurants">
        <ul class="category-filter">
            <li><a href='/restaurants'>All</a></li>
            <?php
            $args = array(
                "theme_location" => "restaurants-tabs",
                "container" => "ul",
            );
            wp_nav_menu($args);
            ?>
        </ul>
        <?php get_restaurants($category->name); ?>
    </main>


<?php
get_footer();