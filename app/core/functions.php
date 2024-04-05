<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function emailValidation($email)
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

function sendEmail($email, $name, $token)
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

function uploadFile($imageName, $imageLoc)
{
    $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        return false;
    } else {
        $imagePath = "../public/assets/images/$imageName";
        if (move_uploaded_file($imageLoc, $imagePath)) {
            $_SESSION['success'] = "File uploaded successfully.";
            return $imagePath;
        } else {
            $_SESSION['error'] = "Error uploading file.";
            return false;
        }
    }
}
function getTimeDifference($postDate)
{

    $postTime = strtotime($postDate);
    $currentTime = time();
    $timeDifference = $currentTime - $postTime;

    $intervals = array(
        1 => array('year', 31556926),
        $timeDifference < 31556926 => array('month', 2628000),
        $timeDifference < 2629744 => array('week', 604800),
        $timeDifference < 604800 => array('day', 86400),
        $timeDifference < 86400 => array('hour', 3600),
        $timeDifference < 3600 => array('minute', 60),
        $timeDifference < 60 => array('second', 1)
    );

    $postedMessage = '';
    foreach ($intervals as $interval => $value) {
        $duration = floor($timeDifference / $value[1]);
        if ($duration >= 1) {
            $postedMessage = "Posted $duration " . $value[0] . ($duration > 1 ? 's' : '') . " ago";
            break;
        }
    }
    return $postedMessage;
}
