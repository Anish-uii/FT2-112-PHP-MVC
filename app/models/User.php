<?php

namespace App\Models;

use App\core\Database;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
trait User
{
    use Database;
    public function insert($fullName, $userName, $password, $email, $profileImagePath = null)
    {
        $userId = uniqid();
        $emailres = $this->emailValidation($email);
        $emailres = true;
        if ($emailres === true) {
            if ($profileImagePath == NULL) {
                $query = "INSERT INTO USER_DATA (USER_ID, NAME, USERNAME, PASSWORD, EMAIL) VALUES ('$userId','$fullName','$userName','$password','$email')";
            } else {
                $query = "INSERT INTO USER_DATA (USER_ID, NAME, USERNAME, PASSWORD, EMAIL, PROFILE_IMAGE) VALUES ('$userId','$fullName','$userName','$password','$email', '$profileImagePath')";
            }
            $response = $this->query($query);
            if ($response === true) {
                return true;
            } else {
                if (strpos($response, 'Duplicate entry') !== false) {
                    return "Error: Duplicate entry for email '$email'";
                } else {
                    return "Error: " . $response;
                }
            }
        }
    }
    public function verifyUser($username, $password)
    {

        $query = "SELECT EMAIL,PASSWORD FROM USER_DATA WHERE USERNAME = '$username'";
        $response = $this->query($query);
        $res = mysqli_fetch_assoc($response);

        if (!$res || empty($res)) {
            return "No User Found !! Please check the details, and try again.";
        } else {
            $hashed_password = $res['PASSWORD'];

            if (!password_verify($password, $hashed_password)) {
                return "Invalid Username or password, please try again !!";
            } else {
                $_SESSION['email'] = $res["EMAIL"];
                return true;
            }
        }
    }

    public function checkMail($email)
    {
        $query = "SELECT NAME,EMAIL FROM USER_DATA WHERE USERNAME = '$email' OR EMAIL = '$email'";

        $response = $this->query($query);
        $res = mysqli_fetch_assoc($response);

        if (!$res) {
            return false;
        } else {
            return $res;
        }
    }
    public function getUser($username)
    {
        $query = "SELECT * FROM USER_DATA WHERE USERNAME = '$username'";
        $response = $this->query($query);

        $res = mysqli_fetch_assoc($response);

        if (!$res) {
            return false;
        } else {
            return $res;
        }
    }

    public function updateUser($fullName, $profileImage, $email, $username, $bio)
    {
        $oldUsername = $_SESSION['username'];
        $oldEmail = $_SESSION['email'];

        if ($oldEmail != $email) {
            $checkUser = $this->query("SELECT USERNAME, EMAIL FROM USER_DATA WHERE EMAIL = '$email'");
            if ($checkUser && mysqli_num_rows($checkUser) > 0) {
                return "Same Email already exists.";
            }
        }
        if ($oldUsername != $username) {
            $checkUser = $this->query("SELECT USERNAME, EMAIL FROM USER_DATA WHERE USERNAME = '$username'");
            if ($checkUser && mysqli_num_rows($checkUser) > 0) {
                return "Same Username already exists.";
            }
        }

        $response = $this->query("UPDATE USER_DATA SET NAME = '$fullName', PROFILE_IMAGE = '$profileImage', EMAIL='$email', USERNAME='$username', BIO='$bio' WHERE USERNAME = '$oldUsername'");

        if (!$response) {
            return false;
        } else {
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;
            return true;
        }
    }


    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare('SELECT * FROM USER_DATA WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function googleLogin()
    {
        $google_client = new \Google_Client();

        $google_client->setClientId('46504147362-69cho8cs495vhq3tr74iol5s0g0q0iec.apps.googleusercontent.com');
        $google_client->setClientSecret('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');

        $google_client->setRedirectUri('http://www.social.com/public/loginwithgoogle');

        $google_client->addScope('email');
        $google_client->addScope('profile');
        if (isset($_GET["code"])) {
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

            if (!isset($token['error'])) {

                $google_client->setAccessToken($token['access_token']);

                $_SESSION['access_token'] = $token['access_token'];

                $google_service = new \Google_Service_Oauth2($google_client);

                $data = $google_service->userinfo->get();

                $password = password_hash($data->id, PASSWORD_DEFAULT);

                $username = explode("@", $data->email);
                $user = $this->getUser($username);
                var_dump($user);
                if ($user["USERNAME"] == $username) {
                    $_SESSION["registered"] = true;
                    $_SESSION["username"] = $username[0];
                    $_SESSION["email"] = $data->email;
                    header("Location: /public/welcome");
                    exit;
                } else {
                    $response = $this->insert($data->name, $username[0], $password, $data->email, $data->picture);
                    if ($response) {
                        $_SESSION["registered"] = true;
                        $_SESSION["username"] = $username[0];
                        $_SESSION["email"] = $data->email;
                        header("Location: /public/welcome");
                        exit;
                    } else {
                        echo "Login Failed.";
                    }
                }

            }
        }
        if (!isset($_SESSION['access_token'])) {

            $login_url = $google_client->createAuthUrl();
            header("Location: $login_url");
            exit;
        }
    }
    public function emailValidation($email)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1/?api_key=82c5cf82a3464a76bb355d863785a0a7&email=$email",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);
        $res = json_decode($response, true);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "Error: CURL Error #" . $err;
        } else if (!isset($res["is_valid_format"]) || !$res["is_valid_format"]["value"] || !$res["is_smtp_valid"]["value"] || !empty($res["autocorrect"])) {
            return "Sorry! Inserted Email ID doesn't exist.";
        } else {
            return true;
        }
    }
    public function sendEmail($email, $name, $token)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'anishchoudhary9285@gmail.com';
            $mail->Password = 'xnop pavg etxf mexy ';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('anishchoudhary9285@gmail.com', 'Anish Choudhary');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Regarding password reset.';
            $mail->Body = "<h2>Hello $name .</h2><br><br><b>Here is your reset link.</b><br><br>Click <a href='" . ROOT . "/resetpassword/?token=$token&email=$email'>here</a> to reset your password.";

            $mail->send();
            return 'Reset link has been sent. Please check your email.';
        } catch (Exception $e) {
            return "Oops! Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}