<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
    wp_head()?>
    <!--Get WP_Ajax url and nonce for every file.-->
    <script type="text/javascript">
        let ajaxURL = "<?php echo admin_url('admin-ajax.php'); ?>";
        let nonce = "<?php echo wp_create_nonce('nonce_name')?>"
    </script>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="navigation-menu">
        <a href="#" class="menu-button">
            <img src="<?php echo get_template_directory_uri() ?>/images/hamburger/group-13@3x.png" alt="hamburger">
        </a>
        <div class="mobile-hamburger-menu">
            <div>
                <img class="exit-button" src="<?php echo get_template_directory_uri() ?>/images/exit-icon/x.png" alt="">
            </div>
            <hr>
            <?php wp_nav_menu(array("theme_location" => "main-menu")); ?>
            <?php wp_nav_menu(array("theme_location" => "footer-menu")); ?>
        </div>
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
            <?php echo get_template_part("templates/searchbar");
            $userPage = home_url();
            if (is_user_logged_in()) {
                $userPage .= "/user/" . wp_get_current_user()->user_nicename;
                ?>
                <a class="logout" href="<?php echo wp_logout_url() ?>" >Logout</a>
                <?php
            } else {
                $userPage .= "/login";
            }
            //Save user id and pass it to js
            $current_user_id =  get_current_user_id();
            ?>
            <p id="current-user-id" style="display:none;"><?php echo $current_user_id ?></p>
            <a href="<?php echo $userPage ?>">
                <img src="<?php echo get_template_directory_uri() ?>/images/user-icon/user-icon@2x.png" alt="user">
            </a>
            <a class="item-bag" href="<?php the_permalink(get_page_by_title('bag')->ID) ?>">
                <div class="item-badge">
                </div>
                <div class="bag-items">

                </div>
                <img src="<?php echo get_template_directory_uri() ?>/images/bag-icon/bag-icon@2x.png" alt="bag">
            </a>
        </div>
    </div>
    <div class="mobile-search">
        <?php echo get_template_part("templates/searchbar") ?>
    </div>

</header>