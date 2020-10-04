<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head() ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="navigation-menu">
        <a href="#" class="menu-button">
            <img src="<?php echo get_template_directory_uri() ?>/images/hamburger/group-13@3x.png" alt="hamburger">
        </a>
        <div class="menu-pages">
            <a href="<?php echo esc_html(home_url()) ?>">
                <img class="logo" src="<?php echo get_template_directory_uri() ?>/images/logo/logo@3x.png" alt="logo">
            </a>
            <div class="menu-titles">
                <a href="<?php echo esc_html(home_url()) ?>">
                    <h1>EPICURE</h1>
                </a>
                <?php
                $args = array(
                    'theme-location' => 'main-menu',
                    'container' => 'nav',
                    'container_class' => 'main-nav',
                );
                wp_nav_menu($args);
                ?>
            </div>
        </div>
        <div class="menu-items">
            <?php echo get_template_part("templates/searchbar") ?>
            <a href="">
                <img src="<?php echo get_template_directory_uri() ?>/images/user-icon/user-icon@2x.png" alt="user">
            </a>
            <a href="">
                <img src="<?php echo get_template_directory_uri() ?>/images/bag-icon/bag-icon@2x.png" alt="bag">
            </a>
        </div>
    </div>

</header>