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

if ($email == '' || $password == '') {
    err("One or more fields are blank", "Please make sure all options are filled out before signing up", 'signin.php');
}

/* email regex */
$regex = "/.+@.+\..+/";
if (preg_match($regex, $email) != 1) {
    $_SESSION['red']['email'] = 'set';
    err("Email doesn't fit pattern", "Email does not exist", 'signin.php');
}

$dao = new Dao();

if ($dao->checkPassword($email, $password) != 1) {
    $_SESSION['red']['email'] = 'set';
    $_SESSION['red']['password'] = 'set';
    err($email . " does not exist", 'Email and/or password are not correct', 'signin.php');
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