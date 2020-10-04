<?php get_header();

?>
    <div class='hero search' style='background-image:url(<?php echo get_template_directory_uri() ?>/Images/search.jpg)'
         alt='hero'></div>
    <h2 class="search-title"><?php echo sprintf(__('%s Search result for "%s": ', 'html5bank'), $wp_query->found_posts, $_GET["s"]) ?></h2>
    <a href="<?php the_permalink(); ?>">
        <?php get_template_part('templates/page', 'loop'); ?>
    </a>
<?php
while (have_posts()):the_post();

    the_title();
    the_post_thumbnail('medium');
    echo "<hr>";

endwhile;
wp_reset_postdata();

?>
    <div class="pagination">

        <?php echo paginate_links() ?>
    </div>

<?php get_footer(); ?>