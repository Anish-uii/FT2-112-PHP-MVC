<?php
$model = new Model;
$model->modelCall('post');
$model->modelCall('user');

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