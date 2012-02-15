<?php
$metaTitle = "Flator.se - Skapa konto";

unset( $invitationCode );
unset( $email );
/*
if ( $_POST["invitationCode"] ) $_GET["invitationCode"] = $_POST["invitationCode"];
if ( eregi( "^([0-9a-z-])+$", $_GET["invitationCode"] ) )
{
	$q = "SELECT userId, recruitedBy, email, invitationCode FROM fl_invitations WHERE invitationCode = '" . addslashes( $_GET["invitationCode"] ) . "' AND used = 'NO' LIMIT 0,1";
	$row = $DB->GetRow( $q, FALSE, TRUE );
	if ( count( $row ) > 0 )
	{
		// If userId is empty it's a new user
		$userId = $row["userId"];
		// If recuitedBy is not empty it's a new user
		$recruitedBy = $row["recruitedBy"];
		$email = $row["email"];
		$invitationCode = $_GET["invitationCode"];
	}
}
*/

if ( $_POST )
{
	unset( $message );
	unset( $thankyou );

	#if ( (int)$userId < 1 && (int)$recruitedBy < 1 ) $message.= "<li><b>Inbjudningskoden</b> du angett &auml;r felaktig.</li>";
	if ( !eregi( "^([_a-z0-9-])+$", $_POST["username"] ) || strlen( $_POST["username"] ) > 16 )
	{
		$message.= "<li><b>Anv&auml;ndarnamnet</b> f&aring;r endast inneh&aring;lla bokst&auml;ver, siffror, _ och -. Dessutom f&aring;r anv&auml;ndarnamnet inte vara l&auml;ngre &auml;n 16 tecken.</li>";
	}
	else
	{
		$q = "SELECT * FROM fl_users WHERE username = '" . addslashes( $_POST["username"] ) . "' AND id != " . (int)$userId;
		$rowUser = $DB->GetRow( $q, FALSE, TRUE );
		if ( count( $rowUser ) > 0 )
		{
			$message.= "<li><b>Anv&auml;ndarnamnet</b> &auml;r upptaget.</li>";
		}
	}
	
	if ( strlen( $_POST["password"] ) < 1 ) $message.= "<li>Du m&aring;ste ange ett <b>l&ouml;senord</b>.</li>";
	if ( $_POST["password"] != $_POST["confirmPassword"] ) $message.= "<li><b>L&ouml;senorden</b> matchar inte varandra.</li>";
	if ( strlen( trim($_POST["firstName"]) ) < 2 ) $message.= "<li>Du m&aring;ste ange ett <b>f&ouml;rnamn</b>.</li>";
	if ( strlen( trim($_POST["lastName"]) ) < 2 ) $message.= "<li>Du m&aring;ste ange ett <b>efternamn</b>.</li>";
	if ( !eregi( "^[_a-z0-9-]+(.*)@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST["email"] ) ) $message.= "<li>Du har angett en ogiltig <b>e-postadress</b>.</li>";

	$pnr = $_POST["personalCodeNumber"];
	$pnr = str_replace( "-", "", $pnr );
	$pnr = str_replace( "+", "", $pnr );
	if ( (int)$_POST["personalCodeNumber"] < 1 )
	{
		 $message.= "<li>Du har angett ett felaktigt <b>personnummer</b>.</li>";
	}
	else
	{
		if ( eregi( "^(20|19)", $pnr ) && strlen( $pnr ) == 12 )
		{
			$pnr = eregi_replace( "^(20|19)", "", $pnr );
		}

		if ( strlen( $pnr ) != 10 )
		{
			$message.= "<li>Du har angett ett felaktigt <b>personnummer</b>.</li>";
		}
		else
		{
			if ( !checkPnr( $pnr ) ) 
			{
				$message.= "<li>Du har angett ett felaktigt <b>personnummer</b>.</li>";
			}
			else
			{
				// Is it a boy or a girl?
				if ( ( substr( $pnr, 8, 1 ) %2 ) == 1 )
				{
					$message.= "<li>Du har angett ett felaktigt <b>personnummer</b>.</li>";
				}
			}
		}
	}

		$q = "SELECT * FROM fl_users WHERE personalCodeNumber = '" . addslashes( $pnr ) . "' AND id != " . (int)$userId;
		$rowUser = $DB->GetRow( $q, FALSE, TRUE );
		if ( count( $rowUser ) > 0 )
		{
			$message.= "<li><b>Personen</b> med detta personnummer &auml;r redan medlem. <a href=\"" . $baseUrl . "/reset_password.html\">Glömt ditt lösenord?</a></li>";
		}

	/*
	if( $_SESSION["security_code"] == $_POST["verification"] && !empty($_SESSION["security_code"] ) ) {
		unset($_SESSION["security_code"]);
	}
	else
	{
		$message.= "<li>Du angav en felaktig <b>s&auml;kerhetskod</b>.</li>";
	}
*/
	// All information entered correctly and CAPTCHA-code correct, create/update user.
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
		$record["username"] = $_POST["username"];
		$record["password"] = sha1( $_POST["password"] );
		$record["firstName"] = $_POST["firstName"];
		$record["lastName"] = $_POST["lastName"];
		$record["email"] = $_POST["email"];
		$record["personalCodeNumber"] = $pnr;
		#$record["recruitedBy"] = $recruitedBy;
		$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];

		$tmpCode = randCode( 15 );
		$inviteValidation = randCode( 10 );
		$verificationCode = substr( $tmpCode, 0, 5 ) . "-" . substr( $tmpCode, 4, 5 ) . "-" . substr( $tmpCode, 9, 5 );
		$record["verificationCode"] = $verificationCode;
		$record["inviteValidation"] = $inviteValidation;

		#if ( $_POST["email"] == $email )
		#{
		#	$record["rights"] = 3; // The invitation e-mail was sent to this address so there is no need to confirm the adress.
		#	$thankyou = "<li>Du &auml;r <b>nu</b> en registrerad medlem p&aring; Flator.se! <a href=\"http://www.flator.se/\">Klicka h&auml;r</a> f&ouml;r att komma till hemsidan och logga in.</li>";
		#}
		#else
		#{
			$record["rights"] = 2; // Member needs to confirm e-mailaddress.
			$thankyou = "<li>Du &auml;r <b>nu</b> en registrerad medlem p&aring; Flator.se! <a href=\"" . $baseUrl . "/\">Klicka h&auml;r</a> f&ouml;r att komma till hemsidan och logga in.<br></li>";
			$thankyou.= "<li>Ett mail har skickats till din e-postadress d&auml;r du ombeds <b>bekr&auml;fta adressen</b>. Innan du gjort detta kommer andra medlemmar inte att kunna se din profil och du kommer inte kunna skicka meddelanden.</li>";
		#}
		#if ( $userId > 0 )
		#{
		#	$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . (int)$userId ); 
		
		#}
		#else
		#{
			$record["insDate"] = date( "Y-m-d H:i:s" );
			$inserted = $DB->AutoExecute( "fl_users", $record, 'INSERT' );
			if ($inserted == FALSE) {
			$thankyou = "Ett fel har uppstått".$DB->ErrorMsg();
			} else {
			$userId = $DB->Insert_ID();

			$gbMsgArr = array();
			$gbMsgArr["insDate"] = date( "Y-m-d H:i:s" );
			$gbMsgArr["userId"] = 5;
			$gbMsgArr["recipentUserId"] = $userId;
			$gbMsgArr["message"] = "Välkommen till Flator.se - hoppas att du kommer att trivas här. Har du några frågor eller önskemål, skriv på min vägg! /Agneta";
			$gbMsgArr["deleted"] = "NO";
			$gbMsgArr["readByOwner"] = "NO";
			$DB->AutoExecute( "fl_guestbook", $gbMsgArr, 'INSERT' );
			}
		#}

		#if ( $_POST["email"] != $email )
		#{
			$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["confirmEmail"];
			$row = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $row ) > 0 )
			{
				$message = $row["content"];
				$subject = $row["subject"];
				if ( strlen( $subject ) < 1 )
				{
					$subject = "Flator.se - Bekräfta e-postadress";
				}
				$tmpMessage = $message;
				$tmpMessage = str_replace( "{verificationCode}", $verificationCode, $tmpMessage );
				// Send email
				sendMail( $_POST["email"], "info@flator.se", "Flator.se Crew", $subject, $tmpMessage );

				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["emailType"] = "confirmEmail";
				$record["recipientUserId"] = (int)$userId;
				$record["email"] = addslashes( $_POST["email"] );
				$record["message"] = $tmpMessage;
				$DB->AutoExecute("fl_email_log", $record, 'INSERT');
			}
		#}

		$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["welcomeEmail"];
		$row = $DB->GetRow( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			$message = $row["content"];
			$subject = $row["subject"];
			if ( strlen( $subject ) < 1 )
			{
				$subject = "Flator.se - Välkommen!";
			}
			$tmpMessage = $message;
			$tmpMessage = str_replace( "{userid}", $userId, $tmpMessage );
			$tmpMessage = str_replace( "{inviteValidation}", $inviteValidation, $tmpMessage );
			$tmpMessage = str_replace( "{username}", $_POST["username"], $tmpMessage );
			$tmpMessage = str_replace( "{password}", $_POST["password"], $tmpMessage );
			// Send email
			sendMail( $_POST["email"], "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

			$record = array();
			$record["insDate"] = date( "Y-m-d H:i:s" );
			$record["emailType"] = "welcomeEmail";
			$record["recipientUserId"] = (int)$userId;
			$record["email"] = addslashes( $_POST["email"] );
			$record["message"] = $tmpMessage;
			$DB->AutoExecute("fl_email_log", $record, 'INSERT');
		}
	}

	$invitationCode = $_POST["invitationCode"];
	$email = $_POST["email"];
}

$body = "<div id=\"center\">\n";

if ( strlen( $thankyou ) > 0 )
{
	#unset($record);
	#$record["used"] = "YES";
	#$DB->AutoExecute( "fl_invitations", $record, 'UPDATE', 'invitationCode = \''.addslashes($invitationCode).'\''); 	
	$body.= "<h2>V&auml;lkommen!</h2><div id=\"thankyou\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $thankyou . "</ul></div>
	<script type=\"text/javascript\">
	_gaq.push(['_trackPageview', \"/register/done\"]);
	</script>";
}
else
{
	$body.= "<h2>Skapa konto</h2>

<p style=\"margin-bottom: 20px;\">N&auml;r du skapat kontot kan du logga in direkt. Observera att Flator.se endast är öppen för tjejer/kvinnor.<br><br>
Ditt förnamn och efternamn kommer inte att vara synligt för andra medlemmar, men vi kontrollerar personnumret mot namnet för att säkerställa att du är den du utger dig för att vara.</p>";

#$body .= "<p style=\"margin-bottom: 40px; font-weight: bold; color: rgb(199,70,61);\">En inbjudningskod kan endast anv&auml;ndas en g&aring;ng!</p>";

	if ( strlen( $message ) > 0 )
	{
		$body.= "<div id=\"error\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $message . "</ul></div>";
	}

	$body.= "<form method=\"post\" style=\"padding: 0px; margin: 0px\">";

#$body .= "<p style=\"margin-bottom: 35px;\"><label for=\"invitationCode\">Inbjudningskod:</label> <input type=\"text\" id=\"invitationCode\" name=\"invitationCode\" value=\"" . $invitationCode . "\" /> (17 tecken)</p>";

$body .= "<p><label for=\"username\">Anv&auml;ndarnamn:</label> <input type=\"text\" id=\"username\" name=\"username\" value=\"" . $_POST["username"] . "\" /></p>
<p><label for=\"password\">L&ouml;senord:</label> <input type=\"password\" id=\"password\" name=\"password\" value=\"" . $_POST["password"] . "\" /></p>
<p style=\"margin-bottom: 35px;\"><label for=\"confirmPassword\">Bekr&auml;fta l&ouml;senord:</label> <input type=\"password\" id=\"confirmPassword\" name=\"confirmPassword\" value=\"" . $_POST["confirmPassword"] . "\" /></p>
<p><label for=\"firstName\">F&ouml;rnamn:</label> <input type=\"text\" id=\"firstName\" name=\"firstName\" value=\"" . $_POST["firstName"] . "\" /></p>
<p><label for=\"lastName\">Efternamn:</label> <input type=\"text\" id=\"lastName\" name=\"lastName\" value=\"" . $_POST["lastName"] . "\" /></p>
<p style=\"margin-bottom: 35px;\"><label for=\"email\">E-post:</label> <input type=\"text\" id=\"email\" name=\"email\" value=\"" . $email . "\" /></p>
<p style=\"margin-bottom: 35px;\">F&ouml;r att bekr&auml;fta att du &auml;r tjej beh&ouml;ver vi ditt fullständiga personnummer. Det används endast vid registreringen och syns inte för andra medlemmar, i din presentation visas bara din födelsedag.<br><br><label for=\"personalCodeNumber\">Personnummer:</label> <input type=\"text\" id=\"personalCodeNumber\" name=\"personalCodeNumber\" value=\"" . $_POST["personalCodeNumber"] . "\" /> </p>

<img align=\"absmiddle\" src=\"captcha.jpg?width=100&height=40&characters=5\" border=\"0\" id=\"verImage\" class=\"verification\" />
<p class=\"verification\"><a href=\"#noexist\" onClick=\"refreshimage('verImage');\" style=\"font-size: 9px\">Ladda om bilden</a></p>
<p class=\"verification\">Ange koden i f&auml;ltet nedan.</p>
<p><label for=\"verification\">S&auml;kerhetskod:</label> <input type=\"text\" id=\"verification\" name=\"verification\" /></p>

<p style=\"margin-top: 30px;\">Genom att registrera dig på Flator.se godkänner du våra <strong><a href=\"" . $baseUrl . "/member_terms.html\" target=\"_blank\">medlemsvillkor</a></strong>.<br>
Kontrollera uppgifterna du angivit, falska eller felaktiga uppgifter leder till avstängning.</p>
<p class=\"submit\"><input type=\"submit\" value=\"Skapa konto\" /></p>

</form>

	";
}

$body.= "</div>\n";
?>