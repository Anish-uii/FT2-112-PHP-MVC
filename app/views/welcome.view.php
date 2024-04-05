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
                <?php

                if ($totalPosts <= 10):
                    $loadposts->displayPosts($posts);

                elseif ($totalPosts > 10):
                    $loadposts->displayPosts(array_slice($posts, 0, 10));
                    ?>
                    <section id="load-more-section">
                        <button id="load-more-btn">Load More</button>
                    </section>
                <?php endif; ?>
            </section>
        </main>
        <footer>
            <div class="create-post"><a href="/public/createpost"><i class="fa-solid fa-plus"></i></a></div>
            <p>&copy; 2024 Social.com</p>
        </footer>
    </section>

</body>
<script>

    $(document).ready(function () {
        $('#load-more-btn').on('click', function () {
            var displayedPosts = $('.wall .post').length;
            displayPosts(displayedPosts);
        });

        $("[id^='like-btn']").on("click", function (event) {
            event.preventDefault();
            var postId = $(this).attr('id').replace('like-btn', '');
        });
        $("[id^='comment-btn']").on("click", function (event) {
            event.preventDefault();
            var postId = $(this).attr('id').replace('comment-btn', '');
            $(".comment-container" + postId).toggle();
        });
    });

    function displayPosts(displayedPosts) {
        var totalPosts = <?php echo $totalPosts; ?>;
        var remainingPosts = totalPosts - displayedPosts;

        if (remainingPosts > 0) {
            $.ajax({
                url: '../app/core/load_more_posts.php',
                method: 'GET',  
                data: { offset: displayedPosts },
                success: function (response) {
                    var posts = JSON.parse(response);
                    if (posts.error) {
                        console.error(posts.error);
                        return;
                    }
                    posts.forEach(function (post) {   
                        var postHTML = `
                        <div class="post">
                            <div class="post-header">
                                <img src="${post.PROFILE_IMAGE}" alt="Profile Picture">
                                <div class="post-info">
                                    <h2>${post.USERNAME}</h2>
                                    <p>${getTimeDifference(post.POST_DATE)}</p>
                                </div>
                            </div>
                            <div class="post-content">
                                <img src="${post.IMAGE_PATH}" alt="" class="post-image">
                                <p>${post.POST_DESCRIPTION}</p>
                            </div>
                            <div class="reactions">
                                <a href="#" id="like-btn${post.POST_ID}"><span class="like"><i class="fa-regular fa-thumbs-up"></i></span></a>
                                <a href="#" id="comment-btn${post.POST_ID}"><span class="comment"><i class="fa-regular fa-comment"></i></span></a>
                                <div class="comment-container${post.POST_ID} commentbox">
                                    <h1>this is my comment</h1>
                                </div>
                            </div>
                        </div>`;
                        $('.wall').append(postHTML);
                    });

                    if (remainingPosts <= 10) {
                        $('#load-more-section').hide();
                    } else {
                        $('#load-more-section').appendTo('.wall');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
    function getTimeDifference(postDate) {
        var currentDate = new Date();
        var postDateTime = new Date(postDate);

        var timeDifference = Math.abs(currentDate - postDateTime);

        var seconds = Math.floor(timeDifference / 1000);
        var minutes = Math.floor(seconds / 60);
        var hours = Math.floor(minutes / 60);
        var days = Math.floor(hours / 24);
        var months = Math.floor(days / 30);

        if (months > 0) {
            return "Posted " + months + " month" + (months > 1 ? "s" : "") + " ago";
        } else if (days > 0) {
            return "Posted " + days + " day" + (days > 1 ? "s" : "") + " ago";
        } else if (hours > 0) {
            return "Posted " + hours + " hour" + (hours > 1 ? "s" : "") + " ago";
        } else if (minutes > 0) {
            return "Posted " + minutes + " minute" + (minutes > 1 ? "s" : "") + " ago";
        } else {
            return "Posted " + seconds + " second" + (seconds > 1 ? "s" : "") + " ago";
        }
    }
</script>
</html>