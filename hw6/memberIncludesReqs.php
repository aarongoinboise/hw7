<?php
session_start();
include("titlefab.php");
include("h1s.php");
require_once("saveFormTxt.php");
require_once 'KLogger.php';
$logger = new KLogger("log.txt", KLogger::DEBUG);