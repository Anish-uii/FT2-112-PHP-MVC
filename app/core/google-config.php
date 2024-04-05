<?php
require_once '../vendor/autoload.php';

$google_client = new Google_Client();

$google_client->setClientId('46504147362-69cho8cs495vhq3tr74iol5s0g0q0iec.apps.googleusercontent.com');
$google_client->setClientSecret('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');

$google_client->setRedirectUri('http://www.social.com/public/loginwithgoogle');

$google_client->addScope('email');
$google_client->addScope('profile');