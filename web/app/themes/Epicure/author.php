<?php
/*
 * Template Name: User Page
 * */
get_header();
?>
<main>
    <div class = "title">
<h1>Hello <?php echo wp_get_current_user()->user_nicename ?></h1>
    </div>
<div class="past-orders">
    <h2>Past Orders</h2>
    <?php get_past_orders(wp_get_current_user()->ID); ?>
</div>
</main>
<?php
get_footer();