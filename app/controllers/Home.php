<?php
$model = new Model;
$model->modelCall('user');

class Home
{
    use Database, User, Controller;

    public function index()
    {

        if (isset($_SESSION['registered']) && $_SESSION['registered'] == true) {
            echo "<script>window.location.href ='/public/welcome';</script>";
        } else {
            $this->view('login');
            if (isset($_POST["submit"])) {
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);

                $response = $this->verifyUser($username, $password);

                if ($response === true) {
                    $_SESSION['registered'] = true;
                    $_SESSION['username'] = $username;
                    echo "<script>window.location.href ='/public/welcome';</script>";
                } else {
                    echo "<script>alert('Please enter valid Username and Password.');</script>";
                }
            }

        }
    }
}
