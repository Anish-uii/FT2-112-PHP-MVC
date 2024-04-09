<?php

$google_client = new \Google_Client();

$google_client->revokeToken();
session_unset();
session_destroy();

header("Location: /");

exit();