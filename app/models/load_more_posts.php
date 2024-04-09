<?php

class PostLoader
{
    public function loadMorePosts($offset)
    {
        $conn = mysqli_connect('localhost', 'anish-hell', '928485', 'USERS');
        $query = "SELECT P.POST_ID, P.USERNAME, P.POST_DESCRIPTION, P.POST_DATE, P.IMAGE_PATH, P.LIKES, U.PROFILE_IMAGE AS PROFILE_IMAGE FROM POSTS P JOIN  USER_DATA U ON P.USERNAME = U.USERNAME ORDER BY P.POST_DATE DESC LIMIT $offset, 10;
        ";
        $result = mysqli_query($conn, $query);
        $res = $result->fetch_all(MYSQLI_ASSOC);
        if (is_array($res)) {
            return json_encode($res);
        } else {
            return json_encode(["error" => "Cannot fetch data"]);
        }
    }
}
$postLoader = new PostLoader();
if (isset($_GET['offset']) && is_numeric($_GET['offset'])) {
    $offset = $_GET['offset'];
    $posts = $postLoader->loadMorePosts($offset);
    echo $posts;
} else {
    echo json_encode(["error" => "Invalid offset"]);
}