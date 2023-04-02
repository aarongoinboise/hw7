<?php

session_start();
require_once 'Dao.php';
require_once 'saveFormTxt.php';
$_SESSION['red'] = $_POST;
$_SESSION['inputs'] = $_POST;
$dao = new Dao();
$email = $_SESSION['userEmail'];
$type = $_SESSION['mType'];

$date = $_POST['date'];
if ($date != '') {
    unset($_SESSION['red']['date']);
} else {
    err("next session date is blank", "Please make sure the date is filled out", 'homeM.php');
}

if ($type == 'tutor') {
    $nextSesh = $dao->getNextSession($dao->getTutorNumber($email));
} else {
    $nextSesh = $dao->getNextSession($dao->getTutorNumber($dao->getTutorEmailFromStudent($email)));
}

if ($nextSesh == $date) {
    $_SESSION['red']['date'] = 'set';
    err("next session date is blank", "This date is already set!", 'homeM.php');
}

$dao->saveNextSesh($date, $dao->getTutorNumber($email));
/* Final redirect after insertions */
$_SESSION['message'] = 'Success! You have edited your next session!';
header("Location: homeM.php");
exit();