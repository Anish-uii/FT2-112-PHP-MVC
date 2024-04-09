<?php

namespace App\core;
trait Controller
{
    public function view($name)
    {
        $fileName = "../app/views/" . $name . ".view.php";
        if (file_exists($fileName)) {
            require $fileName;
        } else {
            $fileName = "../app/views/Error404.view.php";
            require $fileName;
        }
    }
}