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

$studentSent = 1;
if ($type == 'tutor') {
    $studentSent = 0;
    $sEmail = $_POST['sEmail'];
    $_SESSION['emailS'] = $sEmail;
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
        $regex = "/.+@.+\..+/";
        if (preg_match($regex, $sEmail) != 1) {
            $_SESSION['red']['sEmail'] = 'set';
            err("message is blank", "Email does not exist" . nl2br("\n") . "Please provide a message", 'message.php');
        }
        err("message is blank", "Please provide a message", 'message.php');
    }

    /* Check if student belongs to tutor*/
    if ($dao->checkStudentBelongsToTutor($sEmail, $email) != 1) {
        $_SESSION['red']['sEmail'] = 'set';
        $regex = "/.+@.+\..+/";
        if (preg_match($regex, $sEmail) != 1) {
            err("message is blank", "Email does not exist" . nl2br("\n") . "Student email isn't registered with you", 'message.php');
        }
        err($email . " and " . $tEmail . " are not related", 'Student email isn\'t registered with you', 'message.php');
    }
    unset($_SESSION['red']['email']);
    $email = $sEmail;
}
/* Student messages */
if ($message == '') {
    err("message is blank", "Please provide a message", 'message.php');
}

if ($dao->saveMessage($message, $studentSent, $email) != 2) {
    err("message is too long", "Please provide a shorter message", 'message.php');
}

/* Final redirect after insertions */
$_SESSION['message'] = 'Success! You have sent your message!';
header("Location: message.php");
exit();