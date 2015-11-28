<?php
session_start();
require_once('config.php');

//include $BASEDIR . 'header/header.php';

session_unset();
session_destroy(); //end the session
header("Location: login.php");
?>



