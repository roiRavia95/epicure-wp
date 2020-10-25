<?php
/*
 * Template Name: Register Page
 * */
get_header() ?>
<main class="register">
<div class="form-container">
    <div class="logo">
        <img src="<?php echo get_template_directory_uri() ?>/dist/images/logo/login-logo.png" alt="logo">
    </div>
    <form method="post" class="register-form">
        <div>
            <label for="name">Username</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="psw">Password</label>
            <input type="password" name="password" id="psw" required>
        </div>
        <div>
            <label for="psw">Confirm Password</label>
            <input type="password" name="confirm_password" id="psw" required>
        </div>
        <div class="submit">
            <button type="submit" class="register" name="register">Register</button>
        </div>
    </form>
    <a href="<?php home_url() ?>/login">Login</a>
    <a href="/">Back to Epicure</a>
</div>
</main>

<?php get_footer();