<?php
session_start();
require_once '../Dao.php';
require_once '../KLogger.php';
require_once '../saveFormTxt.php';
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

$hint = $_POST['hint'];
if ($hint != '') {
    unset($_SESSION['red']['hint']);
}

if ($email == '' || $password == '' || $newPassword == '' || $reenterNewPassword == '' || $hint == '') {
    err("One or more fields are blank", "Please make sure all options are filled out before signing up", 'resetPassword.php');
}

/* email regex */
$regex = "/.+@.+\..+/";
$nonEmail = $wrongEP = $equalPass = $reentErr = $long = 0;
$bools = array($nonEmail, $wrongEP, $equalPass, $reentErr, $long);
$errmessages = array("Email does not exist", "Email and/or password are not correct", "New password is the same as current password", 'New passwords don\'t match', 'Hint is too long');
if (preg_match($regex, $email) != 1) {
    $bools[0] = 1;
    $_SESSION['red']['email'] = 'set';
    // err("Email doesn't fit pattern", "Email does not exist", 'resetPassword.php');
}

$dao = new Dao();
$salt = "fKd93Vmz!k*dAv5029Vkf9$3Aa";
if ($dao->checkPassword($email, hash("sha256", $password . $salt)) != 1) {
    $_SESSION['red']['email'] = 'set';
    $_SESSION['red']['password'] = 'set';
    $bools[1] = 1;
    // err("Email doesn't fit pattern", "Email and/or password are not correct", 'resetPassword.php');
}

if ($password == $newPassword) {
    $_SESSION['red']['password'] = 'set';
    $_SESSION['red']['newPassword'] = 'set';
    $bools[2] = 1;
    // err($password . " equals " . $newPassword, 'New password is the same as current password', 'resetPassword.php');
}

if ($newPassword != $reenterNewPassword) {
    $_SESSION['red']['newPassword'] = 'set';
    $_SESSION['red']['reenterNewPassword'] = 'set';
    $bools[3] = 1;
    // err("New passwords don't match", 'New passwords don\'t match', 'resetPassword.php');
}

if (strlen($hint)> 64) {
    $_SESSION['red']['hint'] = 'set';
    $bools[4] = 1;
}

$errS = '';
for ($i = 0; $i < 5; $i++) {
  if ($bools[$i] == 1) {
    $errS .= $errmessages[$i] . nl2br("\n");
  }
}

$sLen = strlen($errS);
if (strlen($errS) > 0) {
  err($errS, $errS, 'resetPassword.php');
}

/* Final redirect after insertions */
if ($dao->resetPassword($email, hash("sha256", $newPassword . $salt)) === 1) {
    $dao->resetHint($email, $hint);
    $_SESSION['message'] = 'Success! You have changed your password';
    header("Location: resetPassword.php");
    exit();
} else {
    err("Email or password is too long", 'New password or hint are too long', 'resetPassword.php');
}