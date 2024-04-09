<?php
namespace App\Controllers;

use App\core\Controller;
use App\models\Post;

class Createpost
{
    use Controller, Post; 

    public function index()
    {
        if (isset($_SESSION['registered']) && $_SESSION['registered'] == true) {
            $this->view('createpost');

            if (isset($_POST['submit'])) {
                $imageName = trim($_FILES["uploadImage"]["name"]);
                $imageLoc = trim($_FILES["uploadImage"]["tmp_name"]);
                $postDesc = trim($_POST['post-desc']);
                $imagePath = $this->uploadFile($imageName, $imageLoc);
                if (!$imagePath) {
                    if (isset($_SESSION['error'])) {
                        echo "<script>alert(' " . $_SESSION['error'] . " Please try again.');</script>";
                        unset($_SESSION['error']);
                    }
                    header("Location: /public/createpost");
                    exit;
                } else {
                    $this->createNewPost($imagePath, $postDesc);
                }
            }
        } else {
            $this->view('/');
        }
    }

}