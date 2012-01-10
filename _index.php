<?php
$metaTitle = "Ett community och m&ouml;tesplats f&ouml;r lesbiska - flator.se.";

$body = "
<div id=\"left\">
	<div class=\"contentdiv\">
	<h2>Här öppnar snart Sveriges nya mötesplats och community för flator</h2>

<p>Detta community för lesbiska kommer att erbjuda:</p>

<ul>
<li>En egen profil med bildgallerier</li>
<li>Se vilka som är online </li>
<li>Sök medlemmar per land/region/stad mm. </li>
<li>Röstning </li>
<li>Toplistor </li>
<li>Dina vänner </li>
<li>Egen blogg </li>
<li>Forum </li>
<li>mm, mm.</li>
</ul>

<p>Lanseringen är planerad till PRIDE!</p>
	</div>
</div>
<div id=\"center\">
	<div class=\"contentdiv\">
	<h2>Få din inbjudan!</h2>
Fyll i din e-post så meddelar vi när vi när mötesplatsen är färdig!

<form method=\"post\" style=\"padding: 0px; margin: 0px\">
<p>E-postadress: <input type=\"text\" name=\"email\" onKeyPress=\"return event.keyCode!=13\" /><input type=\"button\" value=\"Skicka\" onClick=\"showLoad('output');getContent('subscribe.php?target=output&email=' + escape(this.form.email.value));\" /></p>
</form>

<div id=\"output\"></div>
	</div>
</div>";

if ( $showAdmin == TRUE )
{
	$body.= "

	<div id=\"right\">
		<div class=\"contentdiv\">

<div id=\"login\">
	<h3 class=\"loginTitle\">Logga in</h3>
	
<form method=\"post\" style=\"padding: 0px; margin: 0px\" action=\"" . $baseUrl . "/frontpage.html\">

<p><label for=\"username\">Användarnamn:</label> <input type=\"text\" id=\"username\" name=\"username\" /></p>
<p><label for=\"password\">Lösenord:</label> <input type=\"password\" id=\"password\" name=\"password\" /></p>
<p class=\"submit\"><input type=\"submit\" value=\"Logga in\" /></p>

</form>
Glömt ditt lösenord? <a href=\"" . $baseUrl . "/reset_password.html\">Begär lösenord</a>
</div>

<div id=\"login\">Har du f&aring;tt en inbjudan med inbjudningskod?<br /><a href=\"" . $baseUrl . "/register.html\">Skapa konto h&auml;r!</a></div>

		</div>
	</div>

	";
}

$body.= "<div id=\"right\">
	<div class=\"contentdiv\">
	<h2>Följ utvecklingen av mötesplatsen och gästblogga</h2>
Vi har en blogg där du kan följa utveckligen av denna mötesplats. Här kan du dessutom själv gästblogga och följa andra gästbloggare som skriver om sina liv som flator.

<p><a href=\"" . $baseUrl . "/blogg/\">Bloggen om flator och flator.se</a></p>
	</div>
</div>

<div id=\"left\" style=\"clear: both\">
	<div class=\"contentdiv\">
<h2>Förslag</h2>
Har du några förslag på funktioner du gärna skulle vilja se på flator.se? Skicka in förslaget så kan det bli verklighet.

<form method=\"post\" style=\"padding: 0px; margin: 0px\">
<p><label for=\"name\">Namn:</label> <input type=\"text\" name=\"name\" id=\"name\" onKeyPress=\"return event.keyCode!=13\" /></p>
<p><label for=\"suggestion\">Förslag:</label> <textarea name=\"suggestion\" id=\"suggestion\" rows=\"3\" style=\"width: 200px\"></textarea></p>
<p><input type=\"button\" value=\"Skicka\" style=\"margin-left: 8.5em\" onClick=\"showLoad('suggestOutput');getContent('suggestion.php?target=suggestOutput&name=' + escape(this.form.name.value) + '&suggestion=' + escape(this.form.suggestion.value));\" /></p>
</form>

<div id=\"suggestOutput\"></div>
	</div>
</div>

<div id=\"left\" style=\"margin-top: 20px; min-width: 600px\">
<a href=\"" . $baseUrl . "/blogg/\"><img src=\"/flator-blogg.gif\" alt=\"Bes&ouml;k v&aring;r blogg om lesbiskt liv - Du kan sj&auml;lv blogga om du vill!\" width=\"600\" height=\"304\" border=\"0\"></a>
</p>


";
?>