function displayPosts(displayedPosts) {
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
            loadPosts(posts);

            if (posts.length < 10) {
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

function updateLikes(postId, username) {
    $.ajax({
        url: '../app/core/updatelikes.php',
        method: 'PUT',
        data: JSON.stringify({ postid: postId, username: username }),
        contentType: 'application/json',
        success: function (response) {
            var res = JSON.parse(response);
            if (res.error) {
                console.error(res.error);
                return;
            }
            console.log("After AJAX Call");
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function loadPosts(posts) {
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
                            <a href="#" id="like-btn${post.POST_ID}"><span class="like"><i class="fa-regular fa-thumbs-up" id="likebtn${post.POST_ID}"></i></span></a>
                            <span class="totallikes${post.POST_ID}"></span>
                            <a href="#" id="comment-btn${post.POST_ID}"><span class="comment"><i class="fa-regular fa-comment" id="commentbtn${post.POST_ID}"></i></span></a>
                            <div class="comment-container${post.POST_ID} commentbox">
                                <form action="" class="comment-form">
                                    <div class="new-comment">
                                    <input type="text" name="comment" id="comment${post.POST_ID}"
                                        placeholder="Write a comment.." required >
                                    <button type="button" class="submit-comment-btn" data-post-id="${post.POST_ID}">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                    </div>
                                </form>
                                <div class="allcomments"></div>
                            </div>
                        </div>
                    </div>`;
        $('.wall').append(postHTML);
    });
}

function submitComment(postId, commentText, username) {
    $.ajax({
        url: '../app/core/add_comments.php',
        method: 'PUT',
        data: JSON.stringify({ postid: postId, comment: commentText, username: username }),
        contentType: 'application/json',
        success: function (response) {
            var res = JSON.parse(response);
            if (res.error) {
                console.error(res.error);
                return;
            }

            $('#comment' + postId).val('');
            $(".allcomments").children().remove();
            displayComments(postId);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function displayComments(postId) {
    $.ajax({
        url: '../app/core/showcomments.php',
        method: 'GET',
        data: { postid: postId },
        success: function (response) {
            var res = JSON.parse(response);
            if (res.error) {
                console.error(res.error);
                return;
            }
            res.forEach(function (comment) {
                var commentHTML = `
                <div class="comment">
                    <span class="comment-username">${comment.USERNAME}:</span>
                    <span class="comment-text">${comment.COMMENT}</span>
                </div>`;
                $('.wall .comment-container' + postId + ' .allcomments').append(commentHTML);
            });
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
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