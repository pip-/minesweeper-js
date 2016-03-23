<?php
	if(!session_start()) {
		header("Location: error.php");
		exit;
	}

	// Unset all session variables
	$_SESSION = array();
	
	// Destroy the session
	session_destroy();
	
	
	// Redirect to login
	header("Location: ms.php");
	exit;
?>