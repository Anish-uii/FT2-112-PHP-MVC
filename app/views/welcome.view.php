<?php
$loadposts = new Welcome;
$posts = $loadposts->getPosts();
$totalPosts = count($posts);
$userInfo = $loadposts->getUser($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social.com - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="<?php echo ROOT ?>/assets/css/wallpage.css">
</head>

<body>
    <section class="container">
        <header>
            <section class="navbar">
                <div class="logo">
                    <img src="<?php echo ROOT ?>/assets/images/logo.png" alt="LogoImage" class='logo-image'>
                </div>
                <div class="username-heading">
                    <h1>Hello
                        <?php echo $userInfo['USERNAME'] ?>
                    </h1>
                </div>
                <nav>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li><a href="/public/logout" id='logout-btn'>Logout</a></li>
                    </ul>
                    <a href="/public/profile">
                        <img src="<?php echo $userInfo['PROFILE_IMAGE'] ?>" alt="Profile Image">
                    </a>
                </nav>
            </section>
        </header>
        <main>
            <h1>See what's new around here..</h1>
            <section class="wall">
            </section>
            <section id="load-more-section" style>
                <button id="load-more-btn">Load More</button>
            </section>
        </main>
        <footer>
            <div class="create-post"><a href="/public/createpost"><i class="fa-solid fa-plus"></i></a></div>
            <p>&copy; 2024 Social.com</p>
        </footer>
    </section>

</body>
<script>
    var username = "<?php echo $_SESSION['username'] ?>";

</script>
<script src="<?php echo ROOT ?>/assets/js/script.js"></script>

</html>