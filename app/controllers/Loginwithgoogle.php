<?php
$model = new Model;
$model->modelCall('user');
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