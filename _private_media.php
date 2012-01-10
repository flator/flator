<?php
$metaTitle = "Flator.se - Festbilder - Privata album";
$numPerPage = 50;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/private_media.html";
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
				
				$DB->AutoExecute( "fl_albums", $record, 'INSERT' ); 
				$_POST = array();
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
				
				$DB->AutoExecute( "fl_albums", $record, 'UPDATE', 'id = '.(int)$_POST["albumId"] ); 
				$_POST = array();
			
			$thankoyu = "<li>Albumet <b>" . $_POST["album"] . "</b> har redigerats.</li>\n";
		}

		if ( $_POST["type"] == "uploadPhoto" )
		{
			 ini_set('memory_limit', '100M');  
			 ini_set('max_input_time', '320');
			 ini_set('max_execution_time', '320');

			$folder = '/var/www/rwdx/photos/';
			

			
			$i = 0;
			foreach ($_FILES["bild"]["error"] as $key => $error) {

				$alphanum = "APBHCPDEFGHIJKARLCAMDENSCPRIQPTRSTUVWXYZ123456789";
				$rand = substr(str_shuffle($alphanum), 0, 3);


			

				if ($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES["bild"]["tmp_name"][$key];
					$size = getimagesize($tmp_name);

					list($bild_width, $bild_height) = getimagesize($tmp_name);
					 $imgratio=$bild_width/$bild_height;
					 if ($imgratio>1){
						  $newwidth = 3000;
						  $newheight = 3000/$imgratio;
					 }else{
							 $newheight = 3000;
							 $newwidth = 3000*$imgratio;
					 }
					$name = $_FILES["bild"]["name"][$key];
					$name = str_replace("+", "", $name);
					$newpath = $folder.$name;
					if (file_exists($folder.$name))
						{
										
							$name = $rand.'_'.$name;
							$newpath = $folder.$name; 
						}
					if (move_uploaded_file($tmp_name, $newpath)) {
					//echo "Bild $i laddades upp\n<br>";
					
					 
			 
						$large_max_width = 3000;
				
						
				
					 // ÄNDRA STORLEK PÅ STORA BILDEN
						 if ($size[0] <= $large_max_width) {
						
					 
					  } else {
						
						 createThumb($newpath, $newpath, $newwidth, $newheight);
						
					  }



					if (file_exists($newpath)) {
						


						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						
						
						$record["userId"] = (int)$_SESSION["userId"];
						$record["name"] = addslashes($_POST["name"]);
						$record["description"] = addslashes( $_POST["description"] );
						$record["albumId"] = addslashes( $_POST["album"] );
						$record["imageType"] = "albumPhoto";
						$record["imageUrl"] = addslashes( str_replace($folder, "http://www.flator.se/rwdx/photos/", $newpath) );
						$record["serverLocation"] = addslashes( $newpath );

						$DB->AutoExecute( "fl_images", $record, 'INSERT' ); 
						$record = array();

						$q = "SELECT * FROM fl_albums WHERE id = " . (int)$_POST["album"];
						$album_update_aiid = $DB->GetRow( $q, FALSE );
						if ($album_update_aiid["album_image_id"] == 0) {

							$q = "SELECT * FROM fl_images WHERE albumId = " . (int)$_POST["album"]." AND imageType = 'albumPhoto' order by id desc limit 1";
							$image_update_aiid = $DB->GetRow( $q, FALSE );
							if ((int)$image_update_aiid["id"] > 0) {
								$record["album_image_id"] = $image_update_aiid["id"];
								$DB->AutoExecute( "fl_albums", $record, 'UPDATE', 'id = '.(int)$_POST["album"] ); 
							}

						}
					
						$_POST = array();

					} else {
						echo "Något gick snett.. Kontrollera om din bild hamnade i fotoalbumet, gör ett nytt försök i annat fall!";

					}

					
					
					
					
					
					
					
					
					} else {
						$meddelande = "Något gick snett.. Kontrollera om dina bilder hamnade i fotoalbumet, gör ett nytt försök i annat fall!";

					}


				}
					
					
				
				$i++;


			}


















		}
	}
	$currentLink = array();
	if ( $_GET["sortBy"] == "asc" )
	{
		$q = "SELECT fl_albums.*, UNIX_TIMESTAMP(fl_albums.modifiedDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_albums LEFT JOIN fl_users ON fl_users.id = fl_albums.userId WHERE fl_albums.partyAlbum = 'YES' ORDER BY fl_albums.insDate ASC";
		$albums = $DB->GetAssoc( $q, FALSE, TRUE );
		$currentLink["asc"] = " class=\"current\"";
	}
	elseif ( !$_GET["sortBy"] )
	{
		$q = "SELECT fl_albums.*, UNIX_TIMESTAMP(fl_albums.modifiedDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_albums LEFT JOIN fl_users ON fl_users.id = fl_albums.userId WHERE fl_albums.partyAlbum = 'YES' ORDER BY fl_albums.insDate DESC";
		$albums = $DB->GetAssoc( $q, FALSE, TRUE );
		$currentLink["desc"] = " class=\"current\"";
	}
	elseif ( $_GET["sortBy"] == "visits" )
	{
		$q = "SELECT fl_albums.*, UNIX_TIMESTAMP(fl_albums.modifiedDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_albums LEFT JOIN fl_users ON fl_users.id = fl_albums.userId WHERE fl_albums.partyAlbum = 'YES' ORDER BY fl_albums.noViews DESC";
		$albums = $DB->GetAssoc( $q, FALSE, TRUE );
		$currentLink["visits"] = " class=\"current\"";
	}

	if ( count( $albums ) > 0 )
	{
		while ( list( $key, $value ) = each( $albums ) )
		{
			$q = "SELECT * FROM fl_images WHERE id = " . (int)$albums[ $key ]["album_image_id"] . " AND imageType = 'albumPhoto'";
			$albumImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $albumImage ) > 0 )
			{
				$avatar = "<img src=\"http://www.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumImage["serverLocation"])) . "/small/\" border=\"0\" width=\"61\" height=\"61\" />";
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

$body .= "
<p>
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px;margin-top:0px;\">";

	reset( $albums );
	$printed = 0;
	if ( count( $albums ) > 0 )
	{
		$i = (int)$_GET["offset"];
		$i2 = 0;

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

 	<td style=\"width: 30px; padding-bottom: 10px; padding-right: 10px\" valign=\"top\"><a href=\"" . $baseUrl . "/media/album/" . $key . ".html\" style=\"font-weight: normal\">" . $albums[ $key ]["avatar"] . "</a></td>
 	<td style=\"width: 140px;padding-bottom: 10px\" valign=\"top\"><a href=\"" . $baseUrl . "/media/album/" . $key . ".html\">" . stripslashes($albums[ $key ]["name"]) . "</a><br />" . $onlineTime . "
  <p>";
  
  if ($editMedia == TRUE) {
$body .= "<span onMouseOver=\"document.albumEdit" . $key . ".src='" . $baseUrl . "/img/symbols/gif_red/redigera.gif'\" onMouseOut=\"document.albumEdit" . $key . ".src='" . $baseUrl . "/img/symbols/gif_purple/redigera.gif'\"><a  href=\"#noexist\" onClick=\"showPopup('popupEditAlbum" . $albums[ $key ]["id"] . "');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/redigera.gif\" name=\"albumEdit" . $key . "\" align=\"ABSMIDDLE\" border=\"0\" />Redigera</a></span>";
  }


  $body .= "</p>
 	</td>
  	<td style=\"padding-bottom: 10px\" valign=\"top\">" . stripslashes($albums[ $key ]["description"]);
	
	if ( (int)$_SESSION["rights"] > 3 ) {
		if ($albums[ $key ]["partyAlbum"] == 'YES') {
	$body.= "<div class=\"underlinks\"><a href=\"?do=stopParty&albumId=".$key."\">Inaktivera festalbum</a></div>";
		} else {
	$body.= "<div class=\"underlinks\"><a href=\"?do=setParty&albumId=".$key."\">Aktivera festalbum</a></div>";
		}

}
$body .= "</td>
 </tr>";
			$body.= "<tr>
 	<td colspan=\"4\" style=\"padding-bottom: 0px; border-top: 1px dotted #c8c8c8;\" valign=\"top\">&nbsp;</td>
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
		$body.= "<div id=\"middle\" style=\"text-align: center\"><b>" . (int)$printed . "</b> av <b>". count( $albums ) . "</b></div>\n";
		if ( $i < count( $albums ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/" . $page . "?offset=" . $i . "&sortBy=" . (int)$_GET["sortBy"] . "\">N&auml;sta sida</a></div>";
		}
	}
	else
	{
		$body.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>" . (int)$printed . "</b> av <b>" . count( $albums ) . "</b></div>\n";		
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
	$body.= rightMenu('userPartyMedia');
}
$body.= "</div>";

}
?>