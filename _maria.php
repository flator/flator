<?php
$metaTitle = "Flator.se - Maria";


	$publicMenu = TRUE;
	$memberMenu = FALSE;



$i2 = 0;
	$i = 1;
	$used = 0;
	while ( $i2 < 10) {
	
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
		$record["recruitedBy"] = (int)$userProfile["id"];
		
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




$body = "<div id=\"center\">



<div style=\"float: left; width: 200px; margin-right: 25px\">

<p style=\"margin-top: 20px\"><object width=\"200\" height=\"176\"><param name=\"movie\" value=\"http://www.youtube.com/v/n1D8pINHhyA&hl=en&fs=1&rel=0\"></param><param name=\"allowFullScreen\" value=\"true\"></param><embed src=\"http://www.youtube.com/v/n1D8pINHhyA&hl=en&fs=1&rel=0\" type=\"application/x-shockwave-flash\" allowfullscreen=\"true\" width=\"200\" height=\"176\"></embed></object></p>

<p>

<span style=\"font-family: courier new\">Festglad!</span></p>

<p>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Stad</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Överallt</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Relation</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Polly</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Syfte</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Tjejer till flator.se</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Född</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">23 mars, 1983</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Attityd</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Kaxig</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Hobby</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Vad är det?</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Boende</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Flyttkartong</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Politik</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Modern</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Hår</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Vågat</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Dricker</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Champagne</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Sexliv</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Kanin</div>
</p>

</div>
<div style=\"float: left; width: 370px;\">

<div style=\"padding-bottom: 4px; border-bottom: 1px dotted #c8c8c8;\">
<h3>Hos: <span style=\"font-weight: normal\">Reklamflatan Maria</span></h3>
</div>

<p><img src=\"" . $baseUrl . "/img/hello_snygging.gif\" border=\"0\" style=\"margin-top: 10px\" /></p>

<div style=\"font-family: courier new\">

<p>Du är här för att vi tyckte du verkade härlig från början, och tänkte att flator.se kunde vara nåt för dig (och dina schyssta kompisar). Den här lilla kampanjsidan berättar kort vad flator.se handlar om och ger en möjlighet att snabbt hitta en länk till gratis medlemsskap eller tipsa en vän.</p>

<p>Flator.se är en unik site riktad direkt till alla härliga lesbiska/bisexuella och transexuella tjejer i Sverige. Här är det helt upp till användarna vad som händer på sidan. Forumet är öppet för ändringar. Vi på flator.se är mycket noggranna med att användare och innehåll som inte är avsett för ett community för flator inte läggs upp eller sprids här. Allting som finns på flator.se är gratis och snart kommer det att  finnas en video-chat för att ge dig en större möjlighet att skapa kontakter och hitta goa vänner.</p>

<p>Flator.se ägs och drivs av TigerLilly Interactive AB.</p>
<a href=\"http://www.flator.se/register.html\">Bli medlem här!</a><br /><br />
<a href=\"http://www.facebook.com/group.php?gid=15154079699\">Flator.se på Facebook</a><br />
<br /><br /><br />";
if ($used > 0) {
	$body.= "<h2>Bjud in flator</h2><div id=\"thankyou\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">$used inbjudning".((int)$used > 1 ? "ar" : "")." har skickats iväg!</ul></div>";
} else {
	$body.= "<h2>Bjud in flator</h2>";
}
	$body.= "<form method=\"post\" style=\"padding: 0px; margin: 0px\">";

$i2 = 0;
$i = 1;
while ( $i2 < 5) {
$body .= "<p><label style=\"width:160px;\" for=\"inviteMail".$i."\">E-post till flata ".$i.":</label> <input type=\"text\" id=\"inviteMail".$i."\" name=\"inviteMail".$i."\" value=\"\" /></p>";
$i2++;
$i++;
}
$body .= "

<p class=\"submit\"><input type=\"submit\" value=\"Bjud in flator!\" /></p>

</form>";
$body .= "
</div>


</div>

</div>

<div id=\"right\">";
if ( (int)$_SESSION["userId"] > 0 )
{
	$body.= rightMenu('index');
}
else
{
	$body.= rightMenu('index');
}
$body.= "</div>";

?>