<?php
$metaTitle = "Flator.se - Mina sidor - Konto & inställningar";

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/my_account.html";
	include( "login_new.php" );
}
else
{
	unset( $error );



		$q = "SELECT * from fl_cities ORDER BY id ASC";
		$cities = $DB->GetAssoc( $q, FALSE, TRUE );



	$body = "<div id=\"center\">

<div id=\"divHeadSpace\" style=\"border: 0px; line-height: 10px\">&nbsp;</div>
<div class=\"section_headline\" style=\"padding-top: 13px; padding-bottom: 1px;\">Har du ställt in allt rätt ".$userProfile["username"]."?</div>

<form method=\"post\" enctype=\"multipart/form-data\" name=\"accountForm\">
<input type=\"hidden\" name=\"type\" value=\"editAccount\" />
<table border=\"0\" width=\"600px\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px\">

<tr>
 	<td colspan=\"2\" style=\"padding-bottom: 5px; border-bottom: 1px dotted #c8c8c8;\" valign=\"top\">";
	
	if (strlen($thankoyu) > 0) { 
	$body .= "<br>
	".$thankoyu; } else {
		$body .= "<br>Redigera dina medlemsuppgifter"; }
		$body .= "</td>
 </tr>
<tr>
 	<td colspan=\"2\" style=\"padding-bottom: 10px;\" valign=\"top\">&nbsp;</td>
 </tr>
";

if (strlen($userProfile["firstName"]) < 1) {
$body .= " <tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Förnamn:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"firstName\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["firstName"]."\">
	</div>
	</td>

</tr>";
}
if (strlen($userProfile["lastName"]) < 1) {
$body .= "<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Efternamn:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"lastName\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["lastName"]."\">
	</div>
	</td>
</tr>";
}
$body .= "
<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	E-post:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"email\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["email"]."\">
	</div>
	</td>
</tr>
<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Användarnamn:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"newUsername\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["username"]."\">
	</div>
	</td>
</tr>
<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Nytt lösenord (lämna tomt för att behålla gammalt):
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"password\" name=\"newPass\" style=\"width: 247px; border: 0px\" value=\"\" autocomplete=\"off\">
	</div>
	</td>
</tr>
<tr>
 	<td colspan=\"2\" style=\"padding-bottom: 5px; border-bottom: 1px dotted #c8c8c8;\" valign=\"top\"><br>Nedanstående information visas på din presentation om du fyller i dem!</td>
 </tr>
<tr>
 	<td colspan=\"2\" style=\"padding-bottom: 10px;\" valign=\"top\">&nbsp;</td>
 </tr>
<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Stad:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	
	
	<select name=\"city_id\" id=\"city_id\" style=\"width: 247px; border: 0px\">";


		while ( list( $key, $value ) = each( $cities ) )
		{

			

        	$selected = ($userProfile["cityId"] == $cities[ $key ]["id"]) ? " selected":"";
			$body .= "<option value=\"".$cities[ $key ]["id"]."\"".$selected.">".$cities[ $key ]["city"]."</option>\n";
    }




$body .= "</select></div></td>
</tr>
<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Relation:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"relationship\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["relationship"]."\">
	</div>
	</td>
</tr>
<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Letar efter:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"lookingFor\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["lookingFor"]."\">
	</div>
	</td>
</tr>
<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Attityd:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"attitude\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["attitude"]."\">
	</div>
	</td>
</tr>

<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Hobby:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"hobby\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["hobby"]."\">
	</div>
	</td>
</tr>

<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Boende:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"housing\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["housing"]."\">
	</div>
	</td>
</tr>

<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Politik:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"politics\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["politics"]."\">
	</div>
	</td>
</tr>

<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Hår:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"hair\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["hair"]."\">
	</div>
	</td>
</tr>

<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Dricker:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"drinks\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["drinks"]."\">
	</div>
	</td>
</tr>

<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Sexliv:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<input type=\"text\" name=\"sexlife\" style=\"width: 247px; border: 0px\" value=\"".$userProfile["sexlife"]."\">
	</div>
	</td>
</tr>

<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Presentation:
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<textarea name=\"presText\" style=\"width: 247px; height: 300px; border: 0px\">".stripslashes( br2nl($userProfile["presText"]) )."</textarea>
	</div>
	</td>
</tr>

<tr>
 	<td colspan=\"2\" style=\"padding-bottom: 5px; border-bottom: 1px dotted #c8c8c8;\" valign=\"top\"><br>Nedanstående inställningar påverkar din vistelse här på Flator.se</td>
 </tr>
<tr>
 	<td colspan=\"2\" style=\"padding-bottom: 10px;\" valign=\"top\">&nbsp;</td>
 </tr>
<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Är du tillgänglig för videochatt och har webbkamera när du är inloggad?
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left;  \">
			<input type=\"radio\" name=\"videoChat\" value=\"YES\"";
			 $body .= ($userProfile["videoChat"] == "YES") ? " checked":""; 
			$body .= "> Ja
						<input type=\"radio\" name=\"videoChat\" value=\"NO\"";
			$body .= ($userProfile["videoChat"] == "NO") ? " checked":""; 
			$body .= "> Nej
	</div>
	</td>
</tr>
<tr>
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
&nbsp;
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<span onMouseOver=\"document.saveAccount.src='".$baseUrl."/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.saveAccount.src='".$baseUrl."/img/symbols/gif_purple/skicka.gif'\"><nobr><a href=\"#noexist\" onClick=\"document.accountForm.submit();\"><img src=\"".$baseUrl."/img/symbols/gif_purple/skicka.gif\" name=\"saveAccount\" align=\"ABSMIDDLE\" border=\"0\" />Spara inställningar</a></nobr></span>
	</td>
</tr>

<tr>
 	<td colspan=\"2\" style=\"padding-bottom: 5px; border-top: 1px dotted #c8c8c8;\" valign=\"top\"><br><br><br><br><br><br><br><br></td>
 </tr>

<tr>
 	<td colspan=\"2\" style=\"padding-bottom: 5px; border-bottom: 1px dotted #c8c8c8;\" valign=\"top\"><br>Avsluta medlemskap på Flator.se</td>
 </tr>
<tr>
 	<td colspan=\"2\" style=\"padding-bottom: 10px;\" valign=\"top\">&nbsp;</td>
 </tr>
<tr>
	
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Önskar du avsluta ditt medlemskap på Flator.se?
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left;  \">
	<span onMouseOver=\"document.quitMembership.src='".$baseUrl."/img/symbols/gif_red/radera.gif'\" onMouseOut=\"document.quitMembership.src='".$baseUrl."/img/symbols/gif_purple/radera.gif'\"><nobr><a href=\"".$baseUrl."/deleteUser.html\"><img src=\"".$baseUrl."/img/symbols/gif_purple/radera.gif\" name=\"quitMembership\" align=\"ABSMIDDLE\" border=\"0\" />Ja, avsluta medlemskap</a></nobr></span>
	</div>
	</td>
</tr>

</table>


</form>
</div>

<div id=\"right\">";

	$body.= rightMenu('myAccount');


$body.= "</div>";

}
?>