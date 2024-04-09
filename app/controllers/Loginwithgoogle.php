<?php
namespace App\Controllers;

use App\core\Database;
use App\core\Controller;
use App\models\User;

class Loginwithgoogle
{
    use Controller, User, Database;

    public function index()
    {
        if (isset($_SESSION["registered"]) && $_SESSION["registered"]) {
            header('Location: /public/welcome');
            exit;
        } else {
            $this->googleLogin();
        }
    }
}