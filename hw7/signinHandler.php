<?php

session_start();
require_once 'Dao.php';
require_once 'saveFormTxt.php';
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
$errM = '';
if ($email == '' || $password == '') {
    $errM .= 'Please make sure all options are filled out before signing up' . nl2br("\n");
}

/* email regex */
$regex = "/.+@.+\..+/";
if (preg_match($regex, $email) != 1) {
    $_SESSION['red']['email'] = 'set';
    $errM .= 'Email does not exist' . nl2br("\n");
}

$dao = new Dao();

if ($dao->checkUser($email) != 1) {
    $_SESSION['red']['email'] = 'set';
    $errM .= 'Email is not correct' . nl2br("\n");
}
$salt = "fKd93Vmz!k*dAv5029Vkf9$3Aa";
if ($dao->checkPassword($email, hash("sha256", $password . $salt)) != 1) {
    $_SESSION['red']['password'] = 'set';
    $errM .= 'Password is not correct' . nl2br("\n");
}

if ($errM != '') {
    err('login info wrong', $errM, 'signin.php');
}

$isTutor;
/* Check type of account */
$isTutor = ($dao->checkTutorFromEmail($email) == 1) ? true : false;

/* Final redirect after insertions */
$_SESSION['message'] = 'Success! You are now signed in!';
$_SESSION['userEmail'] = "$email";
header("Location: homeM.php");
$_SESSION['mType'] = ($isTutor) ? 'tutor' : 'student';
exit();