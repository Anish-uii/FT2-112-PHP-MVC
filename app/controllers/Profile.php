<?php
namespace App\Controllers;

use App\models\User;
use App\models\Post;
use App\core\Controller;

class Profile
{
    use User, Post, Controller;
    public function index()
    {
        if (isset($_SESSION['registered']) && $_SESSION['registered'] == true) {
            $this->view("profile");
        } else {
            $this->view('/');
        }
    }
}