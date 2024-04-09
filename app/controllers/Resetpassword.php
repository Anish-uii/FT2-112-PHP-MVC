<?php
namespace App\Controllers;

use App\core\Controller;
use App\core\Database;
class Resetpassword
{
    use Database, Controller;
    public function index()
    {
        if (!isset($_SESSION['registered']) ||  $_SESSION['registered'] !== true) {
            if (isset($_GET['token']) && isset($_GET['email'])) {

                $token = $_GET['token'];
                $email = $_GET['email'];

                $validateToken = mysqli_fetch_assoc($this->query("SELECT TOKEN, TOKEN_TIME FROM USER_DATA WHERE TOKEN = '$token'"));

                if (!$validateToken) {
                    echo "<h2>Invalid Token.</h2>";
                } else {
                    date_default_timezone_set('Asia/Kolkata');
                    $time = time();
                    $currentTime = date('Y-m-d H:i:s', $time);
                    if ($currentTime > $validateToken['TOKEN_TIME']) {
                        echo '<h2>The Link has expired please try again.</h2>';
                    } else {
                        if (isset($_POST["submit"])) {
                            try {
                                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                                $update_password = $this->query("UPDATE USER_DATA SET password = '$password' WHERE EMAIL = '$email'");

                                if (!$update_password) {
                                    throw new \Exception("There was some error please try again.");
                                } else {
                                    $removeToken = $this->query("UPDATE USER_DATA SET TOKEN = NULL,TOKEN_TIME = NULL WHERE EMAIL = '$email'");
                                    echo "<script>window.location.href = '/'</script>";
                                }
                            } catch (\Exception $e) {
                                echo "" . $e->getMessage();
                            }
                        }
                        $this->view('resetpassword');
                    }
                }
            } else {
                $this->view('error404');
            }

        }
        else {
            $this->view('welcome');
        }
    }
}