<?php get_header(); ?>

<main class="restaurants">
    <h1 class="title text-center"><?php the_title() ?></h1>
    <ul class="category-filter">
        <li><a href="#">All</a></li>
        <?php
        the_category();
        $categories = get_categories();
        foreach ($categories as $category) {
            if ($category->name === "New" || $category->name === "Most Popular" || $category->name == "Open Now") {
                ?>
                <li><a href="<?php the_permalink($category->name) ?>"><?php echo $category->name ?></a></li>
                <?php
            }
        }
        ?>
    </ul>
    <?php get_restaurants(); ?>
</main>

<?php get_footer() ?>
