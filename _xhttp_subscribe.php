<?=$_GET["target"]?>[-END-]
<?php
include( "config.php" );

sleep(1);

if( eregi( "^[_a-z0-9-]+(.*)@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_GET["email"] ) )
{
#	if ( $_GET["email"] == "daniel_william@hotmail.com" );
#	{
#		$DB->debug = TRUE;
#	}
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

	$q = "SELECT * FROM fl_users WHERE email = '" . addslashes( $_GET["email"] ) . "'";
	$emailDetail = $DB->GetRow( $q, FALSE, TRUE );
	if ( strlen( $emailDetail["email"] ) < 1 )
	{
		$q = "INSERT INTO fl_users (insDate, email, remoteAddr, rights) VALUES (NOW(), '" . addslashes( $_GET["email"] ) . "', '" . addslashes( $_SERVER["REMOTE_ADDR"] ) . "', 1)";
	    if ( $DB->Execute($q) === FALSE ) {
	        echo "<div id=\"error\">Error inserting: " . $DB->ErrorMsg() . "</div>\n";
	    }
		else
		{
			echo "<br/><br/><div id=\"thankyou\">Du och dina v&auml;nner har f&aring;tt mail med inbjudan till flator.se</div>";
		}
		$recruitedBy = $DB->Insert_ID();

		$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["newSubscriber"];
		$rowTemplate = $DB->GetRow( $q, FALSE, TRUE );
		if ( count( $rowTemplate ) > 0 )
		{
			$message = $rowTemplate["content"];
			$subject = $rowTemplate["subject"];
			if ( strlen( $subject ) < 1 )
			{
				$subject = "Flator.se - Bekräftelse";
			}
			$tmpMessage = $message;
			// Send email
			sendMail( addslashes( $_GET["email"] ), "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

			$record = array();
			$record["insDate"] = date( "Y-m-d H:i:s" );
			$record["emailType"] = "newSubscriber";
			$record["recipientUserId"] = (int)$userId;
			$record["email"] = addslashes( $_GET["email"] );
			$record["message"] = $tmpMessage;
			$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];
			$DB->AutoExecute("fl_email_log", $record, 'INSERT');
		}
	}
	else
	{
		echo "<div id=\"thankyou\">Du och dina v&auml;nner kommer snart f&aring; exklusiv tillg&aring;ng till flator.se</div>";

		$recruitedBy = $emailDetail["id"];
	}

	if( eregi( "^[_a-z0-9-]+(.*)@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_GET["friendEmail1"] ) )
	{
		$q = "SELECT * FROM fl_users WHERE email = '" . addslashes( $_GET["friendEmail1"] ) . "'";
		$emailDetail = $DB->GetRow( $q, FALSE, TRUE );
		if ( !$DB->GetOne( $q ) )
		{
			$q = "INSERT INTO fl_users (insDate, email, remoteAddr, rights, recruitedBy) VALUES (NOW(), '" . addslashes( $_GET["friendEmail1"] ) . "', '" . addslashes( $_SERVER["REMOTE_ADDR"] ) . "', 1, " . $recruitedBy . ")";
		    if ( $DB->Execute($q) === FALSE ) { 
		        echo "<div id=\"error\">Error inserting: " . $DB->ErrorMsg() . "(" . $q . ")</div>\n"; 
		    }

			$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["newSubscriberFriend"];
			$rowTemplate = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $rowTemplate ) > 0 )
			{
				$message = $rowTemplate["content"];
				$subject = $rowTemplate["subject"];
				if ( strlen( $subject ) < 1 )
				{
					$subject = "Flator.se - Tipsad av en kompis";
				}
				$tmpMessage = $message;
				// Send email
				sendMail( addslashes( $_GET["friendEmail1"] ), "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["emailType"] = "newSubscriber";
				$record["recipientUserId"] = (int)$userId;
				$record["email"] = addslashes( $_GET["friendEmail1"] );
				$record["message"] = $tmpMessage;
				$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];
				$DB->AutoExecute("fl_email_log", $record, 'INSERT');
			}
		}
	}
	if( eregi( "^[_a-z0-9-]+(.*)@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_GET["friendEmail2"] ) )
	{
		$q = "SELECT * FROM fl_users WHERE email = '" . addslashes( $_GET["friendEmail2"] ) . "'";
		$emailDetail = $DB->GetRow( $q, FALSE, TRUE );
		if ( !$DB->GetOne( $q ) )
		{
			$q = "INSERT INTO fl_users (insDate, email, remoteAddr, rights, recruitedBy) VALUES (NOW(), '" . addslashes( $_GET["friendEmail2"] ) . "', '" . addslashes( $_SERVER["REMOTE_ADDR"] ) . "', 1, " . $recruitedBy . ")";
			if ( $DB->Execute($q) === FALSE ) { 
			    echo "<div id=\"error\">Error inserting: " . $DB->ErrorMsg() . "</div>\n"; 
			}

			$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["newSubscriberFriend"];
			$rowTemplate = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $rowTemplate ) > 0 )
			{
				$message = $rowTemplate["content"];
				$subject = $rowTemplate["subject"];
				if ( strlen( $subject ) < 1 )
				{
					$subject = "Flator.se - Tipsad av en kompis";
				}
				$tmpMessage = $message;
				// Send email
				sendMail( addslashes( $_GET["friendEmail2"] ), "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["emailType"] = "newSubscriber";
				$record["recipientUserId"] = (int)$userId;
				$record["email"] = addslashes( $_GET["friendEmail2"] );
				$record["message"] = $tmpMessage;
				$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];
				$DB->AutoExecute("fl_email_log", $record, 'INSERT');
			}
		}
	}
	if( eregi( "^[_a-z0-9-]+(.*)@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_GET["friendEmail3"] ) )
	{
		$q = "SELECT * FROM fl_users WHERE email = '" . addslashes( $_GET["friendEmail4"] ) . "'";
		$emailDetail = $DB->GetRow( $q, FALSE, TRUE );
		if ( !$DB->GetOne( $q ) )
		{
			$q = "INSERT INTO fl_users (insDate, email, remoteAddr, rights, recruitedBy) VALUES (NOW(), '" . addslashes( $_GET["friendEmail3"] ) . "', '" . addslashes( $_SERVER["REMOTE_ADDR"] ) . "', 1, " . $recruitedBy . ")";
		    if ( $DB->Execute($q) === FALSE ) { 
		        echo "<div id=\"error\">Error inserting: " . $DB->ErrorMsg() . "</div>\n"; 
		    }

			$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["newSubscriberFriend"];
			$rowTemplate = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $rowTemplate ) > 0 )
			{
				$message = $rowTemplate["content"];
				$subject = $rowTemplate["subject"];
				if ( strlen( $subject ) < 1 )
				{
					$subject = "Flator.se - Tipsad av en kompis";
				}
				$tmpMessage = $message;
				// Send email
				sendMail( addslashes( $_GET["friendEmail3"] ), "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["emailType"] = "newSubscriber";
				$record["recipientUserId"] = (int)$userId;
				$record["email"] = addslashes( $_GET["friendEmail3"] );
				$record["message"] = $tmpMessage;
				$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];
				$DB->AutoExecute("fl_email_log", $record, 'INSERT');
			}
		}
	}
	if( eregi( "^[_a-z0-9-]+(.*)@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_GET["friendEmail4"] ) )
	{
		$q = "SELECT * FROM fl_users WHERE email = '" . addslashes( $_GET["friendEmail4"] ) . "'";
		$emailDetail = $DB->GetRow( $q, FALSE, TRUE );
		if ( !$DB->GetOne( $q ) )
		{
			$q = "INSERT INTO fl_users (insDate, email, remoteAddr, rights, recruitedBy) VALUES (NOW(), '" . addslashes( $_GET["friendEmail4"] ) . "', '" . addslashes( $_SERVER["REMOTE_ADDR"] ) . "', 1, " . $recruitedBy . ")";
		    if ( $DB->Execute($q) === FALSE ) { 
		        echo "<div id=\"error\">Error inserting: " . $DB->ErrorMsg() . "</div>\n"; 
		    }

			$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["newSubscriberFriend"];
			$rowTemplate = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $rowTemplate ) > 0 )
			{
				$message = $rowTemplate["content"];
				$subject = $rowTemplate["subject"];
				if ( strlen( $subject ) < 1 )
				{
					$subject = "Flator.se - Tipsad av en kompis";
				}
				$tmpMessage = $message;
				// Send email
				sendMail( addslashes( $_GET["friendEmail4"] ), "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["emailType"] = "newSubscriber";
				$record["recipientUserId"] = (int)$userId;
				$record["email"] = addslashes( $_GET["friendEmail4"] );
				$record["message"] = $tmpMessage;
				$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];
				$DB->AutoExecute("fl_email_log", $record, 'INSERT');
			}
		}
	}
	if( eregi( "^[_a-z0-9-]+(.*)@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_GET["friendEmail5"] ) )
	{
		$q = "SELECT * FROM fl_users WHERE email = '" . addslashes( $_GET["friendEmail5"] ) . "'";
		$emailDetail = $DB->GetRow( $q, FALSE, TRUE );
		if ( !$DB->GetOne( $q ) )
		{
			$q = "INSERT INTO fl_users (insDate, email, remoteAddr, rights, recruitedBy) VALUES (NOW(), '" . addslashes( $_GET["friendEmail5"] ) . "', '" . addslashes( $_SERVER["REMOTE_ADDR"] ) . "', 1, " . $recruitedBy . ")";
		    if ( $DB->Execute($q) === FALSE ) { 
		        echo "<div id=\"error\">Error inserting: " . $DB->ErrorMsg() . "</div>\n"; 
		    }

			$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["newSubscriberFriend"];
			$rowTemplate = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $rowTemplate ) > 0 )
			{
				$message = $rowTemplate["content"];
				$subject = $rowTemplate["subject"];
				if ( strlen( $subject ) < 1 )
				{
					$subject = "Flator.se - Tipsad av en kompis";
				}
				$tmpMessage = $message;
				// Send email
				sendMail( addslashes( $_GET["friendEmail5"] ), "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["emailType"] = "newSubscriber";
				$record["recipientUserId"] = (int)$userId;
				$record["email"] = addslashes( $_GET["friendEmail5"] );
				$record["message"] = $tmpMessage;
				$record["remoteAddr"] = $_SERVER["REMOTE_ADDR"];
				$DB->AutoExecute("fl_email_log", $record, 'INSERT');
			}
		}
	}
}
else
{
	echo "<div id=\"error\">Du har angett en ogiltig e-postadress, v&auml;nligen f&ouml;rs&ouml;k igen.</div>\n";
}

?>