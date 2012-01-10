<?php
$metaTitle = "Flator.se - Flörtar";

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/flirts.html";
	include( "login_new.php" );
}
else
{
if ( $_SESSION["demo"] != TRUE ) {
	$record = array();
	$record["seen"] = 'YES';
	$DB->AutoExecute( "fl_flirts", $record, 'UPDATE', 'recipientUserId = '.$userProfile["id"] );
}
	$body = "<div id=\"center\">


<div id=\"divHeadSpace\" style=\"border: 0px; line-height: 10px\">&nbsp;</div>
<div class=\"section_headline\" style=\"padding-top: 10px; padding-bottom: 1px;border:none; border-bottom: 1px dotted #c8c8c8; width:592px; margin-bottom:00px;\" width=\"595px\">Dina flörtar</div>";







$q = "SELECT fl_flirts.*, fl_users.username,  UNIX_TIMESTAMP(fl_flirts.insDate) AS unixTime FROM fl_flirts LEFT JOIN fl_users ON fl_flirts.senderUserId = fl_users.id WHERE recipientUserId = '".$userProfile["id"]."' ORDER BY id DESC";
$shoutArray = $DB->GetAssoc( $q, FALSE, TRUE );

if ( count( $shoutArray ) > 0 )
{
	while ( list( $key, $value ) = each( $shoutArray ) )
	{
				// Possible date-types: Today, Yesterday, ThisYear, LastYear
		if ( date("Y-m-d", $shoutArray[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
		{
			// Message sent today
			$onlineTime = "<span class=\"email_date\">" . "Idag " . date( "H:i", $shoutArray[ $key ]["unixTime"] ) . "</span>";
		}
		elseif ( date("Y-m-d", $shoutArray[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
		{
			// Message sent yesterday
			$onlineTime = "<span class=\"email_date\">" . "Ig&aring;r " . date( "H:i", $shoutArray[ $key ]["unixTime"] ) . "</span>";
		}
		elseif ( date("Y", $shoutArray[ $key ]["unixTime"] ) == date( "Y" ) )
		{
			// Message sent this year
			$onlineTime = "<span class=\"email_date\">" . date( "j M Y H:i", $shoutArray[ $key ]["unixTime"] ) . "</span>";
		}
		else
		{
			$onlineTime = "<span class=\"email_date\">" . date( "Y-m-d H:i", $shoutArray[ $key ]["unixTime"] ) . "</span>";
		}
		if ($shoutArray[ $key ]["flirt"] == "sexbomb") {
		$shoutArray[ $key ]["imagePath"] = "regler.gif";
		$shoutArray[ $key ]["text"] = "Du är en sexbomb!";
		} elseif ($shoutArray[ $key ]["flirt"] == "kastaankare") {
		$shoutArray[ $key ]["imagePath"] = "mig.gif";
		$shoutArray[ $key ]["text"] = "Får jag kasta ankare hos dig?";
		} elseif ($shoutArray[ $key ]["flirt"] == "klass") {
		$shoutArray[ $key ]["imagePath"] = "topplista_film.gif";
		$shoutArray[ $key ]["text"] = "Dig är det klass på!";
		} elseif ($shoutArray[ $key ]["flirt"] == "drink") {
		$shoutArray[ $key ]["imagePath"] = "typ_av_event.gif";
		$shoutArray[ $key ]["text"] = "Dig skulle jag kunna ta en drink med!";
		} elseif ($shoutArray[ $key ]["flirt"] == "message") {
		$shoutArray[ $key ]["imagePath"] = "skicka_flort.gif";
		$shoutArray[ $key ]["text"] = $shoutArray[ $key ]["message"];
		} else {
		$shoutArray[ $key ]["imagePath"] = "skicka_flort.gif";
		$shoutArray[ $key ]["text"] = $shoutArray[ $key ]["message"];
		}


		$body.= "";

		
			$body.= "<div style=\"float: left; width: 30px; margin-right: 10px;margin-top:10px;\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/" . $shoutArray[ $key ]["imagePath"] . "\" border=\"0\" /></div>";
		

		$body.= "<div style=\"float: left; width: 360px;margin-top:10px;\">" . $shoutArray[ $key ]["text"] . "&nbsp;&nbsp;&nbsp; <a href=\"http://www.flator.se/user/" . stripslashes($shoutArray[ $key ]["username"]) . ".html\">".stripslashes($shoutArray[ $key ]["username"])."</a>&nbsp;&nbsp;".$onlineTime;
		
							$body .= "<a href=\"#noexist\" class=\"deleteLink\" OnClick=\"if(confirm('Ta bort denna flört?')) { location.search='?do=deleteFlirt&flirtId=" . $shoutArray[ $key ]["id"] ."'; } else { return false; }\"><img src=\"".$baseUrl."/img/symbols/gif_purple/kryss_litet.png\" border=\"0\" width=\"8px\" height=\"8px\" style=\"margin-left:4px\" name=\"deleteStatusCommentImg".$key."\" onMouseOver=\"document.deleteStatusCommentImg".$key.".src='".$baseUrl."/img/symbols/gif_red/kryss_litet.png'\" onMouseOut=\"document.deleteStatusCommentImg".$key.".src='".$baseUrl."/img/symbols/gif_purple/kryss_litet.png'\"></a>";

		$body.= "</div>";
				$body.= "<div style=\"float: right; width: 170;margin-top:10px;text-align:right;margin-right:10px;\"><span onMouseOver=\"document.sendFlirt_onpres.src='" . $baseUrl . "/img/symbols/gif_red/skicka_flort.gif'\" onMouseOut=\"document.sendFlirt_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/skicka_flort.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupSendFlirt".$key."');\" style=\"font-weight: normal;\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka_flort.gif\" border=\"0\" align=\"ABSMIDDLE\" name=\"sendFlirt_onpres\" />&nbsp;&nbsp;Skicka en flört tillbaka</a></span></div>";
		$body.= '<div style="clear:both;"></div>
<div id="popupSendFlirt'.$key.'" class="popupList" style="display: none; margin-top:10px;margin-bottom:10px; margin-left:0px;  z-index: 100; background-color: #ffffff; width: 450px">

<div id="divHeadSpace" style="boder-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Skicka flört</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup(\'popupSendFlirt'.$key.'\');"><img src="'.$baseUrl.'/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src=\''.$baseUrl.'/img/kryss_edit_red.gif\'" onMouseOut="document.closeFriendPopup.src=\''.$baseUrl.'/img/kryss_edit.gif\'" style="margin: 10px" /></a></div>

&nbsp;</div>

<p style="margin: 4px; margin-left: 20px; margin-right: 20px;">Välj vilken typ av flört du vill skicka till <b>'.stripslashes($shoutArray[ $key ]["username"]).'</b>:</p>

<form method="post" action="http://www.flator.se/user/' . stripslashes($shoutArray[ $key ]["username"]) . '.html" style="margin: 4px; margin-left: 20px; margin-right: 20px; padding-bottom: 20px" name="flirtForm'.$key.'">
<input type="hidden" name="type" value="sendFlirt" />
<div style="display: inline; float: left; border:0px;">
<input type="radio" name="flirt" value="sexbomb" selected></div><div style="display: inline; float: left; border:0px;margin-left:20px;"><img src="'.$baseUrl.'/img/symbols/gif_purple/regler.gif" align="ABSMIDDLE" border="0" />&nbsp;&nbsp;&nbsp;Du är en sexbomb!</div>
<div style="clear:both;"></div>
<div style="display: inline; float: left; border:0px;">
<input type="radio" name="flirt" value="kastaankare" selected></div><div style="display: inline; float: left; border:0px; margin-left:20px;"><img src="'.$baseUrl.'/img/symbols/gif_purple/mig.gif" align="ABSMIDDLE" border="0" />&nbsp;&nbsp;&nbsp;Får jag kasta ankare hos dig?</div>
<div style="clear:both;"></div>
<div style="display: inline; float: left; border:0px;">
<input type="radio" name="flirt" value="klass" selected></div><div style="display: inline; float: left; border:0px; margin-left:20px;"><img src="'.$baseUrl.'/img/symbols/gif_purple/topplista_film.gif" align="ABSMIDDLE" border="0" />&nbsp;&nbsp;&nbsp;Dig är det klass på!</div>
<div style="clear:both;"></div>
<div style="display: inline; float: left; border:0px;">
<input type="radio" name="flirt" value="drink" selected></div><div style="display: inline; float: left; border:0px; margin-left:20px;"><img src="'.$baseUrl.'/img/symbols/gif_purple/typ_av_event.gif" align="ABSMIDDLE" border="0" />&nbsp;&nbsp;&nbsp;Dig skulle jag kunna ta en drink med!</div>
<div style="clear:both;"></div>
<div style="display: inline; float: left; border:0px;">
<input type="radio" name="flirt" value="message" selected></div><div style="display: inline; float: left; border:0px; margin-left:20px;"><img src="'.$baseUrl.'/img/symbols/gif_purple/skicka_flort.gif" style="vertical-align:middle;" border="0">&nbsp;&nbsp;&nbsp;<input type="text" name="message" value="Ange ett eget flört-mess!" style="width:170px;" onfocus="changeValueTemp(this);" onblur="changeValueTemp(this);"></div>
<div style="clear:both;"></div><br><br>
<span onMouseOver="document.sendFlirtsubmit'.$key.'.src=\''.$baseUrl.'/img/symbols/gif_red/skicka.gif\'" onMouseOut="document.sendFlirtsubmit'.$key.'.src=\''.$baseUrl.'/img/symbols/gif_purple/skicka.gif\'"><nobr><a href="#noexist" onClick="document.flirtForm'.$key.'.submit();"><img src="'.$baseUrl.'/img/symbols/gif_purple/skicka.gif" name="sendFlirtsubmit'.$key.'" align="ABSMIDDLE" border="0" />Skicka flört</a></nobr></span>
</form>
</div>';
	}
}










$body.= "
</p>

</div>

<div id=\"right\">";

	$body.= rightMenu('frontpage');
	$body.= "</div>";

}
?>