$(document).ready(function () {
    $("[id^='like-btn']").on("click", function (event) {
        event.preventDefault();
        var postId = $(this).attr('id').replace('like-btn', '');
        console.log("Like");
    });
    $("[id^='comment-btn']").on("click", function (event) {
        event.preventDefault();
        var postId = $(this).attr('id').replace('comment-btn', '');
        $(".comment-container" + postId).toggle();
        console.log("Comment");
        console.log(postId );
    });
});
