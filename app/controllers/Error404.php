<?php
namespace App\Controllers;

use App\core\Controller;
class Error404
{
    use Controller;
    public function index()
    {
        $this->view("error404");
    }
}