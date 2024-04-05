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
    function displayPosts($posts)
    {

        foreach ($posts as $post):
            $singleUserInfo = $this->getUser($post["USERNAME"]);?>
        
            <div class="post">
                <div class="post-header">
                    <img src="<?php
                    echo $singleUserInfo['PROFILE_IMAGE'] ?>" alt="Profile Picture">
                    <div class="post-info">
                        <h2>
                            <?php echo $post['USERNAME']; ?>
                        </h2>
                        <p>
                            <?php echo getTimeDifference($post['POST_DATE']); ?>
                        </p>
                    </div>
                </div>
                <div class="post-content">
                    <img src="<?php echo $post['IMAGE_PATH']; ?>" alt="" class="post-image">
                    <p>
                        <?php echo $post['POST_DESCRIPTION']; ?>
                    </p>
                </div>
                <div class="reactions">
                    <a href='#' id="like-btn<?php echo $post['POST_ID'] ?>"><span class="like"><i class="fa-regular fa-thumbs-up"></i></span></a>
                    <a href='#' id="comment-btn<?php echo $post['POST_ID'] ?>"><span class="comment"><i
                                class="fa-regular fa-comment"></i></span></a>
                    <div class="comment-container<?php echo $post['POST_ID'] ?> commentbox">
                        <h1>this is my comment</h1>
                    </div>
                </div>
            </div>

            <?php
            $_SESSION['lastpostid'] = $post['POST_ID'];
        endforeach;
    }
}