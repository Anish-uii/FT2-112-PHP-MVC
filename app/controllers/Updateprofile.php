<?php
namespace App\Controllers;

use App\core\Controller;
use App\models\User; 
use App\models\Post;       
class Updateprofile
{
    use Controller, User, Post;
    public function index()
    {
        if (isset($_SESSION['registered']) && $_SESSION['registered'] == true) {
            $this->view('updateprofile');

            if (isset($_POST["submit"])) {
                $fname = trim($_POST["fname"]);
                $lname = trim($_POST["lname"]);
                $fullName = $fname . " " . $lname;
                $email = trim($_POST["email"]);
                $username = trim($_POST["username"]);
                $bio = trim($_POST["bio"]);

                $imageName = trim($_FILES["uploadImage"]["name"]);
                $imageLoc = trim($_FILES["uploadImage"]["tmp_name"]);

                
                if (!$imageName || !$imageLoc) {
                    $res = $this->updateUser($fullName, NULL, $email, $username, $bio);
                } else {
                    $imagePath = $this->uploadFile($imageName, $imageLoc);
                    if (!$imagePath) {
                        if (isset($_SESSION['error'])) {
                            echo "<script>alert(' " . $_SESSION['error'] . " Please try again.');</script>";
                            unset($_SESSION['error']);
                        }
                        header("Location: /public/createpost");
                        exit;
                    } else {
                        $res = $this->updateUser($fullName, $imagePath, $email, $username, $bio);
                    }
                }
                if ((is_bool($res)) && ($res == true)) {
                    header("Location: /public/welcome");
                    exit;  
                }
                else {
                    echo "<script>alert('$res');</script>";
                }
            }
        } else {
            $this->view('/');
        }
    }
}