<?php
$metaTitle = "Flator.se - Videochatt";

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/videochat.html";
	include( "login_new.php" );
}
else
{
	unset( $error );



		$q = "SELECT * from fl_cities ORDER BY id ASC";
		$cities = $DB->GetAssoc( $q, FALSE, TRUE );

if ( (int)$_SESSION["rights"] > 1 )
{
	$body = "<div id=\"center\">

<div id=\"divHeadSpace\" style=\"border: 0px; line-height: 10px\">&nbsp;</div>
<div class=\"section_headline\" style=\"padding-top: 13px; padding-bottom: 1px;\">Börja videochatta!</div>
<p>Allt som krävs för att du skall kunna videochatta med andra medlemmar här på Flator.se är att du har en webbkamera!<br /><br />
<strong>Om inget fönster öppnas måste du inaktivera din popup-blockerare för att komma åt videochatten!</strong></p>

<input type=\"button\" value=\"Starta videochatten\" onClick=\"window.open('http://www.flator.se/videochatt/','videochat','width=800,height=620')\"> 
</div>

<div id=\"right\">";
} else {




	$body = "<div id=\"center\">

<div id=\"divHeadSpace\" style=\"border: 0px; line-height: 10px\">&nbsp;</div>
<div class=\"section_headline\" style=\"padding-top: 13px; padding-bottom: 1px;\">Håll ut ".$userProfile["username"].", vår nya videochatt är på gång!</div>
<p>Vår nya videochatt har dröjt, och blir för varje dag mer och mer färdig. När den är klar kommer ni att få tillgång till den bästa videochatten på internet! Här nedan ser du några av de funktioner som vi planerat för.</p>
<ul>
<li>1 till 1-videochatt</li>
<li>Gemensamt chattfönster där alla kan kommunicera</li>
<li>Integration i sajten så att man från folks presentationer enkelt kan bjuda in till chatt.</li>
<li>Högkvalitativ videoöverföring!</li>
<li>Anpassas automatiskt till snabb eller långsam internetanslutning.</li>
<li>Dragbara/flyttbara fönster, arrangera dina konversationer hur du vill!</li>
<li>Allt som krävs är webbkamera (och mikrofon om du vill prata).</li>
<li>Klicka dig direkt in till folks sidor ifrån chatten.</li>
</ul>

<h3>Förhandsvisning av vår nya videochatt</h3>
<p>Detta är en liten förhandsvisning av ungefär hur den nya chatten kommer se ut, den är under konstant utveckling och mycket kan komma att förändras, men bilden bör representera ungefär hur den kommer se ut.</p>
<img src=\"".$baseUrl."/videochatt/videochatt.png\" border=\"0\">
</div>

<div id=\"right\">";
}
	$body.= rightMenu('myAccount');


$body.= "</div>";

}
?>