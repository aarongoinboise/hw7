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
$reenterPassword = $_POST['reenterPassword'];
if ($reenterPassword != '') {
  unset($_SESSION['red']['reenterPassword']);
}
$hint = $_POST['hint'];
if ($hint != '') {
  unset($_SESSION['red']['hint']);
}
$tutor = $_POST['tutor'];
if ($tutor != '') {
  unset($_SESSION['red']['tutor']);
}

if ($email == '' || $password == '' || $reenterPassword == '' || $hint == '' || $tutor == '') {
  err("One or more fields are blank", "Please make sure all options are filled out before signing up", 'signup.php');
}

/* email regex */
$regex = "/.+@.+\..+/";
if (preg_match($regex, $email) != 1) {
  $_SESSION['red']['email'] = 'set';
  err("Email doesn't fit pattern", "Email does not exist", 'signup.php');
}

if ($password != $reenterPassword) {
  $_SESSION['red']['password'] = 'set';
  $_SESSION['red']['reenterPassword'] = 'set';
  err("Passwords don't match", 'Passwords don\'t match', 'signup.php');
}

$dao = new Dao();
$isTutor;
if (is_numeric($tutor)) { // student account is trying to be created
  if ($dao->checkTutorNumber($tutor) == 1) {
    $isTutor = false;
  } else {
    $_SESSION['red']['tutor'] = 'set';
    err("Nonexistant tutor number", 'Tutor number doesn\'t exist', 'signup.php');
  }
} else {
  if ($tutor == 'tutor') {
    $isTutor = true;
  } else {
    $_SESSION['red']['tutor'] = 'set';
    err("Non-num string: tutor not used", '"tutor" or a valid number needs to be in the last box', 'signup.php');
  }
}

if ($dao->checkUser($email) == 1) { // send em back to signup, email already exists
  $_SESSION['red']['email'] = 'set';
  err($email . " already exists as an email", 'Email already exists, please try another', 'signup.php');
}

$u_id = $dao->saveUser($password, $email, $hint);
if ($u_id == 0) {
  err("signup parameter is too long", 'email, password, or hint information is too long', 'signup.php');
}
/* When reaching this point, all values are legit, user is created */
$extraInfo = '';
if ($isTutor) {
  $extraInfo = "Your tutor # is " . $dao->saveTutor($u_id) . "; your students need this # to create accounts";
} else {
  $dao->saveStudent($u_id, $tutor);
}

/* Final redirect after insertions */
$_SESSION['message'] = nl2br("Success! You may now login on the \"Sign In\" page." . "\n" . $extraInfo);
header("Location: signup.php");
exit();