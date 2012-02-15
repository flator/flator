<?php
session_start();
if ( (int)$_SESSION["rights"] < 6 )
{
	echo $_GET["target"] . "[-END-]Session timeout! Try to login again.";
}
else
{
?>
<?=$_GET["target"]?>[-END-]
<?php
	unset( $status );
	include( "config.php" );

	if ( ( $_GET["type"] == "invitation" || $_GET["type"] == "newsletter" ) && (int)$_GET["templateId"] > 0 )
	{

		$q = "SELECT * FROM fl_templates WHERE id = " . (int)$_GET["templateId"];
		$row = $DB->GetRow( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			$message = $row["content"];
			$subject = $row["subject"];
			if ( strlen( $subject ) < 1 )
			{
				$subject = "Flator.se";
			}

#echo $_GET["userIds"];
#exit;

			$userIds = explode( ",", $_GET["userIds"] );
			if ( count( $userIds ) > 0 )
			{
				while ( list( $key, $value ) = each( $userIds ) )
				{
					if ( $value == "undefined" ) continue;

					if ( $_GET["type"] == "invitation" )
					{
						$q = "SELECT fl_users.*, fl_invitations.invitationCode FROM fl_users LEFT JOIN fl_invitations ON fl_invitations.userId = fl_users.id WHERE fl_users.id = " . (int)$value;
						$users = $DB->GetAssoc( $q, FALSE, TRUE );
						if ( count( $users ) > 0 )
						{
							while ( list( $key1, $key2 ) = each( $users ) )
							{
								if ( strlen( $users[ $key1 ]["invitationCode"] ) > 0 )
								{
									$invitationCode = $users[ $key1 ]["invitationCode"];
								}
								else
								{
									$tmpCode = randCode( 15 );
									$invitationCode = substr( $tmpCode, 0, 5 ) . "-" . substr( $tmpCode, 4, 5 ) . "-" . substr( $tmpCode, 9, 5 );

									$record = array();
									$record["invitationCode"] = $invitationCode;
									$record["insDate"] = date( "Y-m-d H:i:s" );
									$record["userId"] = (int)$users[ $key1 ]["id"];
									$record["used"] = "NO";
									$record["email"] = $users[ $key1 ]["email"];
									$DB->AutoExecute("fl_invitations", $record, 'INSERT' );
								}

								$tmpMessage = $message;

								$tmpMessage = str_replace( "{invitationCode}", $invitationCode, $tmpMessage );
								// Send email
								sendMail( $users[ $key1 ]["email"], "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

								$record = array();
								$record["insDate"] = date( "Y-m-d H:i:s" );
								$record["userId"] = $_SESSION["userId"];
								$record["emailType"] = "invitation";
								$record["recipientUserId"] = (int)$value;
								$record["email"] = $users[ $key1 ]["email"];
								$record["message"] = $tmpMessage;
								$DB->AutoExecute("fl_email_log", $record, 'INSERT');

								$status = "Inbjudningar skickade!";
							}
						}
					}
					else
					{
						$q = "SELECT fl_users.* FROM fl_users WHERE fl_users.id = " . (int)$value;
						$users = $DB->GetAssoc( $q, FALSE, TRUE );
						if ( count( $users ) > 0 )
						{
							while ( list( $key1, $key2 ) = each( $users ) )
							{
								$tmpMessage = $message;

								$tmpMessage = str_replace( "{username}", $users[ $key1 ]["username"], $tmpMessage );
								// Send email
								sendMail( $users[ $key1 ]["email"], "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

								$record = array();
								$record["insDate"] = date( "Y-m-d H:i:s" );
								$record["userId"] = $_SESSION["userId"];
								$record["emailType"] = "newsletter";
								$record["recipientUserId"] = (int)$value;
								$record["email"] = $users[ $key1 ]["email"];
								$record["message"] = $tmpMessage;
								$DB->AutoExecute("fl_email_log", $record, 'INSERT');

								$status = "Nyhetsbrev skickat!";
							}
						}
					}
				}
			}
		}
	}

	if ( strlen( $status ) > 0 )
	{
?>
<div id="boxNote"><?=$status?></div>
<?php
	}
	else
	{
?>
<div id="error">Inget meddelande skickades (inga mottagare valda).</div>
<?php
	}
}
?>