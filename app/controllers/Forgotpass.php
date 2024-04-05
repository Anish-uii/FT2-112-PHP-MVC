<?php
$model = new Model;
$model->modelCall('user');
class Forgotpass
{
    use Database, User, Controller;
    public function index()
    {
        if (isset($_SESSION['registered']) && $_SESSION['registered'] == true) {
            echo "<script>window.location.href ='/public/welcome';</script>";
        } else {
            $this->view('forgotpass');
            if (isset($_POST['submit'])) {
                $email = trim($_POST['email']);

                $response = $this->checkMail($email);
                if (!$response) {
                    echo "<script>alert('Email Not Found.');</script>";
                } else {
                    $token = md5(rand());

                    date_default_timezone_set('Asia/Kolkata');
                    $t = time();
                    $t = $t + (60 * 10);
                    $tokenTime = date('Y-m-d H:i:s', $t);

                    $update_query = $this->query("UPDATE USER_DATA SET TOKEN = '$token', TOKEN_TIME = '$tokenTime' WHERE EMAIL = '$email' OR USERNAME = '$email'");

                    if (!$update_query) {
                        echo "<script>alert('Data not inserted.');</script>";
                    } else {
                        $emailResponse = sendEmail($response['EMAIL'], $response['NAME'], $token);
                        echo "<script>alert(" . json_encode($emailResponse) . ");</script>";
                        echo "<script>window.location.href = '/'</script>";
                    }
                }
            }

        }
    }

}