<?php
trait User
{
    use Database;
    public function insert($fullName, $userName, $password, $email, $profileImagePath = null)
    {
        $userId = uniqid();
        $emailres = emailValidation($email);
        if ($emailres === true) {
            $query = "INSERT INTO USER_DATA (USER_ID, NAME, USERNAME, PASSWORD, EMAIL, PROFILE_IMAGE) VALUES ('$userId','$fullName','$userName','$password','$email', '$profileImagePath')";
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
        } else {
            return $emailres;
        }
    }
    public function verifyUser($username, $password)
    {

        $query = "SELECT PASSWORD FROM USER_DATA WHERE USERNAME = '$username'";
        $response = $this->query($query);
        $res = mysqli_fetch_assoc($response);

        if (!$res || empty($res)) {
            return "No User Found !! Please check the details, and try again.";
        } else {
            $hashed_password = $res['PASSWORD'];

            if (!password_verify($password, $hashed_password)) {
                return "Invalid Username or password, please try again !!";
            } else {
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
        $response = $this->query("UPDATE USER_DATA SET NAME = '$fullName', PROFILE_IMAGE = '$profileImage', EMAIL='$email', USERNAME='$username', BIO='$bio' WHERE USERNAME = '$oldUsername'");

        if (!$response) {
            return false;
        } else {
            $_SESSION["username"] = $username;
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
        require '../app/core/google-config.php';

        if (isset($_GET["code"])) {
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

            if (!isset($token['error'])) {

                $google_client->setAccessToken($token['access_token']);

                $_SESSION['access_token'] = $token['access_token'];

                $google_service = new Google_Service_Oauth2($google_client);

                $data = $google_service->userinfo->get();

                $password = password_hash($data->id, PASSWORD_DEFAULT);

                $username = explode("@", $data->email);
               
                $response = $this->insert($data->name, $username[0], $password, $data->email, $data->picture);
                if ($response) {
                    $_SESSION["registered"] = true;
                    $_SESSION["username"] = $username[0];
                    header("Location: /public/welcome");
                    exit;
                } else {
                    echo "Login Failed.";
                }
            }
        }
        if (!isset($_SESSION['access_token'])) {

            $login_url = $google_client->createAuthUrl();
            header("Location: $login_url");
            exit;
        }
    }
}