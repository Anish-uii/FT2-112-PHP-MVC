<?php
namespace App\Controllers;

use App\models\User;
use App\models\Post;
use App\core\Controller;
class Welcome
{
    use Post, User, Controller;
    public function index()
    {
        if (isset($_SESSION['registered']) && $_SESSION['registered'] == true) {
            $this->view('welcome');
        } else {
            echo "<script>window.location.href ='/';</script>";
        }
    }
}