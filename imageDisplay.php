<?
	if ( (int)$currentPhoto["id"] > 0 )
	{


			$body.= "<tr>
 	<td style=\"width: 100%; padding-bottom: 10px;\" valign=\"middle\" align=\"center\"><div style=\"vertical-align: middle;\"><a href=\"".$nextUrl."\">".$currentImage."</a></div>
	";
	$body .= "
			
			</td>
 </tr>
 
 <tr>
<td valign=\"bottom\" align=\"left\" style=\"border-bottom: 1px dotted rgb(200, 200, 200); padding-bottom:5px;\">";
$body .= "<span style=\"font-size:11px;color: #a09c96;font-weight:bold;\">";

		$q = "SELECT * FROM fl_tags WHERE type = 'photo' AND mediaId = '".(int)$currentPhoto["id"]."' order by alt ASC";
		$tags = $DB->GetAssoc( $q, FALSE, TRUE );
		if (count($tags) > 0) {
		$body .= "<img src=\"" . $baseUrl . "/img/symbols/gif_purple/tagga2.gif\" style=\"vertical-align:middle; margin-bottom:2px;\" border=\"0\" />Taggade på bilden: ";
		$taggedUsers = "";
		while ( list( $key, $value ) = each( $tags ) )
		{
			if ((int)$tags[$key]["targetId"] > 0) {
				$q = "SELECT * FROM fl_users WHERE id = " . (int)$tags[$key]["targetId"];
				$taggedUser = $DB->GetRow( $q, FALSE, TRUE );
				if ( count( $taggedUser ) > 0 ) {
				
				if (strlen($taggedUsers) > 0) $taggedUsers .= ", ";
				$taggedUsers .= "<a href=\"http://www.flator.se/user/".stripslashes( $taggedUser["username"] ).".html\">".stripslashes($taggedUser["username"])."</a>";



			} else {

				
			}

			} elseif (strlen($tags[$key]["targetStr"]) > 0) {
					if (strlen($taggedUsers) > 0) $taggedUsers .= ", ";
					$taggedUsers .= stripslashes($tags[$key]["targetStr"]);
				

			} else {
				
			}

		}
		$body .= $taggedUsers;
		$body .= "<br>";
		}
						
















$body .= "<img src=\"" . $baseUrl . "/img/symbols/gif_purple/bild.gif\" style=\"vertical-align:middle; margin-bottom:2px;\" border=\"0\" />Uppladdad ".$onlineTime.". Från albumet <a href=\"".$baseUrl."/media/album/".$currentAlbum["id"].".html\">\"".$currentAlbum["name"]."\"</a> av <a href=\"http://www.flator.se/user/".stripslashes( $userPres["username"] ).".html\">".stripslashes( $userPres["username"] )."</a>.";
if ($editMedia == TRUE || $_SESSION["rights"] > 4) {
	if ($currentAlbum["album_image_id"] == $currentPhoto["id"]) {
		
	$body.= "<span class=\"underlinks_right\">&nbsp;&nbsp;Aktiv miniatyr</span>";

	} else {
	$body.= "<span class=\"underlinks_right\"><a href=\"".$currentPhoto["id"].".html?do=setThumb\">&nbsp;&nbsp;Använd som miniatyr</a></span>";
	}
$body .= "<div id=\"tagImg\"></div>";
}

$body .= "</span></td>
</tr>
 <tr>
<td valign=\"bottom\" align=\"left\">";
		if ( $editMedia == TRUE || $_SESSION["rights"] > 5)
		{
			$body.= "<div style=\"width: 190px; height:60px;float:left;margin-top:0px; \">
			<div style=\"width: 190px;float:left; border-bottom: 1px dotted rgb(200, 200, 200);margin-top:4px; height:25px;\">
			<span onMouseOver=\"document.deletePhotoImg.src='" . $baseUrl . "/img/symbols/gif_red/radera.gif'\" onMouseOut=\"document.deletePhotoImg.src='" . $baseUrl . "/img/symbols/gif_purple/radera.gif'\"><a href=\"#noexist\" OnClick=\"if(confirm('Ta bort detta fotografi?')) { location.search='?do=deletePhoto'; } else { return false; }\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/radera.gif\" name=\"deletePhotoImg\" style=\"vertical-align:middle;\" border=\"0\" />Radera</a></span>
			</div>
			<div style=\"width: 190px;float:left; border-bottom: 1px dotted rgb(200, 200, 200); margin-top:5px; height:25px;\"><span onMouseOver=\"document.editPhotoName.src='" . $baseUrl . "/img/symbols/gif_red/redigera.gif'\" onMouseOut=\"document.editPhotoName.src='" . $baseUrl . "/img/symbols/gif_purple/redigera.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupEditPhoto');\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/redigera.gif\" name=\"editPhotoName\" style=\"vertical-align:middle;\" border=\"0\" />Redigera namn</a></span>
			</div>
			</div>
			
			<div style=\"width: 190px;float:left;margin-top:0px; margin-left:15px; \">
			<div style=\"width: 190px;float:left; border-bottom: 1px dotted rgb(200, 200, 200); margin-top:4px; height:25px;\">";
if ($_SESSION["rights"] > 1) {
	
	$body .= "			<span onMouseOver=\"document.taggaImg.src='" . $baseUrl . "/img/symbols/gif_red/tagga2.gif'\" onMouseOut=\"document.taggaImg.src='" . $baseUrl . "/img/symbols/gif_purple/tagga2.gif'\"><a href=\"#noexist\" onClick=\"showLoad('tagImg');getContent('tagImg.php?target=tagImg&photoId=".$currentPhoto["id"]."');\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/tagga2.gif\" name=\"taggaImg\" style=\"vertical-align:middle;\" border=\"0\" />Tagga bilden / filmen</a></span>"; 
} else {
	$body .= "			<span onMouseOver=\"document.taggaImg.src='" . $baseUrl . "/img/symbols/gif_red/tagga2.gif'\" onMouseOut=\"document.taggaImg.src='" . $baseUrl . "/img/symbols/gif_purple/tagga2.gif'\"><a href=\"#noexist\" OnClick=\"if(confirm('Funktion under utveckling')) { return false; } else { return false; }\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/tagga2.gif\" name=\"taggaImg\" style=\"vertical-align:middle;\" border=\"0\" />Tagga bilden / filmen</a></span>"; 



}
$body .= "
			</div>
			<div style=\"width: 190px;float:left; border-bottom: 1px dotted rgb(200, 200, 200); margin-top:5px; height:25px;\"><span onMouseOver=\"document.kopplabloggImg.src='" . $baseUrl . "/img/symbols/gif_red/blogg.gif'\" onMouseOut=\"document.kopplabloggImg.src='" . $baseUrl . "/img/symbols/gif_purple/blogg.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupAddToBlog');\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/blogg.gif\" name=\"kopplabloggImg\" style=\"vertical-align:middle;\" border=\"0\" />Koppla till blogginlägg</a></span>
			</div>
			</div>
			
			<div style=\"width: 190px; height:60px; float:left;margin-top:0px; margin-left:15px; border-bottom: 1px dotted rgb(200, 200, 200);\">
	
			</div>";
		} else {


			$shortUsername = stripslashes($userPres["username"]);

			
			if (strlen($shortUsername) > 10) {
			$shortUsername = substr($shortUsername, 0, 8).".."; }
			
			if ( isCurrentFriend ( (int)$_SESSION["userId"], (int)$userPres["id"] ) == FALSE )
			{
				$body.= "<div style=\"width: 190px; height:90px;float:left;margin-top:0px; \">
				<div style=\"width: 190px;float:left; border-bottom: 1px dotted rgb(200, 200, 200);margin-top:4px; height:25px;\">
				<span onMouseOver=\"document.sendMessUser_onpres.src='" . $baseUrl . "/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.sendMessUser_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/skicka.gif'\"><a href=\"" . $baseUrl . "/new_message.html?userId=" . (int)$userPres["id"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sendMessUser_onpres\" />&nbsp;&nbsp;Skicka mess till " . $shortUsername . "</a></span>
				</div>";
		

					$body.= "
					<div style=\"width: 190px;float:left; border-bottom: 1px dotted rgb(200, 200, 200);margin-top:4px; height:25px;\">
					<span onMouseOver=\"document.becomeFriend_onpres.src='" . $baseUrl . "/img/symbols/gif_red/van.gif'\" onMouseOut=\"document.becomeFriend_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/van.gif'\"><a href=\"#noexist\" onclick=\"showPopup('popupAddFriend');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/van.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"becomeFriend_onpres\" />&nbsp;&nbsp;Bli vän med " . $shortUsername . "</a></span>
					</div>";

				
				$body .= "
				<div style=\"width: 190px;float:left; border-bottom: 1px dotted rgb(200, 200, 200); margin-top:5px; height:25px;\"><span onMouseOver=\"document.sendFlirt_onpres.src='" . $baseUrl . "/img/symbols/gif_red/skicka_flort.gif'\" onMouseOut=\"document.sendFlirt_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/skicka_flort.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupSendFlirt');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka_flort.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sendFlirt_onpres\" />&nbsp;&nbsp;Skicka flört till " . $shortUsername . "</a></span>
				</div>
				</div>
				



				<div style=\"width: 380px; height:90px; float:left;margin-top:0px; margin-left:15px; border-bottom: 1px dotted rgb(200, 200, 200);\">
		
				</div>";
			} else {
				$body.= "<div style=\"width: 190px; height:60px;float:left;margin-top:0px; \">
				<div style=\"width: 190px;float:left; border-bottom: 1px dotted rgb(200, 200, 200);margin-top:4px; height:25px;\">
				<span onMouseOver=\"document.sendMessUser_onpres.src='" . $baseUrl . "/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.sendMessUser_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/skicka.gif'\"><a href=\"" . $baseUrl . "/new_message.html?userId=" . (int)$userPres["id"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sendMessUser_onpres\" />&nbsp;&nbsp;Skicka mess till " . $shortUsername . "</a></span>
				</div>";
		
				
				$body .= "
				<div style=\"width: 190px;float:left; border-bottom: 1px dotted rgb(200, 200, 200); margin-top:5px; height:25px;\"><span onMouseOver=\"document.sendFlirt_onpres.src='" . $baseUrl . "/img/symbols/gif_red/skicka_flort.gif'\" onMouseOut=\"document.sendFlirt_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/skicka_flort.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupSendFlirt');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka_flort.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sendFlirt_onpres\" />&nbsp;&nbsp;Skicka flört till " . $shortUsername . "</a></span>
				</div>
				</div>
				



				<div style=\"width: 380px; height:60px; float:left;margin-top:0px; margin-left:15px; border-bottom: 1px dotted rgb(200, 200, 200);\">
		
				</div>";
			}










		}

















$body.= "<div style=\"clear:both;\"></div><br>";

$body .= "
</td>
</tr>
<tr>
</tr></tbody>
";


#			$body.= "<tr>
# 	<td colspan=\"4\" style=\"padding-bottom: 5px; border-top: 1px dotted #c8c8c8;\" valign=\"top\">&nbsp;</td>
# </tr>";
		
	} else {
		if ($friendsOnly == TRUE) {
		$body.= "<b>Endast vänner till ".$userPres["username"]." får se detta album och bilderna det innehåller.</b>";

		} else {
		$body.= "<b>Bilden kunde inte hittas, den är troligen borttagen.</b>";
		}
	}
	

	$body.= "</table>
	<div id=\"divFooterSpace\" style=\"border: 0px\">";

if (count($comments) > 0) {

		while ( list( $key, $value ) = each( $comments ) )
		{
			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$comments[ $key ]["userId"] . " AND imageType = 'profileSmall'";
			$profileImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $profileImage ) > 0 )
			{
				$avatar = "<img src=\"" . $profileImage["imageUrl"] . "\" border=\"0\" width=\"" . $profileImage["width"] . "\" height=\"" . $profileImage["height"] . "\" />";
			}
			else
			{
				$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
			}
			$comments[ $key ]["avatar"] = $avatar;

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$comments[ $key ]["userId"] . " AND imageType = 'profileMedium'";
			$guestImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $guestImage ) > 0 )
			{
				$comments[ $key ]["mediumAvatar"] = $guestImage["imageUrl"];
			}
			else
			{
				$comments[ $key ]["mediumAvatar"] = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
			}

			$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$comments[ $key ]["userId"] . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
			$statusRow = $DB->GetRow( $q, FALSE, TRUE );
			$comments[ $key ]["status"] = $statusRow["statusMessage"];
		}
	
reset($comments);
$body .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px\">";
while ( list( $key, $value ) = each( $comments ) )
		{
		




			unset( $onlineTime );
			// Possible date-types: Today, Yesterday, ThisYear, LastYear
			if ( date("Y-m-d", $comments[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$onlineTime = "<div class=\"email_date\">" . "Idag " . date( "H:i", $comments[ $key ]["unixTime"] ) . "</div>";
			}
			elseif ( date("Y-m-d", $comments[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$onlineTime = "<div class=\"email_date\">" . "Ig&aring;r " . date( "H:i", $comments[ $key ]["unixTime"] ) . "</div>";
			}
			elseif ( date("Y", $comments[ $key ]["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$onlineTime = "<div class=\"email_date\">" . date( "j M Y H:i", $comments[ $key ]["unixTime"] ) . "</div>";
			}
			else
			{
				$onlineTime = "<div class=\"email_date\">" . date( "Y-m-d H:i", $comments[ $key ]["unixTime"] ) . "</div>";
			}

			$body.= "<tr>
 	<td style=\"width: 30px; padding-bottom: 15px; padding-right: 10px\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . $comments[ $key ]["username"] . ".html\" style=\"font-weight: normal\">" . $comments[ $key ]["avatar"] . "</a></td>
 	<td style=\"width: 110px;padding-bottom: 15px\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . $comments[ $key ]["username"] . ".html\">" . $comments[ $key ]["username"] . "</a><br />" . $onlineTime . "

 	</td>
  	<td style=\"padding-bottom: 15px\" valign=\"top\">" . stripslashes($comments[ $key ]["comment"]) . "</td>
 </tr>";
			$body.= "<tr>
 	<td colspan=\"4\" style=\"border-top: 1px dotted #c8c8c8;font-size:2px;line-height:2px;height:15px;\" valign=\"top\">&nbsp;</td>
 </tr>";




		

		}
		$body .= "</table>";
} else {


$body .= 'Ingen har kommenterat än!';
}


if ( $currentPhoto["id"] > 0 ) { 
	$body .= '
<div id="commentDiv" style="margin-left: 195px; width:400px;">



<form method="post" enctype="multipart/form-data" style="" name="commentForm">
<input type="hidden" name="type" value="commentPhoto" />
<input type="hidden" name="photoId" value="'.$currentPhoto["id"].'" />



<div style="display: inline; float: left; "><span style="font-weight:bold;font-color:#645D54;font-size:12px;">Lämna kommentar</span><br>
<textarea name="comment" rows="4" cols="50" wrap="hard" style="width: 400px; borders: 0px; height:50px; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;"></textarea></div>

<div style="clear:both;"></div>
<div style="float:right;" onMouseOver="document.addFriendSubmit.src=\''.$baseUrl.'/img/symbols/gif_red/skicka.gif\'" onMouseOut="document.addFriendSubmit.src=\''.$baseUrl.'/img/symbols/gif_purple/skicka.gif\'"><nobr><a href="#noexist" onClick="document.commentForm.submit();">Spara kommentar <img src="'.$baseUrl.'/img/symbols/gif_purple/skicka.gif" name="addFriendSubmit" align="ABSMIDDLE" border="0" /></a></nobr></div>
</form>

</div>';
}  
?>