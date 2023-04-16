<?php

session_start();
require_once 'Dao.php';
require_once 'KLogger.php';
require_once 'saveFormTxt.php';
$logger = new KLogger("log.txt", KLogger::DEBUG);
$_SESSION['inputs'] = $_POST;
$type = $_SESSION['mType'];
$dao = new Dao();
$email = $_SESSION['userEmail'];

$count = count($_SESSION['inputs']);

if ($count == 0) {
    err("no radio button select practice", "Please select an answer to the question", 'practice.php');
}
$opt = $_SESSION['inputs']['opt'];
$rightAns = $dao->getPRightAnswer($email);

if ($opt == $rightAns) {
    $_SESSION['message'] = 'Success! You have selected the correct answer!';
    header("Location: practice.php");
    exit();
} else {
    err("wrong answer student wrong", "WRONG!!!, try again...", 'practice.php');
}