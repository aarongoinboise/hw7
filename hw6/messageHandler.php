<?php

session_start();
require_once 'Dao.php';
require_once 'KLogger.php';
require_once 'saveFormTxt.php';
$logger = new KLogger("log.txt", KLogger::DEBUG);
$_SESSION['red'] = $_POST;
$_SESSION['inputs'] = $_POST;
$type = $_SESSION['mType'];
$dao = new Dao();
$email = $_SESSION['userEmail'];

$message = $_POST['message'];
if ($message != '') {
    unset($_SESSION['red']['message']);
}

$studentSent = true;
if ($type == 'tutor') {
    $studentSent = false;
    $sEmail = $_POST['sEmail'];
    if ($sEmail != '') {
        unset($_SESSION['red']['sEmail']);
    }
    if ($sEmail == '') {
        if ($message == '') {
            err("sEmail and message are blank", "Please provide a message and a student email", 'message.php');
        }
        err("sEmail is blank", "Please provide a student email", 'message.php');
    }
    if ($message == '') {
        err("message is blank", "Please provide a message", 'message.php');
    }
    /* email regex */
    $regex = "/.+@.+\..+/";
    if (preg_match($regex, $sEmail) != 1) {
        $_SESSION['red']['email'] = 'set';
        err("Email doesn't fit pattern", "Email does not exist", 'message.php');
    }
    /* Check if student belongs to tutor*/
    if ($dao->checkStudentBelongsToTutor($sEmail, $email) != 1) {
        $_SESSION['red']['email'] = 'set';
        err($email . " and " . $tEmail . " are not related", 'Student email isn\'t registered with you', 'message.php');
    }
    unset($_SESSION['red']['email']);
    $email = $sEmail;
}
/* Student */
if ($message == '') {
    err("message is blank", "Please provide a message", 'message.php');
}

date_default_timezone_set('America/Boise');
$date = date('Y-m-d');
if ($dao->saveMessage($date, $message, $studentSent, $email) != 2) {
    err("message is too long", "Please provide a shorter message", 'message.php');
}
$logger->LogDebug("was able to save message for date {$date}");
/* Final redirect after insertions */
$_SESSION['message'] = 'Success! You have sent your message!';
header("Location: message.php");
exit();