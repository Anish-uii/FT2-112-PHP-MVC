<?php

class Comment
{
    public function addComment($postId, $comment, $username)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        // var_dump($data);
        if (isset($data['postid']) && isset($data['comment']) && isset($data['username'])) {
            $postId = $data['postid'];
            $comment = $data['comment'];
            $username = $data['username'];

            $conn = mysqli_connect('localhost', 'anish-hell', '928485', 'USERS');
            $query = "INSERT INTO COMMENTS (POST_ID, COMMENT, USERNAME) VALUES ('$postId', '$comment','$username')";
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

$newComment = new Comment();

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $response = $newComment->addComment(null, null, null);
    echo $response;
} else {
    echo json_encode(["error" => "Invalid request method"]);
}