<?php
$metaTitle = "Flator.se - Beg&auml;r l&ouml;senord";

if ( $_POST  && $_SESSION["demo"] != TRUE )
{
	unset( $message );
	unset( $thankyou );

	if ( !eregi( "^[_a-z0-9-]+(.*)@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST["email"] ) ) $message.= "<li>Du har angett en ogiltig <b>e-postadress</b>.</li>";

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

		// Get account or accounts for the e-mail
		$q = "SELECT * FROM fl_users WHERE email = '" . addslashes( $_POST["email"] ) . "' AND rights > 1";
		$row = $DB->GetAssoc( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
#echo "<pre>";
#print_r( $row );
#echo "</pre>";
			while ( list( $key, $value ) = each( $row ) )
			{
				$verificationCode = $row[ $key ]["verificationCode"];
				$username = $row[ $key ]["username"];
				$userId = $row[ $key ]["id"];

				if ( strlen( $verificationCode ) < 1 )
				{
					$tmpCode = randCode( 15 );
					$verificationCode = substr( $tmpCode, 0, 5 ) . "-" . substr( $tmpCode, 4, 5 ) . "-" . substr( $tmpCode, 9, 5 );
					$record = array();
					$record["verificationCode"] = $verificationCode;	
					$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . (int)$userId ); 
				}

				$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["resetPassword"];
				$rowTemplate = $DB->GetRow( $q, FALSE, TRUE );
				if ( count( $rowTemplate ) > 0 )
				{
					$message = $rowTemplate["content"];
					$subject = $rowTemplate["subject"];
					if ( strlen( $subject ) < 1 )
					{
						$subject = "Flator.se - Skapa nytt lösenord";
					}
					$tmpMessage = $message;
					$tmpMessage = str_replace( "{username}", $username, $tmpMessage );
					$tmpMessage = str_replace( "{resetPwdURL}", $baseUrl . "/new_password.html?userId=" . $userId . "&verificationCode=" . $verificationCode, $tmpMessage );
					// Send email
#echo "sent mail";
					sendMail( addslashes( $_POST["email"] ), "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

					$record = array();
					$record["insDate"] = date( "Y-m-d H:i:s" );
					$record["emailType"] = "resetPassword";
					$record["recipientUserId"] = (int)$userId;
					$record["email"] = addslashes( $_POST["email"] );
					$record["message"] = $tmpMessage;
					$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];
					$DB->AutoExecute("fl_email_log", $record, 'INSERT');
				}
			}
			$thankyou = "<li>Vi har skickat ett mail till din e-postadress med instruktioner om hur du skapar ett nytt l&ouml;senord f&ouml;r ditt konto.</li><li>Om det är så att du har fler konton kopplade till denna e-postadress kommer du få ett mail per konto.</li>\n";
		}
		else
		{
			$message = "<li>Vi hittade inga konton kopplade till denna e-postadress :(</li>";		
		}
	}
}

$body = "<div id=\"center\">\n";

if ( strlen( $thankyou ) > 0 )
{
	$body.= "<h2>Beg&auml;ran om nytt l&ouml;senord skickat</h2><div id=\"thankyou\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $thankyou . "</ul></div>";
}
else
{
	$body.= "<h2>Beg&auml;r l&ouml;senord</h2>";

	$body.= "<p>Om du gl&ouml;mt av dina inloggnigsuppgifter fyller du i din e-postadress nedan s&aring; skickar vi instruktioner om hur du f&aring;r dom p&aring; nytt.</p>";

	if ( strlen( $message ) > 0 )
	{
		$body.= "<div id=\"error\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $message . "</ul></div>";
	}

	$body.= "<form method=\"post\" style=\"padding: 0px; margin: 0px\">

<p style=\"margin-bottom: 35px;\"><label for=\"email\">E-post:</label> <input type=\"text\" id=\"email\" name=\"email\" value=\"" . $_POST["email"] . "\" /></p>

<img align=\"absmiddle\" src=\"captcha.jpg?width=100&height=40&characters=5\" border=\"0\" id=\"verImage\" class=\"verification\" />
<p class=\"verification\"><a href=\"#noexist\" onClick=\"refreshimage('verImage');\" style=\"font-size: 9px\">Ladda om bilden</a></p>
<p class=\"verification\">Ange koden i f&auml;ltet nedan.</p>
<p><label for=\"verification\">S&auml;kerhetskod:</label> <input type=\"text\" id=\"verification\" name=\"verification\" /></p>

<p class=\"submit\"><input type=\"submit\" value=\"Beg&auml;r l&ouml;senord\" /></p>

</form>

	";
}
$body.= "</div>\n";
?>
