<?php
$metaTitle = "Flator.se - Nytt l&ouml;senord";

$q = "SELECT * FROM fl_users WHERE verificationCode = '" . addslashes( $_GET["verificationCode"] ) . "' AND id = " . (int)$_GET["userId"];
$row = $DB->GetRow( $q, FALSE, TRUE );
if ( count( $row ) > 0 )
{
	$userId = $row["id"];
	$username = $row["username"];
	$email = $row["email"];
}
else
{
	$body = "<div id=\"center\"><div id=\"error\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">Felaktig kod.</ul></div></div>\n";
}

if ( $_POST && strlen( $username ) > 0  && $_SESSION["demo"] != TRUE )
{

	unset( $message );
	unset( $thankyou );

	if ( strlen( $_POST["password"] ) < 1 ) $message.= "<li>Du m&aring;ste ange ett <b>l&ouml;senord</b>.</li>";

	if( $_SESSION["security_code"] == $_POST["verification"] && !empty($_SESSION["security_code"] ) ) {
		unset($_SESSION["security_code"]);
	}
	else
	{
		$message.= "<li>Du angav en felaktig <b>s&auml;kerhetskod</b>.</li>";
	}

	// All information entered correctly and CAPTCHA-code correct, send e-mail with instructions.
	if ( strlen( $message ) < 1 )
	{
		$configuration = array();
		$q = "SELECT * FROM fl_configuration";
		$row = $DB->GetAssoc( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			while ( list( $key, $value ) = each( $row ) )
			{
				$configuration[ $row[ $key ]["type"] ] = $row[ $key ]["value"];
			}
		}

		$record = array();
		$record["password"] = sha1( $_POST["password"] );
		$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . (int)$userId ); 

		$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["newPassword"];
		$rowTemplate = $DB->GetRow( $q, FALSE, TRUE );
		if ( count( $rowTemplate ) > 0 )
		{
			$message = $rowTemplate["content"];
			$subject = $rowTemplate["subject"];
			if ( strlen( $subject ) < 1 )
			{
				$subject = "Flator.se - Nytt lösenord";
			}
			$tmpMessage = $message;
			$tmpMessage = str_replace( "{username}", $username, $tmpMessage );
			$tmpMessage = str_replace( "{password}", $_POST["password"], $tmpMessage );
			// Send email
			sendMail( addslashes( $email ), "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

			$record = array();
			$record["insDate"] = date( "Y-m-d H:i:s" );
			$record["emailType"] = "newPassword";
			$record["recipientUserId"] = (int)$userId;
			$record["email"] = addslashes( $email );
			$record["message"] = $tmpMessage;
			$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];
			$DB->AutoExecute("fl_email_log", $record, 'INSERT');
		}
		$thankyou = "<li>Vi har skickat ett mail till din e-postadress med ditt anv&auml;ndarnamn och l&ouml;senord.</li>\n";
	}
}

if ( strlen( $username ) > 0 )
{
	$body = "<div id=\"center\">\n";

	if ( strlen( $thankyou ) > 0 )
	{
		$body.= "<h2>L&ouml;senord sparat</h2><div id=\"thankyou\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $thankyou . "</ul></div>";
	}
	else
	{
		$body.= "<h2>Nytt l&ouml;senord</h2>";

		$body.= "<p>Om det &auml;r s&aring; att du gl&ouml;mt l&ouml;senordet f&ouml;r kontot med anv&auml;ndarnamn <b>" . $username . "</b> kan du h&auml;r ange ett nytt l&ouml;senord.</p>";

		if ( strlen( $message ) > 0 )
		{
			$body.= "<div id=\"error\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $message . "</ul></div>";
		}

		$body.= "<form method=\"post\" style=\"padding: 0px; margin: 0px\">

<p style=\"margin-bottom: 35px;\"><label for=\"password\">L&ouml;senord:</label> <input type=\"password\" id=\"password\" name=\"password\" value=\"" . $_POST["password"] . "\" /></p>

<img align=\"absmiddle\" src=\"captcha.jpg?width=100&height=40&characters=5\" border=\"0\" id=\"verImage\" class=\"verification\" />
<p class=\"verification\"><a href=\"#noexist\" onClick=\"refreshimage('verImage');\" style=\"font-size: 9px\">Ladda om bilden</a></p>
<p class=\"verification\">Ange koden i f&auml;ltet nedan.</p>
<p><label for=\"verification\">S&auml;kerhetskod:</label> <input type=\"text\" id=\"verification\" name=\"verification\" /></p>

<p class=\"submit\"><input type=\"submit\" value=\"Spara nytt l&ouml;senord\" /></p>

</form>

		";
	}

	$body.= "</div>\n";
}
?>
