<?php
if ( strlen( $_POST["username"] ) > 0 && strlen( $_POST["password"] ) > 0 )
{
	$tmpPass = sha1( $_POST["password"] );

	$q = "SELECT * FROM fl_users WHERE username = '" . addslashes( $_POST["username"] ) . "' AND password = '" . $tmpPass . "' AND rights > 1";
	$row = $DB->GetRow( $q, FALSE, TRUE );
	if ( count( $row ) > 0 )
	{
		$record["reminded"] = "NO";
		$record["lastLogin"] = date( "Y-m-d H:i:s" );
		
		$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . $row["id"] ); 

		$record = array();
		$record["insDate"] = date("Y-m-d H:i:s");
		$record["userId"] = $row["id"];
		$record["username"] = addslashes( $_POST["username"] );
		$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];
		$record["success"] = "YES";
		$DB->AutoExecute("fl_login_log", $record, 'INSERT');

		if ( $row["visible"] == "YES" )
		{
			$record = array();
			$record["insDate"] = date("Y-m-d H:i:s");
			$record["userId"] = $row["id"];
			$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];
			$DB->AutoExecute("fl_public_login_log", $record, 'INSERT');
		}

		$_SESSION["rights"] = $row["rights"];
		$_SESSION["userId"] = $row["id"];
		if ( strlen( $loginUrl ) > 0 )
		{
			header( "Location: " . $loginUrl );
		}
	}
	else
	{
		$record = array();
		$record["insDate"] = date("Y-m-d H:i:s");
		$record["username"] = addslashes( $_POST["username"] );
		$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];
		$record["success"] = "NO";
		$DB->AutoExecute("fl_login_log", $record, 'INSERT');

		$message = "Ogiltigt användarnamn och/eller lösenord.";
	}

}
elseif ( $_POST )
{
	$message = "Du måste ange både användarnamn och lösenord.";
}

if ( (int)$_SESSION["rights"] > 1 )
{

}
else
{

	// Log in
	$loginForm = TRUE;
	include( "_newstart.php" );
/*
	$body = "<div id=\"center\">\n";
	$body.= "<h2>Logga in</h2>";

	if ( strlen( $message ) > 0 )
	{
		$body.= "<div id=\"error\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $message . "</ul></div>";
	}

	$body.= "
<form method=\"post\" style=\"padding: 0px; margin: 0px\">

<p><label for=\"username\">Användarnamn:</label> <input type=\"text\" id=\"username\" name=\"username\" /></p>
<p><label for=\"password\">Lösenord:</label> <input type=\"password\" id=\"password\" name=\"password\" /></p>
<p class=\"submit\"><input type=\"submit\" value=\"Logga in\" /></p>

</form>
Glömt ditt lösenord? <a href=\"" . $baseUrl . "/reset_password.html\">Begär lösenord</a>

<br /><br />

<h3>Skaffa konto!</h3>
<p>Har du f&aring;tt en inbjudan med inbjudningskod?<br /><a href=\"" . $baseUrl . "/register.html\">Skapa konto h&auml;r!</a></p>


";
	$body.= "</div>\n";*/
}




?>