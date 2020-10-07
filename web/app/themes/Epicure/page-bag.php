<?php get_header(); ?>

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
    endwhile;
    wp_reset_postdata();
    ?>
</main>

<?php get_footer() ?>
