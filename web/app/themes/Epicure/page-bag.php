<?php
get_header(); ?>

<main class="bag">
    <?php
    while (have_posts()) :
        the_post();
        ?>

        <h1 class="title text-center">My <?php the_title() ?></h1>
        <ul class="my-meals">
            <!--Inject content with JS-->
        </ul>
        <div class="bag-placeholder">
        <img  src="<?php echo get_template_directory_uri() . '/dist/images/bag/bag-placeholder.png' ?>" alt="placeholder">
        <?php
        the_content(); ?>
        </div>
        <hr>
        <div class="total">
            <h1>Total: </h1>
        </div>
        <?php
        //Check if user is signed in
        $checkoutLink = home_url();
        if (is_user_logged_in()) {
            $checkoutLink .= '/author/' . wp_get_current_user()->user_nicename;
        } else {
            $checkoutLink .= "/login";
        }
        ?>
        <a href="<?php echo $checkoutLink ?>"class="button checkout"><div>Finish Order</div></a>
        <?php
    endwhile;
    wp_reset_postdata();
    ?>
</main>

<?php get_footer() ?>
