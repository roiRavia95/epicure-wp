<?php
/*
 * Template Name: Login Page
 * */
get_header() ?>
<main class="login">
<div class="form-container">
    <div class="logo">
        <img src="<?php echo get_template_directory_uri() ?>/dist/images/logo/login-logo.png" alt="logo">
    </div>
    <form method="post" class="login-form" action="<?php esc_url(wp_login_url()) ?>">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="psw">Password</label>
            <input type="password" name="password" id="psw" required>
        </div>

        <div class="submit">
            <button type="submit" class="login" name="login">Login</button>
        </div>
    </form>
    <a href="<?php home_url() ?>/register">Don't have an account? Click here to Register!</a>
    <a href="/">Back to Epicure</a>
</div>
</main>
<?php get_footer();