<?php

session_start();
require_once 'Dao.php';
require_once 'KLogger.php';
require_once 'saveFormTxt.php';
$_SESSION['red'] = $_POST;
$_SESSION['inputs'] = $_POST;
$type = $_SESSION['mType'];
$sessionOrPrac = $_SESSION['select'];
$dao = new Dao();
$email = $_SESSION['userEmail'];