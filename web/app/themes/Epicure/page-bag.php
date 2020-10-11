<?php
get_header(); ?>

<main class="bag">
    <?php
    while (have_posts()):the_post(); ?>
        <h1 class="title text-center">My <?php the_title() ?></h1>
        
        <ul class="my-meals">
            <!--Inject content with JS-->
        </ul>
        <hr>
        <div class="total">
            <h1>Total: </h1>
        </div>
        <?php
        //Check if user is signed in
        $checkoutLink = home_url();
        if (is_user_logged_in()) {
            $checkoutLink .= "/checkout";

        } else {
            $checkoutLink .= "/login";
        }
        ?>
        <a class="button checkout" href="<?php echo $checkoutLink ?>"> Finish Order</a>
    <?php
    endwhile;
    wp_reset_postdata();
    ?>
</main>

<?php get_footer() ?>
