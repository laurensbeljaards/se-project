<?php
	//Error reporting is off on LIACS servers by default. Show some additional errors:
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	//----
	
	//Database properties:
	$server = 'mysql.liacs.leidenuniv.nl';
	$usernamedb = 's1525670'; 
	$passworddb = 'PLACEHOLDER'; 
	
	if ($passworddb == 'PLACEHOLDER') {
		echo "You forgot to change the database password, you moron!!<br /><br />";
	}
	
	$database = 's1525670';
	//----
	
	//TEMP User data:
	if (!isset($_COOKIE["studentid"])) {
		$studentid = 1234567;
	} else {
		$studentid = $_COOKIE["studentid"];
	}
	//----
	
	//URL Bases:
	//Examples of how to use these directory paths:
	//$BASEDIR = '/home/s1532960/public_html/SE/Sprint3/';
	//$RELPATH = 'http://liacs.leidenuniv.nl/~s1532960/SE/Sprint3/';
	$BASEDIR = 'PLACEHOLDER';
	$RELPATH = 'PLACEHOLDER';
	
	if ($BASEDIR == 'PLACEHOLDER' || $RELPATH == 'PLACEHOLDER') {
		echo "You forgot to change the BASEDIR and/or RELPATH, you moron!!<br /><br />";
	}
	//----
	
	//Inlogsysteem
	session_start();
	if(isset($_SESSION['loggedInStudent'])){
		$loggedInStudent = $_SESSION['loggedInStudent'];
		$username = $_SESSION['username'];
		$loggedInTeacher = $_SESSION['loggedInTeacher'];
	} else if(isset($_SESSION['loggedInTeacher'])){
		$loggedInTeacher = $_SESSION['loggedInTeacher'];
		$username = $_SESSION['username'];
		$loggedInStudent = $_SESSION['loggedInStudent'];
	} else {
		$loggedInTeacher = 0;
		$loggedInStudent = 0;
	}
	//----
?>