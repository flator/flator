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
<div class=\"section_headline\" style=\"padding-top: 13px; padding-bottom: 1px;\">B�rja videochatta!</div>
<p>Allt som kr�vs f�r att du skall kunna videochatta med andra medlemmar h�r p� Flator.se �r att du har en webbkamera!<br /><br />
<strong>Om inget f�nster �ppnas m�ste du inaktivera din popup-blockerare f�r att komma �t videochatten!</strong></p>

<input type=\"button\" value=\"Starta videochatten\" onClick=\"window.open('http://www.flator.se/videochatt/','videochat','width=800,height=620')\"> 
</div>

<div id=\"right\">";
} else {




	$body = "<div id=\"center\">

<div id=\"divHeadSpace\" style=\"border: 0px; line-height: 10px\">&nbsp;</div>
<div class=\"section_headline\" style=\"padding-top: 13px; padding-bottom: 1px;\">H�ll ut ".$userProfile["username"].", v�r nya videochatt �r p� g�ng!</div>
<p>V�r nya videochatt har dr�jt, och blir f�r varje dag mer och mer f�rdig. N�r den �r klar kommer ni att f� tillg�ng till den b�sta videochatten p� internet! H�r nedan ser du n�gra av de funktioner som vi planerat f�r.</p>
<ul>
<li>1 till 1-videochatt</li>
<li>Gemensamt chattf�nster d�r alla kan kommunicera</li>
<li>Integration i sajten s� att man fr�n folks presentationer enkelt kan bjuda in till chatt.</li>
<li>H�gkvalitativ video�verf�ring!</li>
<li>Anpassas automatiskt till snabb eller l�ngsam internetanslutning.</li>
<li>Dragbara/flyttbara f�nster, arrangera dina konversationer hur du vill!</li>
<li>Allt som kr�vs �r webbkamera (och mikrofon om du vill prata).</li>
<li>Klicka dig direkt in till folks sidor ifr�n chatten.</li>
</ul>

<h3>F�rhandsvisning av v�r nya videochatt</h3>
<p>Detta �r en liten f�rhandsvisning av ungef�r hur den nya chatten kommer se ut, den �r under konstant utveckling och mycket kan komma att f�r�ndras, men bilden b�r representera ungef�r hur den kommer se ut.</p>
<img src=\"".$baseUrl."/videochatt/videochatt.png\" border=\"0\">
</div>

<div id=\"right\">";
}
	$body.= rightMenu('myAccount');


$body.= "</div>";

}
?>