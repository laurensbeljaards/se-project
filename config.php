<?php
	//Error reporting is off on LIACS servers by default. Show some additional errors:
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	//----
	
	//Database properties:
	$server = 'mysql.liacs.leidenuniv.nl';
	$username = 's1525670'; 
	$password = 'PLACEHOLDER'; 
	
	if ($password == 'PLACEHOLDER') {
		echo "You forgot to change the database password, you moron!!";
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
	$BASEDIR = '/home/s1514997/public_html/se/sprint2/';
	$RELPATH = 'http://liacs.leidenuniv.nl/~s1514997/se/sprint2/';
	//----
?>