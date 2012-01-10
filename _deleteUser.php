<?php
$metaTitle = "Flator.se - Avsluta medlemskap";

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/frontpage.html";
	include( "login_new.php" );
}
else
{

	$body = "<div id=\"center\">


<div id=\"divHeadSpace\" style=\"border: 0px; line-height: 10px\">&nbsp;</div>
<div class=\"section_headline\" style=\"padding-top: 13px; padding-bottom: 1px;\">Vill du avsluta ditt medlemskap ".$userProfile["username"]."?</div>
<br>
Allt innehåll kopplat till ditt medlemskap och din profil kommer att tas bort om du väljer att avsluta ditt medlemskap på Flator.se.
<form method=\"post\" enctype=\"multipart/form-data\" name=\"deleteUserForm\">
<input type=\"hidden\" name=\"type\" value=\"deleteAccount\" />
<table border=\"0\" width=\"600px\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px;margin-top:20px;\">



<tr>
	
	<td style=\"width: 250px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
	Bekräfta avslutande av medlemskap
	</td>
	<td style=\"width:300px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<div style=\"display: inline; float: left;  \">
			<input type=\"radio\" name=\"confirmDelete\" value=\"YES\"> Ja
						<input type=\"radio\" name=\"confirmDelete\" value=\"NO\" checked> Nej
	</div>
	</td>
</tr>
<tr>
	<td style=\"width: 150px; padding-bottom: 10px;padding-right:10px;\" valign=\"top\" align=\"right\">
&nbsp;
	</td>
	<td style=\"width:450px; padding-bottom: 10px;padding-left:10px;\" valign=\"top\" align=\"left\">
	<span onMouseOver=\"document.deleteAccount.src='".$baseUrl."/img/symbols/gif_red/radera.gif'\" onMouseOut=\"document.deleteAccount.src='".$baseUrl."/img/symbols/gif_purple/radera.gif'\"><nobr><a href=\"#noexist\" onClick=\"document.deleteUserForm.submit();\"><img src=\"".$baseUrl."/img/symbols/gif_purple/radera.gif\" name=\"deleteAccount\" align=\"ABSMIDDLE\" border=\"0\" />Bekräfta borttagning</a></nobr></span>
	</td>
</tr>

</table></form>";
















$body.= "
</p>

</div>

<div id=\"right\">";

	$body.= rightMenu('myAccount');
	$body.= "</div>";

}
?>