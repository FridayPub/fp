<?php
    /* Do we need this here */
    session_start();

    //The following lines are cargo cult programming taken from an example
    //on php.net. Seems to work though.
	// Unset all of the session variables.
	$_SESSION = array();

	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!
	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]
	    );
	}
    session_destroy() or die("Failed to destroy session.");
    header("location: ../index.html");
?> 
