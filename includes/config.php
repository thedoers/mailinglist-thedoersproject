<?php 
	//----------------------------------------------------------------------------------//	
	//								COMPULSORY SETTINGS
	//----------------------------------------------------------------------------------//
	
	/*  Set the URL to your Sendy installation (without the trailing slash) */
	define('APP_PATH', 'http://mailinglist.thedoersproject.com');
	
	$url = parse_url('mysql://b27c0001ed0d6e:cb2bf771@eu-cdbr-west-01.cleardb.com/heroku_40334536524e393?reconnect=true');
	/*  MySQL database connection credentials  */
	$dbHost = $url['host']; //MySQL Hostname
	$dbUser = $url['user']; //MySQL Username
	$dbPass = $url['pass']; //MySQL Password
	$dbName = substr($url['path'], 1)); //MySQL Database Name
	
	
	//----------------------------------------------------------------------------------//	
	//								  OPTIONAL SETTINGS
	//----------------------------------------------------------------------------------//	
	
	/* 
		Change the database character set to something that supports the language you'll
		be using. Example, set this to utf16 if you use Chinese or Vietnamese characters
	*/
	$charset = 'utf8';
	
	/*  Set this if you use a non standard MySQL port.  */
	$dbPort = 3306;	
	
	/*  Domain of cookie (99.99% chance you don't need to edit this at all)  */
	define('COOKIE_DOMAIN', '');
	
	//----------------------------------------------------------------------------------//
?>