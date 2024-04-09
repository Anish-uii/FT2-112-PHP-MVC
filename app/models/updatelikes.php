<?php

class Likes
{
    public function updateLikes($postId, $username)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['postid']) && isset($data['username'])) {
            $postId = $data['postid'];
            $username = $data['username'];

            $conn = mysqli_connect('localhost', 'anish-hell', '928485', 'USERS');
            $checkQuery = "SELECT * FROM LIKES WHERE USERNAME = '$username' AND POST_ID = '$postId'";
            $result = mysqli_query($conn, $checkQuery);

            if (mysqli_num_rows($result) > 0) {
                $UpdateLikesQuery = "UPDATE POSTS SET LIKES = LIKES - 1 WHERE POST_ID = '$postId'";
                $insertLikesQuery = "DELETE FROM LIKES WHERE POST_ID = '$postId'";

            } else {
                $UpdateLikesQuery = "UPDATE POSTS SET LIKES = LIKES + 1 WHERE POST_ID = '$postId'";
                $insertLikesQuery = "INSERT INTO LIKES (USERNAME, POST_ID, LIKE_STATUS) VALUES ('$username', '$postId', 1)";
            }
            if ( mysqli_query($conn, $UpdateLikesQuery) && mysqli_query($conn, $insertLikesQuery)) {
                $query = "SELECT LIKES FROM POSTS WHERE POST_ID = '$postId'"; 
                $likeCount = mysqli_query( $conn, $query);
                $likes = mysqli_fetch_assoc( $likeCount );
                return json_encode($likes["LIKES"]);
            } else {
                return json_encode(["error" => "Cannot Fetch data."]);
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