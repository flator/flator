<?php
if ( strlen( $_POST["username"] ) > 0 && strlen( $_POST["password"] ) > 0 )
{
	$tmpPass = sha1( $_POST["password"] );

	$q = "SELECT * FROM fl_users WHERE username = '" . addslashes( $_POST["username"] ) . "' AND password = '" . $tmpPass . "' AND rights > 1";
	$row = $DB->GetRow( $q, FALSE, TRUE );
	if ( count( $row ) > 0 )
	{
		$record["lastLogin"] = date( "Y-m-d H:i:s" );
		$record["reminded"] = "NO";
		$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . $row["id"] ); 

		$record = array();
		$record["insDate"] = date("Y-m-d H:i:s");
		$record["userId"] = $row["id"];
		$record["username"] = addslashes( $_POST["username"] );
		$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];
		$record["success"] = "YES";
		$DB->AutoExecute("fl_login_log", $record, 'INSERT');

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
	$body = "
<form method=\"post\" style=\"padding: 0px; margin: 0px\">

<p><label for=\"username\">Användarnamn:</label> <input type=\"text\" id=\"username\" name=\"username\" /></p>
<p><label for=\"password\">Lösenord:</label> <input type=\"password\" id=\"password\" name=\"password\" /></p>
<p class=\"submit\"><input type=\"submit\" value=\"Logga in\" /></p>

</form>
";

if ( strlen( $message ) > 0 ) $body.= "<div id=\"error\">" . $message . "</div>\n";
}
?>