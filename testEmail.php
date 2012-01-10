<?php
exit;
include('adodb5/adodb.inc.php');
include('functions.php');
$DB = NewADOConnection('mysql');
if ( DEBUG_MODE == TRUE )
{
	#$DB->debug = TRUE;
}
$DB->Connect("localhost", "root", "sx53gmQ9", "flator");
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


#$q = "SELECT * FROM fl_users WHERE rights = 2 AND insDate < '2011-10-28 00:00:00' AND insDate > '2009-03-11 16:54:16' ORDER BY insDate ASC";
#$q = "SELECT * FROM fl_users WHERE lastLogin < '2011-07-03 00:00:00' AND rights > 1 ORDER BY lastLogin DESC";

$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
while ( list( $key, $value ) = each( $searchResult ) )
		{

				$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["weMissYou"];
				$row = $DB->GetRow( $q, FALSE, TRUE );
				if ( count( $row ) > 0 )
				{
					$message = $row["content"];
					$subject = $row["subject"];
					if ( strlen( $subject ) < 1 )
					{
						$subject = "Snygging, vi saknar dig!";
					}
					$tmpMessage = $message;
					$tmpMessage = str_replace( "{username}", $searchResult[ $key ]["username"], $tmpMessage );
					$tmpMessage = str_replace( "{missingTime}", "alldeles för lång tid", $tmpMessage );
					$tmpMessage = str_replace( "{extraText}", "Du har väl inte missat att det blåser nya vindar på sajten? Vi har massor av spännande saker på gång, läs gärna mer om det inne på forumet!", $tmpMessage );
					// Send email
					sendMail( $searchResult[ $key ]["email"], "crew@flator.se", "Flator.se Crew", $subject, $tmpMessage );

					$record = array();
					$record["insDate"] = date( "Y-m-d H:i:s" );
					$record["emailType"] = "email";
					$record["recipientUserId"] = $searchResult[ $key ]["id"];
					$record["email"] = $searchResult[ $key ]["email"];
					$record["message"] = $tmpMessage;
					$DB->AutoExecute("fl_email_log", $record, 'INSERT');
					
					#$record = array();
					#$record["reminded"] = "YES";
					#$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . $searchResult[ $key ]["id"] );

				}

/*
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
						$tmpMessage = str_replace( "{verificationCode}", $searchResult[ $key ]["verificationCode"], $tmpMessage );
						// Send email
						sendMail( $searchResult[ $key ]["email"], "info@flator.se", "Flator.se Crew", $subject, $tmpMessage );

						$record = array();
						$record["insDate"] = date( "Y-m-d H:i:s" );
						$record["emailType"] = "confirmEmail";
						$record["recipientUserId"] = $searchResult[ $key ]["id"];
						$record["email"] = addslashes( $searchResult[ $key ]["username"] );
						$record["message"] = $tmpMessage;
						$DB->AutoExecute("fl_email_log", $record, 'INSERT');
					}
				

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
						$tmpMessage = str_replace( "{userid}", $searchResult[ $key ]["id"], $tmpMessage );
						$tmpMessage = str_replace( "{username}", $searchResult[ $key ]["username"], $tmpMessage );
						$tmpMessage = str_replace( "{password}", "Det lösenord du angav vid registrering, klicka <a href=\"http://www.flator.se/reset_password.html\">här</a> om du glömt ditt lösenord.", $tmpMessage );
						// Send email
						sendMail( $searchResult[ $key ]["email"], "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

						$record = array();
						$record["insDate"] = date( "Y-m-d H:i:s" );
						$record["emailType"] = "welcomeEmail";
						$record["recipientUserId"] = $searchResult[ $key ]["id"];
						$record["email"] = addslashes( $searchResult[ $key ]["username"] );
						$record["message"] = $tmpMessage;
						$DB->AutoExecute("fl_email_log", $record, 'INSERT');
					}
					*/
					echo "Sent to: ".$searchResult[ $key ]["email"]."\n";
		}
?>