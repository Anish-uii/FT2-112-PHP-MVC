<?php

trait Post
{
    use Database;

    public function createNewPost($imagePath, $postDesc)
    {
        $postId = uniqid();

        date_default_timezone_set('Asia/Kolkata');
        $postTime = date('Y-m-d H:i:s', time());
        $username = $_SESSION['username'];
        $query = "INSERT INTO POSTS(POST_ID, USERNAME, POST_DESCRIPTION, POST_DATE, IMAGE_PATH) VALUES ('$postId','$username','$postDesc','$postTime','$imagePath')";

        $response = $this->query($query);
        if ($response === true) {
            echo "<script>alert('Posted Successfully !!');</script>";
            header("Location: /public/welcome");
            exit;
        } else {
            echo "<script>alert('Error : " . addslashes($response) . "');</script>";
        }

    }
    public function getPosts()
    {
        $query = "SELECT * FROM POSTS ORDER BY POST_DATE DESC";
        $response = $this->query($query);

        $res = $response->fetch_all(MYSQLI_ASSOC);

        if (is_array($res)) {
            return $res;
        } else {
            echo "<script>alert('Error Fetching Posts. !!');</script>";
        }
    }
    public function userPosts($username)
    {
        $query = "SELECT POST_DESCRIPTION, POST_DATE, IMAGE_PATH FROM POSTS  WHERE USERNAME = '$username' ORDER BY POST_DATE DESC";
        $response = $this->query($query);

        $res = $response->fetch_all(MYSQLI_ASSOC);

        if (is_array($res)) {
            return $res;
        } else {
            echo "<script>alert('Error Fetching Posts. !!');</script>";
        }
    }
    public function deletePost($postId)
    {
        $query = "";
    }
}