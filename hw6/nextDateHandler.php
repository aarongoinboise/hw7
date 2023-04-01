<?php

session_start();
require_once 'Dao.php';
require_once 'saveFormTxt.php';
$_SESSION['red'] = $_POST;
$_SESSION['inputs'] = $_POST;
$dao = new Dao();
$email = $_SESSION['userEmail'];

$date = $_POST['date'];
if ($date != '') {
    unset($_SESSION['red']['date']);
} else {
    err("next session date is blank", "Please make sure the date is filled out", 'homeM.php');
}

$dao->saveNextSesh($date, $dao->getTutorNumber($email));
/* Final redirect after insertions */
$_SESSION['message'] = 'Success! You have edited your next session!';
header("Location: homeM.php");
exit();