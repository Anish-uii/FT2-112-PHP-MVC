<?php

class ShowComments
{
    public function displayAllComments($postid)
    {
        $conn = mysqli_connect('localhost', 'anish-hell', '928485', 'USERS');
        $query = "SELECT * FROM COMMENTS WHERE POST_ID = '$postid' ORDER BY COMMENT_ID DESC";
        $result = mysqli_query($conn, $query);
        $res = $result->fetch_all(MYSQLI_ASSOC);
        if (is_array($res)) {
            return json_encode($res);
        } else {
            return json_encode(["error" => "Cannot fetch data"]);
        }
    }
}

$commentsLoader = new ShowComments();
if (isset($_GET['postid'])) {
    $postid = $_GET['postid'];
    $comments = $commentsLoader->displayAllComments($postid); 
    echo $comments; 
} else {
    echo json_encode(["error" => "Invalid postid"]);
}