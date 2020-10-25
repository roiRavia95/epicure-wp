<?php get_header();

?>
    <main class="search">
        <h2 class="search-title"><?php echo sprintf(__('%s Search result for "%s": ', 'html5bank'), $wp_query->found_posts, $_GET["s"]) ?></h2>
        <div class="search-results">
            <?php
            while (have_posts()):
                the_post();
                //Send user to the restaurant page of the selected meal.
                $link = get_permalink();
                if (get_post_type() === "meals") {
                    $restaurant_name = get_the_terms(get_post(), 'restaurants')[0]->slug;
                    $restaurant_page = get_page_by_title("restaurants");

                    $link = get_permalink($restaurant_page->ID) . $restaurant_name;
                }
                ?>

                <a href="<?php echo $link; ?>">
                    <div class="result-card">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('medium');
                        } else {
                            ?>
                            <img src="<?php echo get_template_directory_uri() ?>/dist/images/hero/hero-picture.png"
                                 alt="img">
                            <?php
                        }
                        ?>
                        <h3><?php the_title(); ?></h3>
                    </div>
                </a>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
        <div class="pagination">
            <?php echo paginate_links() ?>
        </div>
    </main>


<?php get_footer(); ?>