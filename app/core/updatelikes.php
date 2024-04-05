<?php

class Likes
{
    public function updateLikes($postId, $username)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['postid'])  && isset($data['username'])) {
            $postId = $data['postid'];
            $username = $data['username'];

            $conn = mysqli_connect('localhost', 'anish-hell', '928485', 'USERS');
            $query = "UPDATE POSTS SET LIKES = LIKES + 1 WHERE POST_ID = '$postId'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                return json_encode($result);
            } else {
                return json_encode(["error" => "Cannot Insert data."]);
            }
        } else {
            return json_encode(["error" => "Missing parameters"]);
        }
    }
}

$likeUpdater = new Likes();

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $response = $likeUpdater->updateLikes(null, null);
    echo $response;
} else {
    echo json_encode(["error" => "Invalid request method"]);
}