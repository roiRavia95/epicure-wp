<?php
function get_restaurants($category = "", $num = -1)
{
    $args = array(
        "post_type" => "restaurants",
        "order" => "ASC",
        "posts_per_page" => $num,
        "category_name" => $category,
    );

    $restaurants = new WP_Query($args);
    ?>
    <ul class="restaurant-list">

        <?php while ($restaurants->have_posts()):$restaurants->the_post();

            $owner = get_field('owner');
            ?>

            <li>
                <a href="<?php esc_html(the_permalink()) ?>">
                    <?php the_post_thumbnail('restaurants-image'); ?>
                    <h2><?php the_title() ?></h2>
                    <h3><?php echo $owner->post_title ?></h3>
                </a>
            </li>

        <?php
        endwhile;
        wp_reset_postdata();
        ?>
    </ul>
    <?php
    return $restaurants;
}