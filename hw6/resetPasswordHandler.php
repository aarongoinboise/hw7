<?php
session_start();
require_once 'Dao.php';
require_once 'KLogger.php';
require_once 'saveFormTxt.php';
$logger = new KLogger("log.txt", KLogger::DEBUG);
$_SESSION['red'] = $_POST;
$_SESSION['inputs'] = $_POST;

$email = $_POST['email'];
if ($email != '') {
    unset($_SESSION['red']['email']);
}
$password = $_POST['password'];
if ($password != '') {
    unset($_SESSION['red']['password']);
}
$newPassword = $_POST['newPassword'];
if ($newPassword != '') {
    unset($_SESSION['red']['newPassword']);
}
$reenterNewPassword = $_POST['reenterNewPassword'];
if ($reenterNewPassword != '') {
    unset($_SESSION['red']['reenterNewPassword']);
}

if ($email == '' || $password == '' || $newPassword == '' || $reenterNewPassword == '') {
    err("One or more fields are blank", "Please make sure all options are filled out before signing up", 'resetPassword.php');
}

/* email regex */
$regex = "/.+@.+\..+/";
if (preg_match($regex, $email) != 1) {
    $_SESSION['red']['email'] = 'set';
    err("Email doesn't fit pattern", "Email does not exist", 'resetPassword.php');
}

$dao = new Dao();

if ($dao->checkPassword($email, $password) != 1) {
    $_SESSION['red']['email'] = 'set';
    $_SESSION['red']['password'] = 'set';
    err($email . " does not exist", 'Email and/or password are not correct', 'resetPassword.php');
}

if ($password == $newPassword) {
    $_SESSION['red']['password'] = 'set';
    $_SESSION['red']['newPassword'] = 'set';
    err($password . " equals " . $newPassword, 'New password is the same as current password', 'resetPassword.php');
}

if ($newPassword != $reenterNewPassword) {
    $_SESSION['red']['newPassword'] = 'set';
    $_SESSION['red']['reenterNewPassword'] = 'set';
    err("New passwords don't match", 'New passwords don\'t match', 'resetPassword.php');
}

/* Final redirect after insertions */
if ($dao->resetPassword($email, $newPassword) === 1) {
    $_SESSION['message'] = 'Success! You have changed your password';
    header("Location: resetPassword.php");
    exit();
} else {
    err("Email or password is too long", 'Email or password is too long', 'resetPassword.php');
}