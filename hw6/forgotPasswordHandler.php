<?php
session_start();
require_once 'Dao.php';
require_once 'KLogger.php';
require_once 'saveFormTxt.php';
$logger = new KLogger("log.txt", KLogger::DEBUG);
$_SESSION['red'] = $_POST;
$_SESSION['inputs'] = $_POST;
$dao = new Dao();

$email = $_POST['email'];
if ($email != '') {
    unset($_SESSION['red']['email']);
}

if ($email == '') {
    err("Email is blank", "Please provide your email address", 'forgotPassword.php');
}

/* email regex */
$regex = "/.+@.+\..+/";
if (preg_match($regex, $email) != 1) {
    $_SESSION['red']['email'] = 'set';
    err("Email doesn't fit pattern or does not exist", "The provided email does not exist", 'forgotPassword.php');
}

if ($dao->checkUser($email) != 1) {
    $_SESSION['red']['email'] = 'set';
    err($email . " not user", 'Your email is not a user\'s email', 'forgotPassword.php');
}

/* Final redirect after insertions */
$_SESSION['message'] = 'Success! Here\'s a hint: ' . $dao->getHint($email);
header("Location: forgotPassword.php");
exit();