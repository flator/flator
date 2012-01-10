<?php
$metaTitle = "Flator.se - Bjud in flator";


if ( $_GET["inviteValidation"] != "" &&  (int)$_GET["userid"] > 0)
{
	$q = "SELECT * FROM fl_users WHERE inviteValidation = '" . addslashes( $_GET["inviteValidation"] ) . "' AND id = '" . (int)$_GET["userid"] . "' LIMIT 1";
	$row = $DB->GetRow( $q, FALSE, TRUE );
	if ( count( $row ) > 0 )
	{
		// If userId is empty it's a new user
		$userId = $row["id"];
		
		$invitesLeft = $row["invitesLeft"];
	} else {
	echo "<h2>Ogiltig inbjudningskod</h2>";
	exit;
	}
} else {
	echo "<h2>Ogiltig inbjudningskod</h2>";
	exit;
}

if ( $_POST  && $_SESSION["demo"] != TRUE )
{
	unset( $message );
	
	// All information entered correctly and CAPTCHA-code correct, create/update user.
	if ( strlen( $message ) < 1 )
	{
	$i2 = 0;
	$i = 1;
	$used = 0;
	while ( $i2 < $invitesLeft) {
	
	if (( $_POST["inviteMail".$i] != "") && ( eregi( "^[_a-z0-9-]+(.*)@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST["inviteMail".$i] ) )) {


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
		$record["userId"] = 0;
		
		$tmpCode = randCode( 15 );
		$verificationCode = substr( $tmpCode, 0, 5 ) . "-" . substr( $tmpCode, 4, 5 ) . "-" . substr( $tmpCode, 9, 5 );
		
		$record["insDate"] = date("Y-m-d H:i:s");
		$record["invitationCode"] = $verificationCode;
		$record["used"] = "NO";
		$record["email"] = $_POST["inviteMail".$i];
		$record["recruitedBy"] = $_GET["userid"];
		
		$DB->AutoExecute( "fl_invitations", $record, 'INSERT' ); 			
		$userId = $DB->Insert_ID();
		unset($record);

			$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["newInvitedFriend"];
			$row = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $row ) > 0 )
			{
				$message = $row["content"];
				$subject = $row["subject"];
				if ( strlen( $subject ) < 1 )
				{
					$subject = "Flator.se - Inbjuden av en vän";
				}
				$tmpMessage = $message;
				$tmpMessage = str_replace( "{invitationCode}", $verificationCode, $tmpMessage );
				// Send email
				sendMail( $_POST["inviteMail".$i], "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["emailType"] = "invitation";
				$record["recipientUserId"] = 0;
				$record["email"] = addslashes( $_POST["inviteMail".$i] );
				$record["message"] = $tmpMessage;
				$DB->AutoExecute("fl_email_log", $record, 'INSERT');
			}



$used++;
}
$i2++;
	$i++;

	}
}
}
		unset($record);
		$invitesLeft = $invitesLeft - $used;
	
		$record["invitesLeft"] = $invitesLeft;
		
		$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = '.(int)$_GET["userid"] ); 
$body = "<div id=\"center\">\n";
if ($used > 0) {
	$body.= "<h2>Bjud in flator</h2><div id=\"thankyou\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">$used inbjudningar har skickats iväg! Du har nu $invitesLeft kvar.</ul></div>";
} else {
	$body.= "<h2>Bjud in flator</h2>";
}

if ($invitesLeft > 0) {
	$body.= "
<p>Nu när du har registrerat dig som medlem på Flator.se har du fått 5 inbjudningar som du kan skicka iväg till andra flator.</p>

<p style=\"margin-bottom: 40px; font-weight: bold; color: rgb(199,70,61);\">Du har ".$invitesLeft." inbjudningar kvar!</p>";


	$body.= "<form method=\"post\" style=\"padding: 0px; margin: 0px\">";

$i2 = 0;
$i = 1;
while ( $i2 < $invitesLeft) {
$body .= "<p><label for=\"inviteMail".$i."\">E-post till flata ".$i.":</label> <input type=\"text\" id=\"inviteMail".$i."\" name=\"inviteMail".$i."\" value=\"\" /></p>";
$i2++;
$i++;
}
$body .= "

<p class=\"submit\"><input type=\"submit\" value=\"Bjud in flator!\" /></p>

</form>

	";
}

$body.= "</div>\n";
?>