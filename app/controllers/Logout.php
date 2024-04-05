<?php
require '../app/core/google-config.php';

$google_client->revokeToken();
session_unset();
session_destroy();

header("Location: /");

exit();