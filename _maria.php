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
					$subject = "Flator.se - Inbjuden av en v�n";
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
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Stad</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">�verallt</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Relation</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Polly</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Syfte</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Tjejer till flator.se</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">F�dd</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">23 mars, 1983</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Attityd</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Kaxig</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Hobby</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Vad �r det?</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Boende</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Flyttkartong</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">Politik</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">Modern</div>
<div class=\"email_date\" style=\"clear: both; float: left; width: 60px\">H�r</div><div style=\"float: left; width: 120px; font-family: courier new; line-height: 18px\">V�gat</div>
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

<p>Du �r h�r f�r att vi tyckte du verkade h�rlig fr�n b�rjan, och t�nkte att flator.se kunde vara n�t f�r dig (och dina schyssta kompisar). Den h�r lilla kampanjsidan ber�ttar kort vad flator.se handlar om och ger en m�jlighet att snabbt hitta en l�nk till gratis medlemsskap eller tipsa en v�n.</p>

<p>Flator.se �r en unik site riktad direkt till alla h�rliga lesbiska/bisexuella och transexuella tjejer i Sverige. H�r �r det helt upp till anv�ndarna vad som h�nder p� sidan. Forumet �r �ppet f�r �ndringar. Vi p� flator.se �r mycket noggranna med att anv�ndare och inneh�ll som inte �r avsett f�r ett community f�r flator inte l�ggs upp eller sprids h�r. Allting som finns p� flator.se �r gratis och snart kommer det att  finnas en video-chat f�r att ge dig en st�rre m�jlighet att skapa kontakter och hitta goa v�nner.</p>

<p>Flator.se �gs och drivs av TigerLilly Interactive AB.</p>
<a href=\"http://www.flator.se/register.html\">Bli medlem h�r!</a><br /><br />
<a href=\"http://www.facebook.com/group.php?gid=15154079699\">Flator.se p� Facebook</a><br />
<br /><br /><br />";
if ($used > 0) {
	$body.= "<h2>Bjud in flator</h2><div id=\"thankyou\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">$used inbjudning".((int)$used > 1 ? "ar" : "")." har skickats iv�g!</ul></div>";
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