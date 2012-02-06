<?php

function rightMenu ( $menuType )
{
	global $currentLink, $baseUrl, $userProfile, $userPres, $albumPhotos, $DB, $albums, $unReadMessages, $currentAlbum, $newWall, $newFriends, $newsletter_thankyou, $newFlirts, $metaTitle, $friendsOnly, $displaySurveyBox, $usedImagesServerPaths;
	unset( $body );

	if ( $menuType == "inbox" )
	{
		$body = "
<table border=\"0\" width=\"100%\" id=\"subSearchBox\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>S&ouml;k <span style=\"font-weight: normal\">i inboxen</span></h3></div></td>
 </tr>
	<td align=\"left\" valign=\"bottom\">
	<form method=\"post\" style=\"margin: 0px; padding: 0px\">
		<ul id=\"topnav\"><li id=\"search\"><input type=\"text\" class=\"txtSearch\" name=\"mailSearchQuery\" value=\"\" style=\"width: 155px\">
<input type=\"submit\" name=\"mailSearch\" value=\"\" class=\"btnSearch\"></li></ul>

	</form>
	</td>
 </tr>
</table>";
 /*
	$body.= "
<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Sortera <span style=\"font-weight: normal\">meddelanden</span></h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";

		if ( $currentLink["unRead"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/inbox.html?offset=" . (int)$_GET["offset"] . "&sortBy=unRead\"" . $currentLink["unRead"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/mejl_som_ar_nytt.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesUnread\" style=\"padding-left: 5px; padding-right: 5px\">&nbsp;&nbsp;Olästa</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesUnread.src='img/symbols/gif_red/mejl_som_ar_nytt.gif'\" onMouseOut=\"document.sortMessagesUnread.src='img/symbols/gif_purple/mejl_som_ar_nytt.gif'\"><a href=\"" . $baseUrl . "/inbox.html?offset=" . (int)$_GET["offset"] . "&sortBy=unRead\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/mejl_som_ar_nytt.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesUnread\" style=\"padding-left: 5px; padding-right: 5px\">&nbsp;&nbsp;Olästa</a></span></td>
 </tr>";
		}

		if ( $currentLink["username"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/inbox.html?offset=" . (int)$_GET["offset"] . "&sortBy=username\"" . $currentLink["username"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/namn.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesUsername\">&nbsp;&nbsp;Namn</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesUsername.src='img/symbols/gif_red/namn.gif'\" onMouseOut=\"document.sortMessagesUsername.src='img/symbols/gif_purple/namn.gif'\"><a href=\"" . $baseUrl . "/inbox.html?offset=" . (int)$_GET["offset"] . "&sortBy=username\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/namn.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesUsername\">&nbsp;&nbsp;Namn</a></span></td>
 </tr>";
		}

		if ( $currentLink["date"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/inbox.html?offset=" . (int)$_GET["offset"] . "\"" . $currentLink["date"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/datum.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Datum</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesDate.src='img/symbols/gif_red/datum.gif'\" onMouseOut=\"document.sortMessagesDate.src='img/symbols/gif_purple/datum.gif'\"><a href=\"" . $baseUrl . "/inbox.html?offset=" . (int)$_GET["offset"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/datum.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Datum</a></span></td>
 </tr>";
		}
		

		$body.= "
</table>";
*/
	}

	if ( $menuType == "outbox" )
	{
		$body = "
<table border=\"0\" width=\"100%\" id=\"subSearchBox\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>S&ouml;k <span style=\"font-weight: normal\">i utboxen</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	<form method=\"post\" style=\"margin: 0px; padding: 0px\">
		<ul id=\"topnav\"><li id=\"search\"><input type=\"text\" class=\"txtSearch\" name=\"mailSearchQuery\" value=\"\" style=\"width: 155px\">
<input type=\"submit\" name=\"mailSearch\" value=\"\" class=\"btnSearch\"></li></ul>

	</form>
	</td>
 </tr>
</table>";
	$body.= "
<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Sortera <span style=\"font-weight: normal\">meddelanden</span></h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
		if ( $currentLink["username"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/outbox.html?offset=" . (int)$_GET["offset"] . "&sortBy=username\"" . $currentLink["username"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/namn.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesUsername\">&nbsp;&nbsp;Namn</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesUsername.src='img/symbols/gif_red/namn.gif'\" onMouseOut=\"document.sortMessagesUsername.src='img/symbols/gif_purple/namn.gif'\"><a href=\"" . $baseUrl . "/outbox.html?offset=" . (int)$_GET["offset"] . "&sortBy=username\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/namn.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesUsername\">&nbsp;&nbsp;Namn</a></span></td>
 </tr>";
		}

		if ( $currentLink["date"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/outbox.html?offset=" . (int)$_GET["offset"] . "\"" . $currentLink["date"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/datum.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Datum</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesDate.src='img/symbols/gif_red/datum.gif'\" onMouseOut=\"document.sortMessagesDate.src='img/symbols/gif_purple/datum.gif'\"><a href=\"" . $baseUrl . "/outbox.html?offset=" . (int)$_GET["offset"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/datum.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Datum</a></span></td>
 </tr>";
		}

		$body.= "
</table>";
	}

	if ( $menuType == "read_message" )
	{

		$body.= "
<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Hantera <span style=\"font-weight: normal\">meddelande</span></h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 /*
		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.deleteMessage.src='" . $baseUrl . "/img/symbols/gif_red/radera.gif'\" onMouseOut=\"document.deleteMessage.src='" . $baseUrl . "/img/symbols/gif_purple/radera.gif'\"><a href=\"" . $baseUrl . "/delete_message.html?messageId=" .  $_GET["messageId"] . "&returnTo=" .  $_GET["type"] . "\" OnClick=\"if(confirm('Radera meddelandet?')) { document.location=this.href; } else { return false; }\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/radera.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"deleteMessage\" style=\"padding-left: 5px; padding-right: 5px\">&nbsp;&nbsp;Radera</a></span></td></tr>";
*/
	$body .= "
 <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/report.html?type=message&username=" .  $_GET["username"] . "&returnTo=" .  $_GET["type"] . "\" OnClick=\"if(confirm('Anm&auml;l konversationen?')) { document.location=this.href; } else { return false; }\" style=\"font-weight: normal\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>!</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Anm&auml;l</a></td></tr>
	</table>";
	}

	if ( $menuType == "friends" )
	{
		$body = "
<table border=\"0\" width=\"100%\" id=\"subSearchBox\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>S&ouml;k <span style=\"font-weight: normal\">bland v&auml;nner</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	<form method=\"post\" style=\"margin: 0px; padding: 0px\" action=\"" . $baseUrl . "/friends.html\">
		<ul id=\"topnav\"><li id=\"search\"><input type=\"text\" class=\"txtSearch\" name=\"friendSearchQuery\" style=\"width: 155px\">
<input type=\"submit\" name=\"friendSearch\" value=\"\" class=\"btnSearch\"></li></ul>

	</form>
	</td>
 </tr>
</table>";
	}

	if ( $menuType == "userFriends" )
	{
		$body = "
<table border=\"0\" width=\"100%\" id=\"subSearchBox\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>S&ouml;k <span style=\"font-weight: normal\">bland v&auml;nner</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	<form method=\"post\" style=\"margin: 0px; padding: 0px\" action=\"" . $baseUrl . "/friends/" . stripslashes( $_GET["username"] ) . ".html\">
		<ul id=\"topnav\"><li id=\"search\"><input type=\"text\" class=\"txtSearch\" name=\"friendSearchQuery\" style=\"width: 155px\">
<input type=\"submit\" name=\"friendSearch\" value=\"\" class=\"btnSearch\"></li></ul>

	</form>
	</td>
 </tr>
</table>";
	}


#	$topRightRow = array("new_message" => TRUE,
##						 "read_message" => TRUE,
#						 "userPresentation" => TRUE
##						 "frontpage" => TRUE,
##						 "userPresentation" => TRUE
#						);
#
#	if ( $topRightRow[ $menuType ] == TRUE )
#	{
#		$body.= "<div style=\"padding-top: 0px;\">&nbsp;</div>";
#	}

	if ( $menuType == "new_message" )
	{
		$body.= "<div style=\"padding-top: 0px; line-height: 12px\">&nbsp;</div>";
	}
	if ( $menuType == "presentation" )
	{
		$body.= "<div style=\"padding-top: 0px; line-height: 16px\">&nbsp;</div>";
	}
		if ( $menuType == "blog" )
	{
		$body.= "<div style=\"padding-top: 0px; line-height: 16px\">&nbsp;</div>";

			$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Blogg</h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
		
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.blogg_inlagg.src='" . $baseUrl . "/img/symbols/gif_red/blogg_inlagg.gif'\" onMouseOut=\"document.blogg_inlagg.src='" . $baseUrl . "/img/symbols/gif_purple/blogg_inlagg.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupWriteBlog');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/blogg_inlagg.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"blogg_inlagg\">&nbsp;&nbsp;Nytt blogginlägg</a></span></td>
 </tr>";
					$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.koppla_bilder.src='" . $baseUrl . "/img/symbols/gif_red/ladda_upp_bild.gif'\" onMouseOut=\"document.koppla_bilder.src='" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupConnectPhotos');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"koppla_bilder\">&nbsp;&nbsp;Koppla bilder till blogginlägg</a></span></td>
 </tr>";



		$body.= "
</table>";
	}
		if ( $menuType == "userBlog" )
	{
		$body.= "<div style=\"padding-top: 0px; line-height: 16px\">&nbsp;</div>";
	}
		if ( $menuType == "myAccount" )
	{
		$body.= "<div style=\"padding-top: 0px; line-height: 16px\">&nbsp;</div>";
	}
			if ( $menuType == "topLists" )
	{
		$body.= "<div style=\"padding-top: 0px; line-height: 12px\">&nbsp;</div>";
	}
	if ( $menuType == "frontpage" || $menuType == "search" )
	{
		$body.= "<div style=\"padding-top: 0px; line-height: 12px\">&nbsp;</div>";
	}
	if ( $menuType == "events" )
	{
		$body.= "<div style=\"padding-top: 0px; line-height: 12px\">&nbsp;</div>";
	}

	if ( $menuType == "visitors" )
	{
		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Sortera <span style=\"font-weight: normal\">besökare</span></h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
		if ( $currentLink["username"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/visitors.html?offset=" . (int)$_GET["offset"] . "&sortBy=username\"" . $currentLink["username"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/van.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesUsername\">&nbsp;&nbsp;Namn</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesUsername.src='" . $baseUrl . "/img/symbols/gif_red/van.gif'\" onMouseOut=\"document.sortMessagesUsername.src='" . $baseUrl . "/img/symbols/gif_purple/van.gif'\"><a href=\"" . $baseUrl . "/visitors.html?offset=" . (int)$_GET["offset"] . "&sortBy=username\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/van.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesUsername\">&nbsp;&nbsp;Namn</a></span></td>
 </tr>";
		}

		if ( $currentLink["date"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/visitors.html?offset=" . (int)$_GET["offset"] . "\"" . $currentLink["date"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/datum.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Datum</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_red/datum.gif'\" onMouseOut=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_purple/datum.gif'\"><a href=\"" . $baseUrl . "/visitors.html?offset=" . (int)$_GET["offset"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/datum.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Datum</a></span></td>
 </tr>";
		}

		if ( $currentLink["visits"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/visitors.html?offset=" . (int)$_GET["offset"] . "&sortBy=visits\"" . $currentLink["visits"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/antal_besok.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesVisits\">&nbsp;&nbsp;Antal besök</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesVisits.src='" . $baseUrl . "/img/symbols/gif_red/antal_besok.gif'\" onMouseOut=\"document.sortMessagesVisits.src='" . $baseUrl . "/img/symbols/gif_purple/antal_besok.gif'\"><a href=\"" . $baseUrl . "/visitors.html?offset=" . (int)$_GET["offset"] . "&sortBy=visits\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/antal_besok.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesVisits\">&nbsp;&nbsp;Antal besök</a></span></td>
 </tr>";
		}

		$body.= "
</table>";
	}

	if ( $menuType == "userPresentation" )
	{
		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 16px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Hos <span style=\"font-weight: normal\">" . stripslashes( $userPres["username"] ) . "</span></h3></div></td>
 </tr>";
 
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sendMessUser.src='" . $baseUrl . "/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.sendMessUser.src='" . $baseUrl . "/img/symbols/gif_purple/skicka.gif'\"><a href=\"" . $baseUrl . "/new_message.html?userId=" . (int)$userPres["id"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sendMessUser\">&nbsp;&nbsp;Skicka mess</a></span></td>
 </tr>";
		if ( isCurrentFriend ( (int)$_SESSION["userId"], (int)$userPres["id"] ) == FALSE )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.becomeFriend.src='" . $baseUrl . "/img/symbols/gif_red/van.gif'\" onMouseOut=\"document.becomeFriend.src='" . $baseUrl . "/img/symbols/gif_purple/van.gif'\"><a href=\"#noexist\" onclick=\"showPopup('popupAddFriend');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/van.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"becomeFriend\">&nbsp;&nbsp;Bli vän med</a></span></td>
 </tr>";
		}

		$body.= "
</table>";
	}







	if ( $menuType == "userMedia" )
	{
		/*
		$body = "
<table border=\"0\" width=\"100%\" id=\"subSearchBox\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>S&ouml;k <span style=\"font-weight: normal\">i alla album</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	<form method=\"post\" style=\"margin: 0px; padding: 0px\" action=\"" . $baseUrl . "/media/".$userPres["username"].".html\">
		<ul id=\"right_searchnav\"><li id=\"search\"><input type=\"text\" class=\"txtSearch\" name=\"albumSearchQuery\" value=\"S&ouml;k i alla album\" onfocus=\"changeValueTemp(this);\" onblur=\"changeValueTemp(this);\" style=\"width: 160px\">
<input type=\"submit\" name=\"albumSearch\" value=\"\" class=\"btnSearch\"></li></ul>

	</form>
	</td>
 </tr>
</table>";
*/

		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Sortera <span style=\"font-weight: normal\">album</span></h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
		if ( $currentLink["desc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/media/".$userPres["username"].".html?offset=" . (int)$_GET["offset"] . "\"" . $currentLink["desc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_red/nyast.gif'\" onMouseOut=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_purple/nyast.gif'\"><a href=\"" . $baseUrl . "/media/".$userPres["username"].".html?offset=" . (int)$_GET["offset"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}

		if ( $currentLink["asc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/media/".$userPres["username"].".html?offset=" . (int)$_GET["offset"] . "&sortBy=asc\"" . $currentLink["asc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_red/aldst.gif'\" onMouseOut=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_purple/aldst.gif'\"><a href=\"" . $baseUrl . "/media/".$userPres["username"].".html?offset=" . (int)$_GET["offset"] . "&sortBy=asc\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}

		if ( $currentLink["visits"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/media/".$userPres["username"].".html?offset=" . (int)$_GET["offset"] . "&sortBy=visits\"" . $currentLink["visits"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif'\" onMouseOut=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif'\"><a href=\"" . $baseUrl . "/media/".$userPres["username"].".html?offset=" . (int)$_GET["offset"] . "&sortBy=visits\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}

		$body.= "
</table>";




		



		$body.= "
</table>";



	}









	if ( $menuType == "userPartyMedia" )
	{
		/*
		$body = "
<table border=\"0\" width=\"100%\" id=\"subSearchBox\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>S&ouml;k <span style=\"font-weight: normal\">i alla album</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	<form method=\"post\" style=\"margin: 0px; padding: 0px\" action=\"" . $baseUrl . "/media/".$userPres["username"].".html\">
		<ul id=\"right_searchnav\"><li id=\"search\"><input type=\"text\" class=\"txtSearch\" name=\"albumSearchQuery\" value=\"S&ouml;k i alla album\" onfocus=\"changeValueTemp(this);\" onblur=\"changeValueTemp(this);\" style=\"width: 160px\">
<input type=\"submit\" name=\"albumSearch\" value=\"\" class=\"btnSearch\"></li></ul>

	</form>
	</td>
 </tr>
</table>";
*/

		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Sortera <span style=\"font-weight: normal\">album</span></h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
		if ( $currentLink["desc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "\"" . $currentLink["desc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_red/nyast.gif'\" onMouseOut=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_purple/nyast.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}

		if ( $currentLink["asc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=asc\"" . $currentLink["asc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_red/aldst.gif'\" onMouseOut=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_purple/aldst.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=asc\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}

		if ( $currentLink["visits"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=visits\"" . $currentLink["visits"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif'\" onMouseOut=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=visits\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}

		$body.= "
</table>";




		



		$body.= "
</table>";



	}










	if ( $menuType == "media" )
	{
		/*
		$body = "
<table border=\"0\" width=\"100%\" id=\"subSearchBox\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>S&ouml;k <span style=\"font-weight: normal\">i alla album</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	<form method=\"post\" style=\"margin: 0px; padding: 0px\" action=\"" . $baseUrl . "/media/".$userPres["username"].".html\">
		<ul id=\"right_searchnav\"><li id=\"search\"><input type=\"text\" class=\"txtSearch\" name=\"albumSearchQuery\" value=\"S&ouml;k i alla album\" onfocus=\"changeValueTemp(this);\" onblur=\"changeValueTemp(this);\" style=\"width: 160px\">
<input type=\"submit\" name=\"albumSearch\" value=\"\" class=\"btnSearch\"></li></ul>

	</form>
	</td>
 </tr>
</table>";
*/

		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Sortera <span style=\"font-weight: normal\">album</span></h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
		if ( $currentLink["desc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/media.html?offset=" . (int)$_GET["offset"] . "\"" . $currentLink["desc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_red/nyast.gif'\" onMouseOut=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_purple/nyast.gif'\"><a href=\"" . $baseUrl . "/media.html?offset=" . (int)$_GET["offset"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}

		if ( $currentLink["asc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/media.html?offset=" . (int)$_GET["offset"] . "&sortBy=asc\"" . $currentLink["asc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_red/aldst.gif'\" onMouseOut=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_purple/aldst.gif'\"><a href=\"" . $baseUrl . "/media.html?offset=" . (int)$_GET["offset"] . "&sortBy=asc\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}

		if ( $currentLink["visits"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"" . $baseUrl . "/media.html?offset=" . (int)$_GET["offset"] . "&sortBy=visits\"" . $currentLink["visits"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif'\" onMouseOut=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif'\"><a href=\"" . $baseUrl . "/media.html?offset=" . (int)$_GET["offset"] . "&sortBy=visits\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}

		$body.= "
</table>";



	$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Bild & Film</h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 reset( $albums );
	if ( count( $albums ) > 0 )
	{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.ladda_upp_bild2.src='" . $baseUrl . "/img/symbols/gif_red/ladda_upp_bild.gif'\" onMouseOut=\"document.ladda_upp_bild2.src='" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupUploadPhoto2');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"ladda_upp_bild2\">&nbsp;&nbsp;Ladda upp bilder & film</a></span></td>
 </tr>";
	} else {
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.ladda_upp_bild2.src='" . $baseUrl . "/img/symbols/gif_red/ladda_upp_bild.gif'\" onMouseOut=\"document.ladda_upp_bild2.src='" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupAddAlbum');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"ladda_upp_bild2\">&nbsp;&nbsp;Ladda upp bilder & film</a></span></td>
 </tr>";
	}






		$body.= "
</table>";



	}

	if ( $menuType == "album" )
	{
	$numPerPage = 9;
		if ( count( $albumPhotos ) > 0 )
		{
					$albumPhotosString = "";
					$i = 1;
					$iOff = (int)$_GET["offset"];
					$i2 = 0;
			while ( list( $key, $value ) = each( $albumPhotos ) )
			{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;
			
			$iOff++;
			
			
				if ( strlen( $albumPhotos[ $key ]["serverLocation"] ) > 0 )
				{	
					/*
					if ($albumPhotos[ $key ][ "current" ] == TRUE) {
					$thumbsize = "small_current";
					$thumbPixelSize = 65;
					$borderString = "2px solid #E54F35";
					} else {
					$thumbsize = "small";
					$thumbPixelSize = 69;
					$borderString = "none";
					}
					$albumPhotosString .= '<a href="http://www.flator.se/media/photos/'.$albumPhotos[ $key ]["id"].'.html">';
					if (($i % 3) == 0) {
					$albumPhotosString .= "<img src=\"http://www.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/".$thumbsize."/\" border=\"0\" width=\"".$thumbPixelSize."px\" height=\"".$thumbPixelSize."px\" style=\"margin-right:0px; margin-bottom:4px; border: ".$borderString.";\"><br>";
					} else {
					$albumPhotosString .= "<img src=\"http://www.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/".$thumbsize."/\" border=\"0\" width=\"".$thumbPixelSize."px\" height=\"".$thumbPixelSize."px\" style=\"margin-right:4px; margin-bottom:4px; border: ".$borderString.";\">";
					}
					$albumPhotosString .= '</a>';
					*/
					if ($albumPhotos[ $key ][ "current" ] == TRUE) {
					$hoverAction = "";
					$thumbcss = "<div class=\"thumbs_currImage\"/></div>";
					} else {
						$hoverAction = " onMouseOver=\"document.getElementById( 'hover".$key."').style.display='block'\" onMouseOut=\"document.getElementById( 'hover".$key."').style.display='none';\"";
					$thumbcss = "<div class=\"thumbs_hoverImage\" style=\"display:none\" id=\"hover".$key."\"></div>";
					}


					$albumPhotosString .= '<a href="'.$baseUrl.'/media/photos/'.$albumPhotos[ $key ]["id"].'.html?offset=' . (int)$_GET["offset"] . "&sortBy=" . $_GET["sortBy"] . '">';
					if (($i % 3) == 0) {
					$albumPhotosString .= "<div class=\"thumbs_Image\" style=\"background: transparent url(".$baseUrl."/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/small/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; margin-right:0px; margin-bottom:4px;\"".$hoverAction.">".$thumbcss."</div><br>";
					} else {
					$albumPhotosString .= "<div class=\"thumbs_Image\" style=\"background: transparent url(".$baseUrl."/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/small/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;margin-right:4px; margin-bottom:4px;\"".$hoverAction.">".$thumbcss."</div>";
					}
					$albumPhotosString .= '</a>';
				}
				else
				{
					$albumPhotosString = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/grupp_avantar_liten.gif\" border=\"0\" width=\"26\" height=\"29\">";
				}

				$i++;
				$printed++;
			}
						// Paging
						$albumPhotosString.= "<div style=\"clear:both;\"></div>";
			if ( count( $albumPhotos ) > $numPerPage )
			{
				if ( (int)$_GET["offset"] > 0 )
				{
					$albumPhotosString.= "<div id=\"previous\"><span onMouseOver=\"document.prevAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_red/pil_vanster.gif'\" onMouseOut=\"document.prevAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_purple/pil_vanster.gif'\"><a href=\"" . $baseUrl . "/media/album/".(int)$currentAlbum["id"].".html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&sortBy=" . $_GET["sortBy"] . "\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/pil_vanster.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"prevAlbumPhotosView\">&nbsp;Bakåt</a></span></div>";
				}
				else
				{
					$albumPhotosString.= "<div id=\"previous\">&nbsp;</div>\n";
				}
				$albumPhotosString.= "<div id=\"middle\" style=\"text-align: center\"><b>".((int)$_GET["offset"]+1)." - " . ($printed+((int)$_GET["offset"])) . "</b> av <b>". count( $albumPhotos ) . "</b></div>\n";
				if ( $iOff < count( $albumPhotos ) )
				{
					$albumPhotosString.= "<div id=\"next\"><span onMouseOver=\"document.nextAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_red/pil_hoger.gif'\" onMouseOut=\"document.nextAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_purple/pil_hoger.gif'\"><a href=\"" . $baseUrl . "/media/album/".(int)$currentAlbum["id"].".html?offset=" . $iOff . "&sortBy=" . $_GET["sortBy"] . "\">Framåt&nbsp;<img src=\"" . $baseUrl . "/img/symbols/gif_purple/pil_hoger.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"nextAlbumPhotosView\"></a></span></div>";
				}			}
			else
			{
				$albumPhotosString.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>1 - " .  $printed  . "</b> av <b>" . count( $albumPhotos ) . "</b></div>\n";		
			}

		} else {
					if ($friendsOnly == TRUE) {
					$albumPhotosString = "<b>Endast vänner till ".$userPres["username"]." får se detta album och bilderna det innehåller.</b>";

					} else {
					$albumPhotosString = "Det finns inga bilder i albumet än.";
					}

		}


/*
		$body = "
<table border=\"0\" width=\"100%\" id=\"subSearchBox\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>S&ouml;k <span style=\"font-weight: normal\">i alla album</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	<form method=\"post\" style=\"margin: 0px; padding: 0px\" action=\"" . $baseUrl . "/media.html\">
			<ul id=\"right_searchnav\"><li id=\"search\"><input type=\"text\" class=\"txtSearch\" name=\"albumSearchQuery\" value=\"S&ouml;k i alla album\" onfocus=\"changeValueTemp(this);\" onblur=\"changeValueTemp(this);\" style=\"width: 160px\">
<input type=\"submit\" name=\"albumSearch\" value=\"\" class=\"btnSearch\"></li></ul>

	</form>
	</td>
 </tr>
</table>";
*/
		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Denna bild / film</h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 

 
		 			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.kopplatavling.src='" . $baseUrl . "/img/symbols/gif_red/snygging.gif'\" onMouseOut=\"document.kopplatavling.src='" . $baseUrl . "/img/symbols/gif_purple/snygging.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupAddToChallenge');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/snygging.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"kopplatavling\">&nbsp;&nbsp;Delta i tävling</a></span></td>
 </tr>";

		

 
 			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.kopplablogg.src='" . $baseUrl . "/img/symbols/gif_red/blogg.gif'\" onMouseOut=\"document.kopplablogg.src='" . $baseUrl . "/img/symbols/gif_purple/blogg.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupAddToBlog');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/blogg.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"kopplablogg\">&nbsp;&nbsp;Koppla till blogginlägg</a></span></td>
 </tr>";

	$body .= "
<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Bild & film <span style=\"font-weight: normal\">i detta album</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	".$albumPhotosString."
	</td>
 </tr>
</table>";

	

		$body.= "
</table>";

		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Sortera <span style=\"font-weight: normal\">album</span></h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
		if ( $currentLink["desc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "\"" . $currentLink["desc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_red/nyast.gif'\" onMouseOut=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_purple/nyast.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}

		if ( $currentLink["asc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=asc\"" . $currentLink["asc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_red/aldst.gif'\" onMouseOut=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_purple/aldst.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=asc\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}

		if ( $currentLink["visits"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=visits\"" . $currentLink["visits"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif'\" onMouseOut=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=visits\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}

		$body.= "
</table>";
$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Bild & Film</h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.ladda_upp_bild2.src='" . $baseUrl . "/img/symbols/gif_red/ladda_upp_bild.gif'\" onMouseOut=\"document.ladda_upp_bild2.src='" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupUploadPhoto2');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"ladda_upp_bild2\">&nbsp;&nbsp;Ladda upp bilder & film</a></span></td>
 </tr>";



		



		$body.= "
</table>";
	}

	if ( $menuType == "userAlbum" )
	{
		$numPerPage = 9;
		if ( count( $albumPhotos ) > 0 )
		{
					$albumPhotosString = "";
					$i = 1;
					$iOff = (int)$_GET["offset"];
					$i2 = 0;
			while ( list( $key, $value ) = each( $albumPhotos ) )
			{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;
			
			$iOff++;
			
			
				if ( strlen( $albumPhotos[ $key ]["serverLocation"] ) > 0 )
				{	
					/*
					if ($albumPhotos[ $key ][ "current" ] == TRUE) {
					$thumbsize = "small_current";
					$thumbPixelSize = 65;
					$borderString = "2px solid #E54F35";
					} else {
					$thumbsize = "small";
					$thumbPixelSize = 69;
					$borderString = "none";
					}
					$albumPhotosString .= '<a href="http://www.flator.se/media/photos/'.$albumPhotos[ $key ]["id"].'.html">';
					if (($i % 3) == 0) {
					$albumPhotosString .= "<img src=\"http://www.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/".$thumbsize."/\" border=\"0\" width=\"".$thumbPixelSize."px\" height=\"".$thumbPixelSize."px\" style=\"margin-right:0px; margin-bottom:4px; border: ".$borderString.";\"><br>";
					} else {
					$albumPhotosString .= "<img src=\"http://www.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/".$thumbsize."/\" border=\"0\" width=\"".$thumbPixelSize."px\" height=\"".$thumbPixelSize."px\" style=\"margin-right:4px; margin-bottom:4px; border: ".$borderString.";\">";
					}
					$albumPhotosString .= '</a>';
					*/
					if ($albumPhotos[ $key ][ "current" ] == TRUE) {
					$hoverAction = "";
					$thumbcss = "<div class=\"thumbs_currImage\"/></div>";
					} else {
						$hoverAction = " onMouseOver=\"document.getElementById( 'hover".$key."').style.display='block'\" onMouseOut=\"document.getElementById( 'hover".$key."').style.display='none';\"";
					$thumbcss = "<div class=\"thumbs_hoverImage\" style=\"display:none\" id=\"hover".$key."\"></div>";
					}


					$albumPhotosString .= '<a href="'.$baseUrl.'/media/photos/'.$albumPhotos[ $key ]["id"].'.html?offset=' . (int)$_GET["offset"] . "&sortBy=" . $_GET["sortBy"] . '">';
					if (($i % 3) == 0) {
					$albumPhotosString .= "<div class=\"thumbs_Image\" style=\"background: transparent url(".$baseUrl."/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/small/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; margin-right:0px; margin-bottom:4px;\"".$hoverAction.">".$thumbcss."</div><br>";
					} else {
					$albumPhotosString .= "<div class=\"thumbs_Image\" style=\"background: transparent url(".$baseUrl."/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/small/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;margin-right:4px; margin-bottom:4px;\"".$hoverAction.">".$thumbcss."</div>";
					}
					$albumPhotosString .= '</a>';
				}
				else
				{
					$albumPhotosString = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/grupp_avantar_liten.gif\" border=\"0\" width=\"26\" height=\"29\">";
				}

				$i++;
				$printed++;
			}
						// Paging
						$albumPhotosString.= "<div style=\"clear:both;\"></div>";
			if ( count( $albumPhotos ) > $numPerPage )
			{
				if ( (int)$_GET["offset"] > 0 )
				{
			

					
					$albumPhotosString.= "<div id=\"previous\"><span onMouseOver=\"document.prevAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_red/pil_vanster.gif'\" onMouseOut=\"document.prevAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_purple/pil_vanster.gif'\"><a href=\"" . $baseUrl . "/media/album/".(int)$currentAlbum["id"].".html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&sortBy=" . $_GET["sortBy"] . "\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/pil_vanster.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"prevAlbumPhotosView\">&nbsp;Bakåt</a></span></div>";

					//$albumPhotosString.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/media/album/".(int)$currentAlbum["id"].".html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&sortBy=" . $_GET["sortBy"] . "\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/pil_vanster.gif\" name=\"prevAlbumPhotosView\" border=\"0\" onMouseOver=\"document.prevAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_red/pil_vanster.gif'\" onMouseOut=\"document.prevAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_purple/pil_vanster.gif'\"  style=\"vertical-align:middle;\">&nbsp;Bakåt</a></div>";
				}
				else
				{
					$albumPhotosString.= "<div id=\"previous\">&nbsp;</div>\n";
				}
				$albumPhotosString.= "<div id=\"middle\" style=\"text-align: center\"><b>".((int)$_GET["offset"]+1)." - " . ($printed+((int)$_GET["offset"])) . "</b> av <b>". count( $albumPhotos ) . "</b></div>\n";
				if ( $iOff < count( $albumPhotos ) )
				{
					//$albumPhotosString.= "<div id=\"next\"><a href=\"" . $baseUrl . "/media/album/".(int)$currentAlbum["id"].".html?offset=" . $iOff . "&sortBy=" . $_GET["sortBy"] . "\">Framåt&nbsp;<img src=\"" . $baseUrl . "/img/symbols/gif_purple/pil_hoger.gif\" name=\"nextAlbumPhotosView\" border=\"0\" onMouseOver=\"document.nextAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_red/pil_hoger.gif'\" onMouseOut=\"document.nextAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_purple/pil_hoger.gif'\"  style=\"vertical-align:middle;\"></a></div>";

					$albumPhotosString.= "<div id=\"next\"><span onMouseOver=\"document.nextAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_red/pil_hoger.gif'\" onMouseOut=\"document.nextAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_purple/pil_hoger.gif'\"><a href=\"" . $baseUrl . "/media/album/".(int)$currentAlbum["id"].".html?offset=" . $iOff . "&sortBy=" . $_GET["sortBy"] . "\">Framåt&nbsp;<img src=\"" . $baseUrl . "/img/symbols/gif_purple/pil_hoger.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"nextAlbumPhotosView\"></a></span></div>";
				}
			}
			else
			{
				$albumPhotosString.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>1 - " .  $printed  . "</b> av <b>" . count( $albumPhotos ) . "</b></div>\n";		
			}

		} else {
										if ($friendsOnly == TRUE) {
					$albumPhotosString = "<b>Endast vänner till ".$userPres["username"]." får se detta album och bilderna det innehåller.</b>";

					} else {
					$albumPhotosString = "Det finns inga bilder i albumet än.";
					}

		}



/*
		$body = "
<table border=\"0\" width=\"100%\" id=\"subSearchBox\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>S&ouml;k <span style=\"font-weight: normal\">i alla album</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	<form method=\"post\" style=\"margin: 0px; padding: 0px\" action=\"" . $baseUrl . "/media.html\">
			<ul id=\"right_searchnav\"><li id=\"search\"><input type=\"text\" class=\"txtSearch\" name=\"albumSearchQuery\" value=\"S&ouml;k i alla album\" onfocus=\"changeValueTemp(this);\" onblur=\"changeValueTemp(this);\" style=\"width: 160px\">
<input type=\"submit\" name=\"albumSearch\" value=\"\" class=\"btnSearch\"></li></ul>

	</form>
	</td>
 </tr>
</table>";
*/
		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Denna bild / film</h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
	if ($_SESSION["rights"] > 4) {
 
		 			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.kopplatavling.src='" . $baseUrl . "/img/symbols/gif_red/snygging.gif'\" onMouseOut=\"document.kopplatavling.src='" . $baseUrl . "/img/symbols/gif_purple/snygging.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupAddToChallenge');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/snygging.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"kopplatavling\">&nbsp;&nbsp;Delta i tävling</a></span></td>
 </tr>";
}
 
		/*
		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.lamna_kommentar.src='" . $baseUrl . "/img/symbols/gif_red/lamna_kommentar.gif'\" onMouseOut=\"document.lamna_kommentar.src='" . $baseUrl . "/img/symbols/gif_purple/lamna_kommentar.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupComment');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/lamna_kommentar.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"lamna_kommentar\">&nbsp;&nbsp;Lämna kommentar</a></span></td>
 </tr>";
 */
 			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.kopplablogg.src='" . $baseUrl . "/img/symbols/gif_red/blogg.gif'\" onMouseOut=\"document.kopplablogg.src='" . $baseUrl . "/img/symbols/gif_purple/blogg.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupAddToBlog');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/blogg.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"kopplablogg\">&nbsp;&nbsp;Koppla till blogginlägg</a></span></td>
 </tr>";



	$body .= "
<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Bild & film <span style=\"font-weight: normal\">i detta album</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	".$albumPhotosString."
	</td>
 </tr>
</table>";


		



		$body.= "
</table>";

		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Sortera <span style=\"font-weight: normal\">album</span></h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
		if ( $currentLink["desc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "\"" . $currentLink["desc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_red/nyast.gif'\" onMouseOut=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_purple/nyast.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}

		if ( $currentLink["asc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=asc\"" . $currentLink["asc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_red/aldst.gif'\" onMouseOut=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_purple/aldst.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=asc\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}

		if ( $currentLink["visits"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=visits\"" . $currentLink["visits"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif'\" onMouseOut=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=visits\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}

		$body.= "
</table>";
	}




if ( $menuType == "userPhoto" )
	{

		$numPerPage = 9;
		if ( count( $albumPhotos ) > 0 )
		{
					$albumPhotosString = "";
					$i = 1;
					$iOff = (int)$_GET["offset"];
					$i2 = 0;
			while ( list( $key, $value ) = each( $albumPhotos ) )
			{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;
			
			$iOff++;
			
			
				if ( strlen( $albumPhotos[ $key ]["serverLocation"] ) > 0 )
				{	
					/*
					if ($albumPhotos[ $key ][ "current" ] == TRUE) {
					$thumbsize = "small_current";
					$thumbPixelSize = 65;
					$borderString = "2px solid #E54F35";
					} else {
					$thumbsize = "small";
					$thumbPixelSize = 69;
					$borderString = "none";
					}
					$albumPhotosString .= '<a href="http://www.flator.se/media/photos/'.$albumPhotos[ $key ]["id"].'.html">';
					if (($i % 3) == 0) {
					$albumPhotosString .= "<img src=\"http://www.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/".$thumbsize."/\" border=\"0\" width=\"".$thumbPixelSize."px\" height=\"".$thumbPixelSize."px\" style=\"margin-right:0px; margin-bottom:4px; border: ".$borderString.";\"><br>";
					} else {
					$albumPhotosString .= "<img src=\"http://www.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/".$thumbsize."/\" border=\"0\" width=\"".$thumbPixelSize."px\" height=\"".$thumbPixelSize."px\" style=\"margin-right:4px; margin-bottom:4px; border: ".$borderString.";\">";
					}
					$albumPhotosString .= '</a>';
					*/
					if ($albumPhotos[ $key ][ "current" ] == TRUE) {
					$hoverAction = "";
					$thumbcss = "<div class=\"thumbs_currImage\"/></div>";
					} else {
						$hoverAction = " onMouseOver=\"document.getElementById( 'hover".$key."').style.display='block'\" onMouseOut=\"document.getElementById( 'hover".$key."').style.display='none';\"";
					$thumbcss = "<div class=\"thumbs_hoverImage\" style=\"display:none\" id=\"hover".$key."\"></div>";
					}


					$albumPhotosString .= '<a href="'.$baseUrl.'/media/photos/'.$albumPhotos[ $key ]["id"].'.html?offset=' . (int)$_GET["offset"] . "&sortBy=" . $_GET["sortBy"] . '">';
					if (($i % 3) == 0) {
					$albumPhotosString .= "<div class=\"thumbs_Image\" style=\"background: transparent url(".$baseUrl."/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/small/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; margin-right:0px; margin-bottom:4px;\"".$hoverAction.">".$thumbcss."</div><br>";
					} else {
					$albumPhotosString .= "<div class=\"thumbs_Image\" style=\"background: transparent url(".$baseUrl."/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/small/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;margin-right:4px; margin-bottom:4px;\"".$hoverAction.">".$thumbcss."</div>";
					}
					$albumPhotosString .= '</a>';
				}
				else
				{
					$albumPhotosString = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/grupp_avantar_liten.gif\" border=\"0\" width=\"26\" height=\"29\">";
				}

				$i++;
				$printed++;
			}
						// Paging
						$albumPhotosString.= "<div style=\"clear:both;\"></div>";
			if ( count( $albumPhotos ) > $numPerPage )
			{
				if ( (int)$_GET["offset"] > 0 )
				{
					$albumPhotosString.= "<div id=\"previous\"><span onMouseOver=\"document.prevAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_red/pil_vanster.gif'\" onMouseOut=\"document.prevAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_purple/pil_vanster.gif'\"><a href=\"" . $baseUrl . "/media/album/".(int)$currentAlbum["id"].".html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&sortBy=" . $_GET["sortBy"] . "\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/pil_vanster.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"prevAlbumPhotosView\">&nbsp;Bakåt</a></span></div>";
				}
				else
				{
					$albumPhotosString.= "<div id=\"previous\">&nbsp;</div>\n";
				}
				$albumPhotosString.= "<div id=\"middle\" style=\"text-align: center\"><b>".((int)$_GET["offset"]+1)." - " . ($printed+((int)$_GET["offset"])) . "</b> av <b>". count( $albumPhotos ) . "</b></div>\n";
				if ( $iOff < count( $albumPhotos ) )
				{
					$albumPhotosString.= "<div id=\"next\"><span onMouseOver=\"document.nextAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_red/pil_hoger.gif'\" onMouseOut=\"document.nextAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_purple/pil_hoger.gif'\"><a href=\"" . $baseUrl . "/media/album/".(int)$currentAlbum["id"].".html?offset=" . $iOff . "&sortBy=" . $_GET["sortBy"] . "\">Framåt&nbsp;<img src=\"" . $baseUrl . "/img/symbols/gif_purple/pil_hoger.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"nextAlbumPhotosView\"></a></span></div>";
				}			}
			else
			{
				$albumPhotosString.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>1 - " .  $printed  . "</b> av <b>" . count( $albumPhotos ) . "</b></div>\n";		
			}

		} else {
					if ($friendsOnly == TRUE) {
					$albumPhotosString = "<b>Endast vänner till ".$userPres["username"]." får se detta album och bilderna det innehåller.</b>";

					} else {
					$albumPhotosString = "Det finns inga bilder i albumet än.";
					}

		}

/*
		$body = "
<table border=\"0\" width=\"100%\" id=\"subSearchBox\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>S&ouml;k <span style=\"font-weight: normal\">i alla album</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	<form method=\"post\" style=\"margin: 0px; padding: 0px\" action=\"" . $baseUrl . "/media.html\">
			<ul id=\"right_searchnav\"><li id=\"search\"><input type=\"text\" class=\"txtSearch\" name=\"albumSearchQuery\" value=\"S&ouml;k i alla album\" onfocus=\"changeValueTemp(this);\" onblur=\"changeValueTemp(this);\" style=\"width: 160px\">
<input type=\"submit\" name=\"albumSearch\" value=\"\" class=\"btnSearch\"></li></ul>

	</form>
	</td>
 </tr>
</table>";
*/
		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Denna bild / film</h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
	if ($_SESSION["rights"] > 4) {
 
		 			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.kopplatavling.src='" . $baseUrl . "/img/symbols/gif_red/snygging.gif'\" onMouseOut=\"document.kopplatavling.src='" . $baseUrl . "/img/symbols/gif_purple/snygging.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupAddToChallenge');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/snygging.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"kopplatavling\">&nbsp;&nbsp;Delta i tävling</a></span></td>
 </tr>";
}
 
		/*
		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.lamna_kommentar.src='" . $baseUrl . "/img/symbols/gif_red/lamna_kommentar.gif'\" onMouseOut=\"document.lamna_kommentar.src='" . $baseUrl . "/img/symbols/gif_purple/lamna_kommentar.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupComment');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/lamna_kommentar.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"lamna_kommentar\">&nbsp;&nbsp;Lämna kommentar</a></span></td>
 </tr>";
 */
		
 			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.kopplablogg.src='" . $baseUrl . "/img/symbols/gif_red/blogg.gif'\" onMouseOut=\"document.kopplablogg.src='" . $baseUrl . "/img/symbols/gif_purple/blogg.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupAddToBlog');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/blogg.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"kopplablogg\">&nbsp;&nbsp;Koppla till blogginlägg</a></span></td>
 </tr>";



		$body.= "
</table>";


	$body .= "
<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Bild & film <span style=\"font-weight: normal\">i detta album</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	".$albumPhotosString."
	</td>
 </tr>
</table>";

		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Sortera <span style=\"font-weight: normal\">album</span></h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
	if ( $currentLink["desc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "\"" . $currentLink["desc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_red/nyast.gif'\" onMouseOut=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_purple/nyast.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}

		if ( $currentLink["asc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=asc\"" . $currentLink["asc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_red/aldst.gif'\" onMouseOut=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_purple/aldst.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=asc\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}

		if ( $currentLink["visits"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=visits\"" . $currentLink["visits"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif'\" onMouseOut=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=visits\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}

		$body.= "
</table>";
	}


if ( $menuType == "photo" )
	{



		
						$numPerPage = 9;
		if ( count( $albumPhotos ) > 0 )
		{
					$albumPhotosString = "";
					$i = 1;
					$iOff = (int)$_GET["offset"];
					$i2 = 0;
			while ( list( $key, $value ) = each( $albumPhotos ) )
			{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;
			
			$iOff++;
			
			
				if ( strlen( $albumPhotos[ $key ]["serverLocation"] ) > 0 )
				{	
					/*
					if ($albumPhotos[ $key ][ "current" ] == TRUE) {
					$thumbsize = "small_current";
					$thumbPixelSize = 65;
					$borderString = "2px solid #E54F35";
					} else {
					$thumbsize = "small";
					$thumbPixelSize = 69;
					$borderString = "none";
					}
					$albumPhotosString .= '<a href="http://www.flator.se/media/photos/'.$albumPhotos[ $key ]["id"].'.html">';
					if (($i % 3) == 0) {
					$albumPhotosString .= "<img src=\"http://www.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/".$thumbsize."/\" border=\"0\" width=\"".$thumbPixelSize."px\" height=\"".$thumbPixelSize."px\" style=\"margin-right:0px; margin-bottom:4px; border: ".$borderString.";\"><br>";
					} else {
					$albumPhotosString .= "<img src=\"http://www.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/".$thumbsize."/\" border=\"0\" width=\"".$thumbPixelSize."px\" height=\"".$thumbPixelSize."px\" style=\"margin-right:4px; margin-bottom:4px; border: ".$borderString.";\">";
					}
					$albumPhotosString .= '</a>';
					*/
					if ($albumPhotos[ $key ][ "current" ] == TRUE) {
					$hoverAction = "";
					$thumbcss = "<div class=\"thumbs_currImage\"/></div>";
					} else {
						$hoverAction = " onMouseOver=\"document.getElementById( 'hover".$key."').style.display='block'\" onMouseOut=\"document.getElementById( 'hover".$key."').style.display='none';\"";
					$thumbcss = "<div class=\"thumbs_hoverImage\" style=\"display:none\" id=\"hover".$key."\"></div>";
					}


					$albumPhotosString .= '<a href="'.$baseUrl.'/media/photos/'.$albumPhotos[ $key ]["id"].'.html?offset=' . (int)$_GET["offset"] . "&sortBy=" . $_GET["sortBy"] . '">';
					if (($i % 3) == 0) {
					$albumPhotosString .= "<div class=\"thumbs_Image\" style=\"background: transparent url(".$baseUrl."/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/small/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; margin-right:0px; margin-bottom:4px;\"".$hoverAction.">".$thumbcss."</div><br>";
					} else {
					$albumPhotosString .= "<div class=\"thumbs_Image\" style=\"background: transparent url(".$baseUrl."/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key ]["serverLocation"])) . "/small/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;margin-right:4px; margin-bottom:4px;\"".$hoverAction.">".$thumbcss."</div>";
					}
					$albumPhotosString .= '</a>';
				}
				else
				{
					$albumPhotosString = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/grupp_avantar_liten.gif\" border=\"0\" width=\"26\" height=\"29\">";
				}

				$i++;
				$printed++;
			}
						// Paging
						$albumPhotosString.= "<div style=\"clear:both;\"></div>";
			if ( count( $albumPhotos ) > $numPerPage )
			{
				if ( (int)$_GET["offset"] > 0 )
				{
					$albumPhotosString.= "<div id=\"previous\"><span onMouseOver=\"document.prevAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_red/pil_vanster.gif'\" onMouseOut=\"document.prevAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_purple/pil_vanster.gif'\"><a href=\"" . $baseUrl . "/media/album/".(int)$currentAlbum["id"].".html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&sortBy=" . $_GET["sortBy"] . "\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/pil_vanster.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"prevAlbumPhotosView\">&nbsp;Bakåt</a></span></div>";
				}
				else
				{
					$albumPhotosString.= "<div id=\"previous\">&nbsp;</div>\n";
				}
				$albumPhotosString.= "<div id=\"middle\" style=\"text-align: center\"><b>".((int)$_GET["offset"]+1)." - " . ($printed+((int)$_GET["offset"])) . "</b> av <b>". count( $albumPhotos ) . "</b></div>\n";
				if ( $iOff < count( $albumPhotos ) )
				{
					$albumPhotosString.= "<div id=\"next\"><span onMouseOver=\"document.nextAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_red/pil_hoger.gif'\" onMouseOut=\"document.nextAlbumPhotosView.src='" . $baseUrl . "/img/symbols/gif_purple/pil_hoger.gif'\"><a href=\"" . $baseUrl . "/media/album/".(int)$currentAlbum["id"].".html?offset=" . $iOff . "&sortBy=" . $_GET["sortBy"] . "\">Framåt&nbsp;<img src=\"" . $baseUrl . "/img/symbols/gif_purple/pil_hoger.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"nextAlbumPhotosView\"></a></span></div>";
				}			}
			else
			{
				$albumPhotosString.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>1 - " .  $printed  . "</b> av <b>" . count( $albumPhotos ) . "</b></div>\n";		
			}

		} else {
					if ($friendsOnly == TRUE) {
					$albumPhotosString = "<b>Endast vänner till ".$userPres["username"]." får se detta album och bilderna det innehåller.</b>";

					} else {
					$albumPhotosString = "Det finns inga bilder i albumet än.";
					}

		}



/*
		$body = "
<table border=\"0\" width=\"100%\" id=\"subSearchBox\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>S&ouml;k <span style=\"font-weight: normal\">i alla album</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	<form method=\"post\" style=\"margin: 0px; padding: 0px\" action=\"" . $baseUrl . "/media.html\">
			<ul id=\"right_searchnav\"><li id=\"search\"><input type=\"text\" class=\"txtSearch\" name=\"albumSearchQuery\" value=\"S&ouml;k i alla album\" onfocus=\"changeValueTemp(this);\" onblur=\"changeValueTemp(this);\" style=\"width: 160px\">
<input type=\"submit\" name=\"albumSearch\" value=\"\" class=\"btnSearch\"></li></ul>

	</form>
	</td>
 </tr>
</table>";
*/
		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Denna bild / film</h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";

 
		 			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.kopplatavling.src='" . $baseUrl . "/img/symbols/gif_red/snygging.gif'\" onMouseOut=\"document.kopplatavling.src='" . $baseUrl . "/img/symbols/gif_purple/snygging.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupAddToChallenge');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/snygging.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"kopplatavling\">&nbsp;&nbsp;Delta i tävling</a></span></td>
 </tr>";

 
		
		/*
		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.lamna_kommentar.src='" . $baseUrl . "/img/symbols/gif_red/lamna_kommentar.gif'\" onMouseOut=\"document.lamna_kommentar.src='" . $baseUrl . "/img/symbols/gif_purple/lamna_kommentar.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupComment');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/lamna_kommentar.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"lamna_kommentar\">&nbsp;&nbsp;Lämna kommentar</a></span></td>
 </tr>";
 */

 
		 			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.kopplablogg.src='" . $baseUrl . "/img/symbols/gif_red/blogg.gif'\" onMouseOut=\"document.kopplablogg.src='" . $baseUrl . "/img/symbols/gif_purple/blogg.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupAddToBlog');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/blogg.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"kopplablogg\">&nbsp;&nbsp;Koppla till blogginlägg</a></span></td>
 </tr>";



		$body.= "
</table>";
	$body .= "
<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px; margin-top: 12px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Bild & film <span style=\"font-weight: normal\">i detta album</span></h3></div></td>
 </tr>
 <tr>
	<td align=\"left\" valign=\"bottom\">
	".$albumPhotosString."
	</td>
 </tr>
</table>";

		$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Sortera <span style=\"font-weight: normal\">album</span></h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
	if ( $currentLink["desc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "\"" . $currentLink["desc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_red/nyast.gif'\" onMouseOut=\"document.sortMediaAsc.src='" . $baseUrl . "/img/symbols/gif_purple/nyast.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/nyast.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaAsc\">&nbsp;&nbsp;Nyast</a></span></td>
 </tr>";
		}

		if ( $currentLink["asc"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=asc\"" . $currentLink["asc"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_red/aldst.gif'\" onMouseOut=\"document.sortMediaOld.src='" . $baseUrl . "/img/symbols/gif_purple/aldst.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=asc\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/aldst.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMediaOld\">&nbsp;&nbsp;Äldst</a></span></td>
 </tr>";
		}

		if ( $currentLink["visits"] )
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=visits\"" . $currentLink["visits"] . "  style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}
		else
		{
			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif'\" onMouseOut=\"document.sortMessagesDate.src='" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif'\"><a href=\"?offset=" . (int)$_GET["offset"] . "&sortBy=visits\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sortMessagesDate\">&nbsp;&nbsp;Mest sedda</a></span></td>
 </tr>";
		}

		$body.= "
</table>";
$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3>Bild & Film</h3></div></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"img/kryss_edit.gif\" name=\"sortMessagesX\" border=\"0\" onMouseOver=\"document.sortMessagesX.src='img/kryss_edit_red.gif'\" onMouseOut=\"document.sortMessagesX.src='img/kryss_edit.gif'\"></a></div></td>-->
 </tr>";
 
		
	
 			$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.ladda_upp_bild2.src='" . $baseUrl . "/img/symbols/gif_red/ladda_upp_bild.gif'\" onMouseOut=\"document.ladda_upp_bild2.src='" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupUploadPhoto2');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"ladda_upp_bild2\">&nbsp;&nbsp;Ladda upp bilder & film</a></span></td>
 </tr>";
		



		$body.= "
</table>";
	}


	if ( $menuType != "index" )
	{
		$body.= "
<div id=\"popupReport\" class=\"popup\" style=\"display: none\">

<div id=\"divHeadSpace\" style=\"border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;\">

	<div style=\"float: left; display: block\"><h3>Rapportera till Flator.se</h3></div>
	<div style=\"float: right; display: block\"><a href=\"#\" onclick=\"closePopup('popupReport');\"><img src=\"".$baseUrl."/img/kryss_edit.gif\" name=\"closeFriendPopup\" border=\"0\" onMouseOver=\"document.closeFriendPopup.src='".$baseUrl."/img/kryss_edit_red.gif'\" onMouseOut=\"document.closeFriendPopup.src='".$baseUrl."/img/kryss_edit.gif'\" style=\"margin: 10px\"></a></div>

&nbsp;</div>

<form method=\"post\" enctype=\"multipart/form-data\" style=\"margin: 4px; margin-left: 30px; margin-right: 30px; padding-bottom: 20px\" name=\"reportAllForm\" action=\"".$baseUrl."/frontpage.html\">
<input type=\"hidden\" name=\"type\" value=\"reportAll\">
<input type=\"hidden\" name=\"content\" value=\"".$metaTitle."\">
<input type=\"hidden\" name=\"url\" value=\"".$baseUrl."".$_SERVER["REQUEST_URI"]."\">
<div style=\"float: left; width: 100px;\">Anledning:</div>


<div style=\"display: inline; float: left; \">
<textarea name=\"comment\" rows=\"4\" cols=\"50\" wrap=\"hard\" style=\"width: 350px; border: 0px; height:100px; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\"></textarea></div>

<div style=\"float:none;\"></div><br><br><br><br>

<br><br>
<span onMouseOver=\"document.addFriendSubmit.src='".$baseUrl."/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.addFriendSubmit.src='".$baseUrl."/img/symbols/gif_purple/skicka.gif'\"><nobr><a href=\"#noexist\" onClick=\"document.reportAllForm.submit();\"><img src=\"".$baseUrl."/img/symbols/gif_purple/skicka.gif\" name=\"addFriendSubmit\" style=\"vertical-align:middle;\" border=\"0\">Skicka in rapport</a></nobr></span>
</form>
</div>



<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;padding-bottom:4px;\"><h3>Mina <span style=\"font-weight: normal\">snabbl&auml;nkar</span></h3></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"" . $baseUrl . "/img/kryss_edit.gif\" name=\"quickLinksX\" border=\"0\" onMouseOver=\"document.quickLinksX.src='" . $baseUrl . "/img/kryss_edit_red.gif'\" onMouseOut=\"document.quickLinksX.src='" . $baseUrl . "/img/kryss_edit.gif'\"></a></td>-->
 </tr>";

 if ($userProfile["currentPoll"] == "0" && $displaySurveyBox != TRUE) {


 		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.omrostning.src='" . $baseUrl . "/img/symbols/gif_red/faq.gif'\" onMouseOut=\"document.omrostning.src='" . $baseUrl . "/img/symbols/gif_purple/faq.gif'\"><a href=\"" . $baseUrl . "/squeezebox/survey.php\" rel=\"boxed\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/faq.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"omrostning\">&nbsp;&nbsp;Omröstning</a></span></td>
 </tr>";

}









$shortStatus = truncate(stripslashes($userProfile["statusMessage"]), 19, "..", TRUE, TRUE);
$body .= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span id=\"updatedStatus\" onMouseOver=\"document.changeStatus.src='" . $baseUrl . "/img/symbols/gif_red/logga_in.gif'\" onMouseOut=\"document.changeStatus.src='" . $baseUrl . "/img/symbols/gif_purple/logga_in.gif'\"><a href=\"#noexist\" onClick=\"getContent('change_status.php?target=updatedStatus&type=onlyMessage');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/logga_in.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"changeStatus\">&nbsp;&nbsp;Status: " . $shortStatus . "</a></span></td>
 </tr>";
 		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.anmal_.src='" . $baseUrl . "/img/symbols/gif_red/anmal.gif'\" onMouseOut=\"document.anmal_.src='" . $baseUrl . "/img/symbols/gif_purple/anmal.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupReport');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/anmal.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"anmal_\">&nbsp;&nbsp;Rapportera</a></span></td>
 </tr>";
 		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.avanceradSok.src='" . $baseUrl . "/img/symbols/gif_red/sok.gif'\" onMouseOut=\"document.avanceradSok.src='" . $baseUrl . "/img/symbols/gif_purple/sok.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupAdvSearch');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/sok.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"avanceradSok\">&nbsp;&nbsp;Sök på ålder och stad</a></span></td>
 </tr>";

$body .= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.myInbox.src='" . $baseUrl . "/img/symbols/gif_red/inbox.gif'\" onMouseOut=\"document.myInbox.src='" . $baseUrl . "/img/symbols/gif_purple/inbox.gif'\"><a href=\"" . $baseUrl . "/inbox.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/inbox.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"myInbox\">&nbsp;&nbsp;Min inbox (" . number_format((int)$unReadMessages, 0, ",", " ") . ")</a></span></td>
 </tr>";
$body .= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.myNewWalls.src='" . $baseUrl . "/img/symbols/gif_red/annonser_erbjudanden.gif'\" onMouseOut=\"document.myNewWalls.src='" . $baseUrl . "/img/symbols/gif_purple/annonser_erbjudanden.gif'\"><a href=\"" . $baseUrl . "/presentation.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/annonser_erbjudanden.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"myNewWalls\">&nbsp;&nbsp;Min vägg (" . number_format((int)$newWall, 0, ",", " ") . ")</a></span></td>
 </tr>";

$body .= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.myNewFlirts.src='" . $baseUrl . "/img/symbols/gif_red/skicka_flort.gif'\" onMouseOut=\"document.myNewFlirts.src='" . $baseUrl . "/img/symbols/gif_purple/skicka_flort.gif'\"><a href=\"" . $baseUrl . "/flirts.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka_flort.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"myNewFlirts\">&nbsp;&nbsp;Flörtar (" . number_format((int)$newFlirts, 0, ",", " ") . ")</a></span></td>
 </tr>";

 
 if ((int)$newFriends > 0) {
$body .= "  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.myNewFriends.src='" . $baseUrl . "/img/symbols/gif_red/van.gif'\" onMouseOut=\"document.myNewFriends.src='" . $baseUrl . "/img/symbols/gif_purple/van.gif'\"><a href=\"" . $baseUrl . "/notes.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/van.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"myNewFriends\">&nbsp;&nbsp;Vänförfrågningar (" . number_format((int)$newFriends, 0, ",", " ") . ")</a></span></td>
 </tr>";
 } else {
$body .= "  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.myNewFriends.src='" . $baseUrl . "/img/symbols/gif_red/van.gif'\" onMouseOut=\"document.myNewFriends.src='" . $baseUrl . "/img/symbols/gif_purple/van.gif'\"><a href=\"" . $baseUrl . "/friends.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/van.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"myNewFriends\">&nbsp;&nbsp;Vänförfrågningar (" . number_format((int)$newFriends, 0, ",", " ") . ")</a></span></td>
 </tr>";
 }
 $body .= "

 <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.crew_communication.src='" . $baseUrl . "/img/symbols/gif_red/nyhet.gif'\" onMouseOut=\"document.crew_communication.src='" . $baseUrl . "/img/symbols/gif_purple/nyhet.gif'\"><a href=\"" . $baseUrl . "/crew_communication.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/nyhet.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"crew_communication\">&nbsp;&nbsp;Meddelanden från Crew";
if ($userProfile["seenLatestCrewMsg"] == 'NO') {
$body .= " (1)";	
} else {
$body .= " (0)";	
}
	$body .= "</a></span></td>
 </tr>";

 
 
/*
$body .= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.myInvitationsLeft.src='" . $baseUrl . "/img/symbols/gif_red/bjud_in_vanner.gif'\" onMouseOut=\"document.myInvitationsLeft.src='" . $baseUrl . "/img/symbols/gif_purple/bjud_in_vanner.gif'\"><a href=\"" . $baseUrl . "/my_invitations.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/bjud_in_vanner.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"myInvitationsLeft\">&nbsp;&nbsp;Inbjudningar kvar (" . number_format((int)$userProfile["invitesLeft"], 0, ",", " ") . ")</a></span></td>
 </tr>";
*/
 $body .= "


<!--
  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sendQuickMess.src='" . $baseUrl . "/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.sendQuickMess.src='" . $baseUrl . "/img/symbols/gif_purple/skicka.gif'\"><a href=\"" . $baseUrl . "/new_message.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sendQuickMess\">&nbsp;&nbsp;Skicka ett mess</a></span></td>
 </tr>
</table>-->



";
if ( $userProfile["visible"] == "YES" )
{

 $body .=	"  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\" id=\"visibleInvisible\"><span onMouseOver=\"document.synlig.src='" . $baseUrl . "/img/symbols/gif_red/synlig.gif'\" onMouseOut=\"document.synlig.src='" . $baseUrl . "/img/symbols/gif_purple/synlig.gif'\"><a  href=\"#noexist\" onClick=\"getContent('visible_invisible.php?target=visibleInvisible&action=invisible');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/synlig.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"synlig\" >&nbsp;&nbsp;Jag &auml;r: <span class=\"current\">Synlig</span> / Osynlig</a></span></td>
 </tr>";

}
else
{
 $body .=	"  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\" id=\"visibleInvisible\"><span onMouseOver=\"document.synlig.src='" . $baseUrl . "/img/symbols/gif_red/osynlig.gif'\" onMouseOut=\"document.synlig.src='" . $baseUrl . "/img/symbols/gif_purple/osynlig.gif'\"><a  href=\"#noexist\" onClick=\"getContent('visible_invisible.php?target=visibleInvisible&action=visible');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/osynlig.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"synlig\" >&nbsp;&nbsp;Jag &auml;r: Synlig / <span class=\"current\">Osynlig</span></a></span></td>
 </tr>";
}



$body .= "</table>";

if ($displaySurveyBox == TRUE) {
	$q = "SELECT * FROM fl_polls WHERE active = 'YES' ORDER BY insDate DESC LIMIT 1";
	$currPoll = $DB->GetRow( $q, FALSE, TRUE );
	if ((int)$currPoll["id"] > 0) {
		$q = "SELECT * FROM fl_polls_options WHERE pollId = '".(int)$currPoll["id"]."' ORDER BY ID ASC";
		$currPollOptions = $DB->GetAssoc( $q, FALSE, TRUE );
		if (count($currPollOptions) > 0) {
		
	
$body .= '
<h2>Omr&ouml;stning</h2>
<p>'.$currPoll["description"].'</p>
<h4>'.$currPoll["question"].'</h4>
<form method="POST" action="'.$baseUrl.'/" name="surveyForm">
<input name="type" value="survey" type="hidden">
<input name="pollId" value="'.(int)$currPoll["id"].'" type="hidden">';

while ( list( $key, $value ) = each( $currPollOptions ) )
		{
			
			
$body .= '
<div style="border: 0px none; margin:0px;">
<input name="optionId" value="'.(int)$currPollOptions[ $key ]["id"].'" selected="" type="radio">&nbsp;&nbsp;'.$currPollOptions[ $key ]["title"].'</div>';
		}
$body .= '
<br />

<span onmouseover="document.surveySubmit.src=\''.$baseUrl.'/img/symbols/gif_red/skicka.gif\'" onmouseout="document.surveySubmit.src=\''.$baseUrl.'/img/symbols/gif_purple/skicka.gif\'"><nobr><a href="#noexist" onclick="document.surveyForm.submit();"><img src="'.$baseUrl.'/img/symbols/gif_purple/skicka.gif" name="surveySubmit" style="vertical-align: middle;" border="0">Skicka svar!</a></nobr></span><br /><br /><br />
</form>
';
		}
}
}

$body .= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 20px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;padding-bottom:4px;\"><h3>Topplistor + Nytt</h3></td>
<!--	<td align=\"right\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><span class=\"other_link\"><a href=\"#\">edit</a></span><span style=\"color: #b28aa6;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href=\"#\"><img src=\"" . $baseUrl . "/img/kryss_edit.gif\" name=\"quickLinksX\" border=\"0\" onMouseOver=\"document.quickLinksX.src='" . $baseUrl . "/img/kryss_edit_red.gif'\" onMouseOut=\"document.quickLinksX.src='" . $baseUrl . "/img/kryss_edit.gif'\"></a></td>-->
 </tr>";

 $body .= "
  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.sidoKnappOnline.src='" . $baseUrl . "/img/symbols/gif_red/valj_region.gif'\" onMouseOut=\"document.sidoKnappOnline.src='" . $baseUrl . "/img/symbols/gif_purple/valj_din_region.gif'\"><a href=\"" . $baseUrl . "/search.html?SearchQuery=&order=online\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/valj_din_region.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sidoKnappOnline\">&nbsp;&nbsp;Online just nu</a></span></td>
 </tr>";

 $body .= "
  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.albumTopplista.src='" . $baseUrl . "/img/symbols/gif_red/bild.gif'\" onMouseOut=\"document.albumTopplista.src='" . $baseUrl . "/img/symbols/gif_purple/bild.gif'\"><a href=\"" . $baseUrl . "/album_senaste.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/bild.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"albumTopplista\">&nbsp;&nbsp;Senaste album</a></span></td>
 </tr>";


 $body .= "
  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.bloggTopplista.src='" . $baseUrl . "/img/symbols/gif_red/blogg.gif'\" onMouseOut=\"document.bloggTopplista.src='" . $baseUrl . "/img/symbols/gif_purple/blogg.gif'\"><a href=\"" . $baseUrl . "/blogg_senaste.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/blogg.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"bloggTopplista\">&nbsp;&nbsp;Senaste blogginlägg</a></span></td>
 </tr>";

 

 $body .= "
  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.nyaMedlemmar.src='" . $baseUrl . "/img/symbols/gif_red/mest_sedda.gif'\" onMouseOut=\"document.nyaMedlemmar.src='" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif'\"><a href=\"" . $baseUrl . "/nya_medlemmar.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"nyaMedlemmar\">&nbsp;&nbsp;Nya medlemmar</a></span></td>
 </tr>";


 $body .= "
  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.nyaBilder.src='" . $baseUrl . "/img/symbols/gif_red/bild.gif'\" onMouseOut=\"document.nyaBilder.src='" . $baseUrl . "/img/symbols/gif_purple/bild.gif'\"><a href=\"" . $baseUrl . "/nya_bilder.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/bild.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"nyaBilder\">&nbsp;&nbsp;Nya bilder</a></span></td>
 </tr>";
/*
  $body .= "
  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.nyaFilmer.src='" . $baseUrl . "/img/symbols/gif_red/film.gif'\" onMouseOut=\"document.nyaFilmer.src='" . $baseUrl . "/img/symbols/gif_purple/film.gif'\"><a href=\"" . $baseUrl . "/nya_videos.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/film.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"nyaFilmer\">&nbsp;&nbsp;Nya filmer</a></span></td>
 </tr>";
*/

 $body .= "
  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.senasteforumTradar.src='" . $baseUrl . "/img/symbols/gif_red/fakta_flator_se.gif'\" onMouseOut=\"document.senasteforumTradar.src='" . $baseUrl . "/img/symbols/gif_purple/fakta_om_flator_se.gif'\"><a href=\"" . $baseUrl . "/senaste_forumtradar.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/fakta_om_flator_se.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"senasteforumTradar\">&nbsp;&nbsp;Senaste foruminläggen</a></span></td>
 </tr>";


 $body .= "
  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.forumTradar.src='" . $baseUrl . "/img/symbols/gif_red/svar.gif'\" onMouseOut=\"document.forumTradar.src='" . $baseUrl . "/img/symbols/gif_purple/svar.gif'\"><a href=\"" . $baseUrl . "/top_forum_threads.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/svar.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"forumTradar\">&nbsp;&nbsp;Populäraste forumtrådarna</a></span></td>
 </tr>";


 $body .= "
  <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\"><span onMouseOver=\"document.mestAktiva.src='" . $baseUrl . "/img/symbols/gif_red/ranka.gif'\" onMouseOut=\"document.mestAktiva.src='" . $baseUrl . "/img/symbols/gif_purple/ranka.gif'\"><a href=\"" . $baseUrl . "/top_forum_users.html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/ranka.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"mestAktiva\">&nbsp;&nbsp;Mest aktiva på forumet</a></span></td>
 </tr>";

 $body .= "
</table>";

/*
 	$body.= "
<div align=\"left\"><a href=\"http://www.piratpartiet.se/\"><img src=\"http://bildbank.piratpartiet.se/d/779-1/ikkpp_160px.png\" border=\"0\"></a></div>


 ";
*/

	}
	else
	{
		$loginForm = TRUE;
		$body.= "
		
<div style=\"padding-bottom: 4px; border-bottom: 1px dotted #c8c8c8;\"><h3 style=\"color: #645d54\">Logga in</h3></div>
<form name=\"loginform\" method=\"post\" action=\"" . $baseUrl . "\" style=\"padding: 0px; margin: 0px\" id=\"loginform\">

<p><label class=\"login\" for=\"username\" style=\"font-size:9px\">Användarnamn:</label> <input type=\"text\" id=\"username\" name=\"username\" style=\"float:right; height:20px; font-size:13px; border:solid 1px #aa567a;filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;background-color:#fff;width:130px; margin:0px; padding:2px;\"></p>
<div style=\"clear:both;\"></div>
<p><label class=\"login\" for=\"password\" style=\"font-size:9px\">Lösenord:</label> <input type=\"password\" id=\"password\" name=\"password\" style=\"float:right; height:20px; font-size:13px; border:solid 1px #aa567a;filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;background-color:#fff;width:130px; margin:0px; padding:2px;\"></p>
<div style=\"float:right; margin-top:10px;\">
<span onMouseOver=\"document.getElementById('loginButton').src='" . $baseUrl . "/img/logga_in_active.gif'\" onMouseOut=\"document.getElementById('loginButton').src='" . $baseUrl . "/img/logga_in.gif'\">
<INPUT TYPE=\"IMAGE\" SRC=\"" . $baseUrl . "/img/logga_in.gif\" ALT=\"Logga in\"  id=\"loginButton\">
</span></div>
<div style=\"clear:both;\"></div>
<div style=\"float:right; margin-top:10px;\">
<a href=\"" . $baseUrl . "/reset_password.html\" style=\"font-weight:normal; font-size:10px\">Har du glömt ditt lösenord?</a></div>
</form>
<br><br>
<br>


<div style=\"padding-bottom: 4px; border-bottom: 1px dotted #c8c8c8;\"><h3 style=\"color: #645d54\">Skapa konto</h3></div>
<p>Vill du bli medlem på Flator.se? <a href=\"" . $baseUrl . "/register.html\">Skapa konto h&auml;r!</a></p>
";
/*
$body .= "<br>
<form method=\"post\" style=\"padding: 0px; margin: 0px\">
<input type=\"hidden\" name=\"newsletter\" value=\"true\">
<div style=\"padding-bottom: 4px; border-bottom: 1px dotted #c8c8c8;\"><h3 style=\"color: #645d54\">E-post för nyhetsbrev</h3></div>
<div style=\"float:left; margin-top:10px;\"><input type=\"text\" name=\"email\" style=\"height:20px; font-size:13px; width:120px; border:solid 1px #aa567a;filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;background-color:#fff;\"  style=\"vertical-align:middle;\"></div><div style=\"float:right; margin-top:10px;\"><span onMouseOver=\"document.getElementById('sendButton').src='" . $baseUrl . "/img/skicka_active.gif'\" onMouseOut=\"document.getElementById('sendButton').src='" . $baseUrl . "/img/skicka.gif'\">
<INPUT TYPE=\"IMAGE\" SRC=\"" . $baseUrl . "/img/skicka.gif\" ALT=\"Skicka\"  id=\"sendButton\"  style=\"vertical-align:middle;\">
</span></div><div style=\"clear:both;\"></div>
".$newsletter_thankyou."<br>

</form>";
*/
$body .= "
<br>
<div style=\"padding-bottom: 4px; border-bottom: 1px dotted #c8c8c8; margin-top:0px;\"><h3 style=\"color: #645d54\">flator.se <span style=\"font-weight: normal\">för att</span></h3></div>
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px; margin-bottom: 20px; font-weight: normal\">";
  		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 8px\" >&nbsp;</td>
 </tr>";
 		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\" class=\"colorText\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/sok.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"keepConnected\">&nbsp;&nbsp;<a href=\"http://dev.flator.se/Umgas.html\">Umgås & träffa lesbiska online</a></td>

 </tr>";
 		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\" class=\"colorText\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/bjud_in_vanner.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"events\">&nbsp;&nbsp;<a href=\"http://dev.flator.se/events forflator.html\">Events för flator</a></td>
 </tr>";
 		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\" class=\"colorText\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/tipsa_om_flator_se.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"partyImages\">&nbsp;&nbsp;<a href=\"http://dev.flator.se/Festbilder.html\">Festbilder</a></td>
 </tr>";
 		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\" class=\"colorText\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/chat.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"videoChat\">&nbsp;&nbsp;<a href=\"http://dev.flator.se/Videochatinsidebar.html\">Videochat</a></td>
 </tr>";
 		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\" class=\"colorText\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/blogg.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"Blogga\">&nbsp;&nbsp;<a href=\"http://dev.flator.se/Blogga.html\">Blogga</a></td>
 </tr>";
 		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\" class=\"colorText\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/grupp.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sharePhotos\">&nbsp;&nbsp;<a href=\"http://dev.flator.se/DelaFoto.html\">Dela foton & filmklipp</a></td>
 </tr>";
 		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\" class=\"colorText\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/mest_sedda.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"chooseFriends\">&nbsp;&nbsp;<a href=\"http://dev.flator.se/SynligOsynlig.html\">Synlig / osynlig</a></td>
 </tr>";
 		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\" class=\"colorText\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/flort.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"flirt\">&nbsp;&nbsp;<a href=\"http://dev.flator.se/FlortaIHemlighet.html\">Flörta i hemlighet</a></td>
 </tr>";
 		$body.= " <tr>
	<td align=\"left\" valign=\"middle\" style=\"line-height: 20px\" class=\"colorText\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/annonser_erbjudanden.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"flirt\">&nbsp;&nbsp;<a href=\"http://dev.flator.se/Diskutera pa forumet.html\">Diskutera på forumet</a></td>
 </tr>";
		$body.= "</table>";


	$body.= "<table border=\"0\" width=\"100%\" style=\"font-size: 12px; margin-bottom: 10px\">
 <tr>
	<td align=\"left\" valign=\"bottom\" style=\"border-bottom: 1px dotted #c8c8c8;\"><h3 style=\"color: #645d54\">Blogg</h3></td>
 </tr>
</table>
<p style=\"font-size:12px;line-height:15px;\">Kika gärna in på bloggen och lämna synpunkter, kommunicera eller kolla vad som händer under veckorna.<br /><br />
<a href=\"" . $baseUrl . "/blogg/\">Den officiella bloggen ></a></p>

 ";





	}

	return $body;
}
?>