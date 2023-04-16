<?php
session_start();
require_once 'Dao.php';
$id = $_GET['id'];
$dao = new Dao();
$dao->deleteMessage($id);
$_SESSION['message'] = 'Success! You have deleted the message';
header("Location: message.php");
exit();