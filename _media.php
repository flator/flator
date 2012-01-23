<?php

$numPerPage = 10;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/media.html";
	include( "login_new.php" );
}
else
{

	if ( $_POST  && $_SESSION["demo"] != TRUE )
	{
		if ( $_POST["type"] == "addAlbum" )
		{
			if ( !isCurrentAlbum ( (int)$_SESSION["userId"], $_POST["album"] ) )
			{
				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["modifiedDate"] = date("Y-m-d H:i:s");
				
				$record["userId"] = (int)$_SESSION["userId"];
				$record["name"] = addslashes($_POST["album"]);
				$record["location"] = addslashes( $_POST["location"] );
				$record["description"] = addslashes( $_POST["description"] );
				$record["friends_only"] = addslashes( $_POST["friends_only"] );
				
				$DB->AutoExecute( "fl_albums", $record, 'INSERT' ); 
				$newAlbumId = $DB->Insert_ID();
			}
			$thankoyu = "<li>Albumet <b>" . $_POST["album"] . "</b> har skapats.</li>\n";
		}

		if ( $_POST["type"] == "editAlbum" )
		{
		
				$record = array();
			
				$record["modifiedDate"] = date("Y-m-d H:i:s");
				
				$record["name"] = addslashes($_POST["album"]);
				$record["location"] = addslashes( $_POST["location"] );
				$record["description"] = addslashes( $_POST["description"] );
				$record["friends_only"] = addslashes( $_POST["friends_only"] );
				
				$DB->AutoExecute( "fl_albums", $record, 'UPDATE', 'id = '.(int)$_POST["albumId"] ); 
				$_POST = array();
			
			$thankoyu = "<li>Albumet <b>" . $_POST["album"] . "</b> har redigerats.</li>\n";
		}

		
if ( $_POST["type"] == "uploadPhoto2"  && $_SESSION["demo"] != TRUE )
		{
		uploadPhotos();
		}
if ( $_POST["type2"] == "uploadPhoto" )
		{
		echo "salam";
			uploadPhotos($newAlbumId);
		}

	}

	if (( isCurrentFriend ( (int)$_SESSION["userId"], (int)$userPres["id"] ) == FALSE ) && ((int)$_SESSION["userId"] != (int)$userPres["id"]))
		{
		$extraSQL = "AND friends_only = 'NO'";
		} else {
		$extraSQL = "";
		}
	$currentLink = array();
	if ( $_GET["sortBy"] == "asc" )
	{
		$q = "SELECT fl_albums.*, UNIX_TIMESTAMP(fl_albums.modifiedDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_albums LEFT JOIN fl_users ON fl_users.id = fl_albums.userId WHERE fl_albums.userId = " . (int)$userPres["id"] . " ".$extraSQL." ORDER BY fl_albums.insDate ASC";
		$albums = $DB->GetAssoc( $q, FALSE, TRUE );
		$currentLink["asc"] = " class=\"current\"";
	}
	elseif ( !$_GET["sortBy"] )
	{
		$q = "SELECT fl_albums.*, UNIX_TIMESTAMP(fl_albums.modifiedDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_albums LEFT JOIN fl_users ON fl_users.id = fl_albums.userId WHERE fl_albums.userId = " . (int)$userPres["id"] . " ".$extraSQL." ORDER BY fl_albums.insDate DESC";
		$albums = $DB->GetAssoc( $q, FALSE, TRUE );
		$currentLink["desc"] = " class=\"current\"";
	}
	elseif ( $_GET["sortBy"] == "visits" )
	{
		$q = "SELECT fl_albums.*, UNIX_TIMESTAMP(fl_albums.modifiedDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_albums LEFT JOIN fl_users ON fl_users.id = fl_albums.userId WHERE fl_albums.userId = " . (int)$userPres["id"] . " ".$extraSQL." ORDER BY fl_albums.noViews DESC";
		$albums = $DB->GetAssoc( $q, FALSE, TRUE );
		$currentLink["visits"] = " class=\"current\"";
	}

	if ( count( $albums ) > 0 )
	{
		while ( list( $key, $value ) = each( $albums ) )
		{
			$q = "SELECT * FROM fl_images WHERE id = " . (int)$albums[ $key ]["album_image_id"] . " AND imageType IN ('albumPhoto', 'albumVideo')";
			$albumImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $albumImage ) > 0 )
			{
				$avatar = "<img src=\"".$baseUrl . "./user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumImage["serverLocation"])) . "/small/\" border=\"0\" width=\"61\" height=\"61\" />";
			}
			else
			{
				$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/grupp_avantar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
			}
			$albums[ $key ]["avatar"] = $avatar;
		}
	}


	$body = "<div id=\"center\">
<form name=\"form\" style=\"margin: 0px; padding: 0px\" method=\"post\">
	";
	if ( $editMedia == TRUE )
		{
		$body .= "<div id=\"divHeadSpace\"><div id=\"headLinks\" style=\"width: 440px\">";
			if ( count( $albums ) > 0 )
			{
				
					$body.= "<span onMouseOver=\"document.deleteMultipleAlbum.src='" . $baseUrl . "/img/symbols/gif_red/radera.gif'\" onMouseOut=\"document.deleteMultipleAlbum.src='" . $baseUrl . "/img/symbols/gif_purple/radera.gif'\"><a href=\"#noexist\" OnClick=\"if(confirm('Ta bort markerade album?')) { location='" . $baseUrl . "/delete_albums.html?albumIds=' + checkboxValues(document.form.albumId); } else { return false; }\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/radera.gif\" name=\"deleteMultipleAlbum\" align=\"ABSMIDDLE\" border=\"0\" />Radera</a></span>";
			}
			
					$body.= "<span onMouseOver=\"document.skapa_ny_grupp.src='" . $baseUrl . "/img/symbols/gif_red/skapa_ny_grupp.gif'\" onMouseOut=\"document.skapa_ny_grupp.src='" . $baseUrl . "/img/symbols/gif_purple/skapa_ny_grupp.gif'\" style=\"margin-left:15px;\"><a href=\"#noexist\" onClick=\"showPopup('popupAddAlbum');\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skapa_ny_grupp.gif\" name=\"skapa_ny_grupp\" align=\"ABSMIDDLE\" border=\"0\" />Lägg till nytt album</a></span>";
			
	if ( count( $albums ) > 0 )
	{
			$body.= " <span onMouseOver=\"document.ladda_upp_bild2_up.src='" . $baseUrl . "/img/symbols/gif_red/ladda_upp_bild.gif'\" onMouseOut=\"document.ladda_upp_bild2_up.src='" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif'\" style=\"margin-left:15px;\"><a href=\"#noexist\" onClick=\"showPopup('popupUploadPhoto2');\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif\" border=\"0\" align=\"ABSMIDDLE\" name=\"ladda_upp_bild2_up\" />&nbsp;&nbsp;Ladda upp bilder / film</a></span>";
	} else {
			$body.= " <span onMouseOver=\"document.ladda_upp_bild2_up.src='" . $baseUrl . "/img/symbols/gif_red/ladda_upp_bild.gif'\" onMouseOut=\"document.ladda_upp_bild2_up.src='" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif'\" style=\"margin-left:15px;\"><a href=\"#noexist\" onClick=\"showPopup('popupAddAlbum');\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif\" border=\"0\" align=\"ABSMIDDLE\" name=\"ladda_upp_bild2_up\" />&nbsp;&nbsp;Ladda upp bilder / film</a></span>";
	}
	$body.= "</div>
&nbsp;</div>";
		}
$body .= "
<p><br>
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px\">";

	reset( $albums );
	if ( count( $albums ) > 0 )
	{
		$i = (int)$_GET["offset"];
		$i2 = 0;
		$printed = 0;
		$body .= "<input type=\"checkbox\" style=\"display:none\" name=\"albumId\" value=\"xx\" checked>";
		while ( list( $key, $value ) = each( $albums ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$i++;

			unset( $onlineTime );
			// Possible date-types: Today, Yesterday, ThisYear, LastYear
			if ( date("Y-m-d", $albums[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$onlineTime = "<div class=\"email_date\">" . "Idag kl " . date( "H:i", $albums[ $key ]["unixTime"] ) . "</div>";
			}
			elseif ( date("Y-m-d", $albums[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$onlineTime = "<div class=\"email_date\">" . "Ig&aring;r kl " . date( "H:i", $albums[ $key ]["unixTime"] ) . "</div>";
			}
			elseif ( date("Y", $albums[ $key ]["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$onlineTime = "<div class=\"email_date\">" . date( "j M Y H:i", $albums[ $key ]["unixTime"] ) . "</div>";
			}
			else
			{
				$onlineTime = "<div class=\"email_date\">" . date( "Y-m-d H:i", $albums[ $key ]["unixTime"] ) . "</div>";
			}



			$body.= "<tr>
 	<td style=\"width: 20px; padding-bottom: 0px; padding-right: 10px\" valign=\"top\" rowspan=\"2\"><input type=\"checkbox\" name=\"albumId\" value=\"" . $key . "\"></td>
 	<td style=\"width: 30px; padding-bottom: 0px; padding-right: 10px\" valign=\"top\" rowspan=\"2\"><a href=\"" . $baseUrl . "/media/album/" . $key . ".html\" style=\"font-weight: normal\">" . $albums[ $key ]["avatar"] . "</a></td>
 	<td style=\"width: 140px;padding-bottom: 0px\" valign=\"top\"><a href=\"" . $baseUrl . "/media/album/" . $key . ".html\">" . stripslashes($albums[ $key ]["name"]) . "</a><br />" . $onlineTime . "
  <p>";
  
 


  $body .= "</p>
 	</td>
  	<td style=\"padding-bottom: 0px\" valign=\"top\"><span class=\"status_history\">" . stripslashes($albums[ $key ]["description"]);

	if ($albums[ $key ]["location"] != "") $body .= "</span><br><span class=\"email_date\">Plats: " . $albums[ $key ]["location"]."</span>";

	$body.= "</div>";
	

$body .= "</td>
 </tr>";
 $body.= "<tr>
 <td colspan=\"2\" style=\"\" valign=\"top\">";
  if ($editMedia == TRUE) {
$body .= "<span onMouseOver=\"document.albumEdit" . $key . ".src='" . $baseUrl . "/img/symbols/gif_red/redigera.gif'\" onMouseOut=\"document.albumEdit" . $key . ".src='" . $baseUrl . "/img/symbols/gif_purple/redigera.gif'\"><a  href=\"#noexist\" onClick=\"showPopup('popupEditAlbum" . $albums[ $key ]["id"] . "');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/redigera.gif\" name=\"albumEdit" . $key . "\" align=\"ABSMIDDLE\" border=\"0\" />Redigera</a></span>";
$body.= "<span onMouseOver=\"document.ladda_upp_bild2_" . $albums[ $key ]["id"] . ".src='" . $baseUrl . "/img/symbols/gif_red/ladda_upp_bild.gif'\" onMouseOut=\"document.ladda_upp_bild2_" . $albums[ $key ]["id"] . ".src='" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif'\" style=\"margin-left:15px;\"><a href=\"#noexist\" onClick=\"showPopup('popupUploadPhoto2');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif\" border=\"0\" align=\"ABSMIDDLE\" name=\"ladda_upp_bild2_" . $albums[ $key ]["id"] . "\" style=\"margin-bottom:3px;\" />&nbsp;&nbsp;Ladda upp bilder / film</a></span>";
  }
 	if ( (int)$_SESSION["rights"] > 3 ) {
		if ($albums[ $key ]["partyAlbum"] == 'YES') {
	$body.= "<span class=\"underlinks\" style=\"margin-left:15px;\"><a href=\"?do=stopParty&albumId=".$key."\">Festalbum av</a></span>";
		} else {
	$body.= "<span class=\"underlinks\" style=\"margin-left:15px;\"><a href=\"?do=setParty&albumId=".$key."\">Festalbum på</a></span>";
		}
			if ($albums[ $key ]["clubAlbum"] == 'YES') {
	$body.= "<span class=\"underlinks\" style=\"margin-left:15px;\"><a href=\"?do=stopClub&albumId=".$key."\">Klubbalbum av</a></span>";
		} else {
	$body.= "<span class=\"underlinks\" style=\"margin-left:15px;\"><a href=\"?do=setClub&albumId=".$key."\">Klubbalbum på</a></span>";
		}

}
 $body .= "</td>
 </tr>";
			$body.= "<tr>
 	<td colspan=\"4\" style=\"padding-top:5px;padding-bottom: 5px; border-bottom: 1px dotted #c8c8c8;\" valign=\"top\">&nbsp;</td>
 </tr>";$body.= "<tr>
 	<td colspan=\"4\" style=\"padding-top:5px;padding-bottom: 5px;\" valign=\"top\">&nbsp;</td>
 </tr>";
 $printed++;
		}
	}
	else
	{
		if ( strlen( $_POST["friendSearchQuery"] ) > 0 )
		{
			$body.= "<tr><td colspan=\"4\">Inga vänner matchade din sökning. (" . htmlentities( stripslashes( $_POST["friendSearchQuery"] ) ) . ")</td></tr>";
		}
		else
		{
			if ( $page == "friends.html" )
			{
				$body.= "<tr><td colspan=\"4\">Inga vänner ännu.</td></tr>";
			}
			elseif ( $page == "friends_updated.html" )
			{
				$body.= "<tr><td colspan=\"4\">Inga nyligen uppdaterade vänner.</td></tr>";
			}
			elseif ( $page == "friends_online.html" )
			{
				$body.= "<tr><td colspan=\"4\">Inga vänner online.</td></tr>";
			}
			elseif ( $page == "friends_common.html" )
			{
				$body.= "<tr><td colspan=\"4\">Inga gemensamma vänner.</td></tr>";
			}
		}
	}

	$body.= "</table>\n\n	<div id=\"divFooterSpace\" style=\"border: 0px\">";

	// Paging
	if (count( $albums ) > 0) {
	if ( count( $albums ) > $numPerPage )
	{
		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/" . $page . "?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&sortBy=" . (int)$_GET["sortBy"] . "\">F&ouml;reg&aring;ende sida</a></div>";
		}
		else
		{
			$body.= "<div id=\"previous\">&nbsp;</div>\n";
		}
		$body.= "<div id=\"middle\" style=\"text-align: center\"><b>" .  (int)$printed . "</b> av <b>". count( $albums ) . "</b></div>\n";
		if ( $i < count( $albums ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/" . $page . "?offset=" . $i . "&sortBy=" . (int)$_GET["sortBy"] . "\">N&auml;sta sida</a></div>";
		}
	}
	else
	{
	
		$body.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>" .  (int)$printed  . "</b> av <b>" . count( $albums ) . "</b></div>\n";		
	}
	}

	$body.= "&nbsp;</div></p></form>

</div>

<div id=\"right\">";
if ( $editMedia == TRUE )
{
	$body.= rightMenu('media');
}
else
{
	$body.= rightMenu('userMedia');
}
$body.= "</div>";

}
?>