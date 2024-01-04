<?php
// Include necessary classes
include_once __DIR__ . "/../includes/Database.class.php";
include_once __DIR__ . "/../includes/User.class.php";
include_once __DIR__ . "/../includes/Session.class.php";
include_once __DIR__ . "/../includes/User.session.class.php";
include_once __DIR__ . "/../includes/mailer.class.php";

// Start a session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
