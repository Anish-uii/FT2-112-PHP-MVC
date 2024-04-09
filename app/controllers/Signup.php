<?php
namespace App\Controllers;

use App\models\User;
use App\core\Database;
use App\core\Controller;
class Signup
{
    use Database, User, Controller;

    public function index()
    {
        if (isset($_SESSION['registered']) && $_SESSION['registered'] == true) {
            echo "<script>window.location.href ='/public/welcome';</script>";
        } else {
            $this->view('signup');

            if (isset($_POST["submit"])) {
                $fname = trim($_POST['fname']);
                $lname = trim($_POST['lname']);
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $email = trim($_POST['email']);
                $fullname = $fname . ' ' . $lname;

                $response = $this->insert($fullname, $username, $password, $email);
                
                if ($response === true) {
                    $_SESSION['registered'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    echo "<script>window.location.href = '/public/welcome';</script>";
                } else {
                    echo "<script>alert(' " . addslashes($response) . " Please try again.');</script>";
                }
            }
        }
    }
}