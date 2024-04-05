<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo ROOT ?>/assets/css/styles.css">
    <title>Login</title>
</head>

<body>
    <section class="container">
        <form action="" class="name-form" method='post'>
            <label for="username">Username : </label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password : </label>
            <input type="password" name="password" id="password" required>
            <a href="<?php echo ROOT ?>/forgotpass">Forgot Password?</a>
            <input type="submit" value="Login" name='submit'>
            <a class="google-btn" href="<?php echo ROOT ?>/loginwithgoogle"><img id="google-img" src="<?php echo ROOT ?>/assets/images/google.png" alt="Google Logo"> Google Login</a>
            <span class='signup-link'>New user? <a href="<?php echo ROOT ?>/signup">Sign up from here</a>.</span>
        </form>
    </section>
</body>

</html>