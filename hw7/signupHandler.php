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

// if ($email == '' || $password == '' || $reenterPassword == '' || $hint == '' || $tutor == '') {
//   err("One or more fields are blank", "Please make sure all options are filled out before signing up", 'signup.php');
// }

/* email regex */
$regex = "/.+@.+\..+/";
$nonEmail = $pNoMatch = $ghostTNum = $nonTString = $eAlreadyExists = $long = 0;
$bools = array($nonEmail, $pNoMatch, $ghostTNum, $nonTString, $eAlreadyExists, $long);
$errmessages = array("Email does not exist", "Passwords don't match", "Tutor number doesn't exist", "\"tutor\" or valid number needs to be in last box", "Email already exists, please try another", "email and/or hint information is too long");

if (preg_match($regex, $email) != 1) {
  $bools[0] = 1;
  $_SESSION['red']['email'] = 'set';
}
// err("Email doesn't fit pattern", "Email does not exist", 'signup.php');


if ($password != $reenterPassword) {
  $bools[1] = 1;
  $_SESSION['red']['password'] = 'set';
  $_SESSION['red']['reenterPassword'] = 'set';
  // err("Passwords don't match", 'Passwords don\'t match', 'signup.php');
}

$dao = new Dao();
$isTutor;
$tutorNRet;
if (is_numeric($tutor)) { // student account is trying to be created
  $tutorNRet = $dao->checkTutorNumber($tutor);
  if ($tutorNRet == 1) {
    $isTutor = false;
  } else {
    $bools[2] = 1;
    $_SESSION['red']['tutor'] = 'set';
    // err("Nonexistant tutor number", 'Tutor number doesn\'t exist', 'signup.php');
  }
} else {
  if ($tutor == 'tutor') {
    $isTutor = true;
  } else {
    $bools[3] = 1;
    $_SESSION['red']['tutor'] = 'set';
    // err("Non-num string: tutor not used", '"tutor" or a valid number needs to be in the last box', 'signup.php');
  }
}

if ($dao->checkUser($email) == 1) { // send em back to signup, email already exists
  $bools[4] = 1;
  $_SESSION['red']['email'] = 'set';
  // err($email . " already exists as an email", 'Email already exists, please try another', 'signup.php');
}

if(strlen($email) > 100 || strlen($hint) > 64) {
  $bools[5] = 1;
  if (strlen($email) > 100) {
  $_SESSION['red']['email'] = 'set';
  } 
  if (strlen($hint) > 64) {
    $_SESSION['red']['hint'] = 'set';
  }
}

$errS = '';
for ($i = 0; $i < 6; $i++) {
  if ($bools[$i] == 1) {
    $errS .= $errmessages[$i] . nl2br("\n");
  }
}

if (strlen($errS) > 0) {
  err($errS, $errS, 'signup.php');
}
$salt = "fKd93Vmz!k*dAv5029Vkf9$3Aa";
$u_id = $dao->saveUser(hash("sha256", $password . $salt), $email, $hint);
if ($u_id == 0) {
  err("signup parameter is too long", 'email or hint information is too long', 'signup.php');
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