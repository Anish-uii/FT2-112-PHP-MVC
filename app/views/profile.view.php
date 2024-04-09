<?php
$loadUserPosts = new App\Controllers\Profile;
$posts = $loadUserPosts->userPosts($_SESSION['username']);
$userInfo = $loadUserPosts->getUser($_SESSION['username']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo ROOT ?>/assets/css/profilepage.css">
    <title>Profile</title>
</head>

<body>
    <section class="container">
        <header>
            <section class="navbar">
                <div class="navbar-left">
                    <div class="profile">
                        <img src="<?php echo $userInfo['PROFILE_IMAGE']; ?>" alt="Profile Picture"
                            class='profile-image'>
                    </div>
                </div>
                <nav>
                    <ul>
                        <li><a href="/public/welcome">Home</a></li>
                        <li><a href="/public/profile">Profile</a></li>
                        <li><a href="/public/logout" id="logout-btn">Logout</a></li>
                    </ul>
                </nav>
            </section>
            <section class="userBio">
                <a href="/public/updateprofile"><span><i class="fa-solid fa-pen-to-square"></i></span>Edit Profile</a>
                <div class="bio">
                    <?php echo "<h1>" . $userInfo['NAME'] . "</h1>";
                    echo "<p>" . $userInfo['USERNAME'] . "</p>";
                    echo "<p>" . $userInfo['BIO'] . "</p>"; ?>
                </div>

            </section>
        </header>
        <main>

            <section class="wall">
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <div class="post-top">
                            <img src="<?php echo $post['IMAGE_PATH']; ?>" alt="Post Image" class="post-image">
                        </div>
                        <div class="post-header2">
                            <div class="post-info">
                                <h2>
                                    <?php echo $post['POST_DESCRIPTION']; ?>
                                </h2>
                                <p>Posted on
                                    <?php echo $post['POST_DATE']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </main>
        <footer></footer>
    </section>

</body>

</html>