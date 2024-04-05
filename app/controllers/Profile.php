<?php
$model = new Model;
$model->modelCall('post');
$model->modelCall('user');
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