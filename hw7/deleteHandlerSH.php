<?php
session_start();
require_once 'Dao.php';
$id = $_GET['id'];
$dao = new Dao();
$dao->deleteSession($id);
$_SESSION['message'] = 'Success! You have deleted the session';
header("Location: sessionHistory.php");
exit();