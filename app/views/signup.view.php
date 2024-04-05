<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo ROOT ?>/assets/css/styles.css">
    <title>Sign Up</title>
</head>

<body>
    <section class="container">
        <form action="" method='post' class="name-form" id='myForm'>
            <label for="fname">Enter Name : </label>
            <div>
                <input type="text" name="fname" id="fname" placeholder="First Name" required>
                <input type="text" name="lname" id="lname" placeholder="Last Name">
            </div>
            <label for="username">Enter Username : </label>
            <input type="text" name="username" id="username" required placeholder='Ex: name123'>
            <label for="password">Enter Password : </label>
            <div class="password-container">
                <input type="password" name="password" id="password" required>
                <span class="eye-icon" onclick="togglePasswordVisibility('password')">
                    <i class="fa-solid fa-eye hide-btn"></i>
                </span>
            </div>
            <label for="repassword">Confirm Password : </label>
            <div class="password-container">
                <input type="password" name="repassword" id="repassword" required>
                <span class="eye-icon" onclick="togglePasswordVisibility('repassword')">
                    <i class="fa-solid fa-eye hide-btn"></i>
                </span>
            </div>
            <span id="passwordError" style="color: red; display: none;">Passwords do not match!</span>
            <label for="email">Enter Email</label>
            <input type="email" name="email" id="email" placeholder="abc@example.com">
            <input type="submit" value="Sign Up" name='submit'>
            <span class='signup-link'>Already a user? <a href="<?php echo ROOT ?>/">Login from here</a>.</span>
        </form>
    </section>
    <!-- Linking to external JavaScript file -->
    <script src="<?php echo ROOT ?>/assets/js/signup.js"></script>

</body>

</html>