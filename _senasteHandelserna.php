<?php
$metaTitle = "Flator.se - Hem";

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/senasteHandelserna.html";
	include( "login_new.php" );
}
else
{

    $body = "<div id=\"center\">";
// $lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y");
//echo $man; 

	$friends = array();
	unset( $friendList );
	//$q = "SELECT * FROM fl_friends WHERE approved = 'YES' AND (userId = '" . $_SESSION["userId"] . "' OR friendUserId = '" . $_SESSION["userId"] . "')";
	
	//$q = "SELECT * FROM fl_comments WHERE insDate <= '2008-09-07 13:28:51'";
	
	//$q = "SELECT * FROM fl_friends WHERE insDate > '2008-10-03 17:40:25'";
	//$q="SELECT * FROM fl_albums WHERE friends_only='yes'";
	
	$q = "SELECT * FROM fl_comments WHERE type='photoComment' ";
	//AND(friends_only='NO')
	$friendArray = $DB->CacheGetAssoc( 3*60, $q, FALSE, TRUE );
	//var_dump($friendArray);
	
	if ( count( $friendArray ) > 0 )
	{
		while ( list( $key, $value ) = each( $friendArray ) )
		{
			//if ( $friendArray[ $key ]["userId"] != (int)$_SESSION["userId"] )
			//{
			
				$friends[ $friendArray[ $key ]["userId"] ] = $friendArray[ $key ]["userId"];
				if ( strlen( $friendList ) > 0 ) $friendList .= ",";
				$friendList.= $friendArray[ $key ]["userId"];
			//}
			//else
			//{
		//		$friends[ $friendArray[ $key ]["friendUserId"] ] = $friendArray[ $key ]["friendUserId"];
			//	if ( strlen( $friendList ) > 0 ) $friendList .= ",";
		//		$friendList.= $friendArray[ $key ]["friendUserId"];
			//}
		}
	
$q = "SELECT fl_status.*, UNIX_TIMESTAMP(fl_status.insDate) AS unixTime, fl_users.username FROM fl_status left join fl_users on fl_status.userId = fl_users.id WHERE fl_status.userId IN (" . $friendList . ") and fl_status.statusType != 'newPhoto' ORDER BY fl_status.insDate DESC LIMIT 10";
$userStatus = $DB->CacheGetAssoc( 3*60, $q, FALSE, TRUE );

}
if ( count( $userStatus ) > 0 )
{
$body.= "<div style=\"float: left; \"><div style=\"padding-top: 14px; padding-bottom: 3px;border:none; border-bottom: 1px dotted #c8c8c8; width:592px; margin-bottom:10px;\" width=\"595px\"><h3>Senaste H�ndelserna</h3></div></div>";

	$commentedPhotos = array();
	while ( list( $key, $value ) = each( $userStatus ) )
	{
		
		if ($userStatus[ $key ]["statusType"] == "personalMessage") {

			$userStatus[ $key ]["statusMessage"] = "<span class=\"email_date\">Status:</span> ".substr(stripslashes($userStatus[ $key ]["statusMessage"]), 0, 238);

		$q = "SELECT fl_comments.*, UNIX_TIMESTAMP(fl_comments.insDate) AS unixTime, fl_users.username FROM fl_comments LEFT JOIN fl_users ON fl_users.id = fl_comments.userId WHERE fl_comments.contentId = " . (int)$userStatus[ $key ]["id"] . " and fl_comments.type = 'statusComment'  ORDER BY insDate DESC";
		$userStatusComments [ $key ] = $DB->CacheGetAssoc( 1*60, $q, FALSE, TRUE );
		}

		if ($userStatus[ $key ]["statusType"] == "blogEntry") {
		$userStatus[ $key ]["statusMessage"] = str_replace("Nytt blogginl�gg:", "<span class=\"email_date\">Nytt blogginl�gg:</span>", $userStatus[ $key ]["statusMessage"]);
		
			if (strpos($userStatus[ $key ]["statusMessage"], 'html"></a>') > 1) {
				$userStatus[ $key ]["statusMessage"] = str_replace('html"></a>', 'html">Ingen rubrik</a>', $userStatus[ $key ]["statusMessage"]);

			}
		}
		if ($userStatus[ $key ]["statusType"] == "blogComment") {
		$userStatus[ $key ]["statusMessage"] = str_replace("Kommenterade blogginl�gg:", "<span class=\"email_date\">Kommenterade blogginl�gg:</span>", $userStatus[ $key ]["statusMessage"]);
		}
		if ($userStatus[ $key ]["statusType"] == "newFriend") {
		$userStatus[ $key ]["statusMessage"] = str_replace("Blev v�n med:", "<span class=\"email_date\">Blev v�n med:</span>", $userStatus[ $key ]["statusMessage"]);
		}
		if ($userStatus[ $key ]["statusType"] == "addedEvent") {
		$userStatus[ $key ]["statusMessage"] = str_replace("Lade till event", "<span class=\"email_date\">Lade till event:</span>", $userStatus[ $key ]["statusMessage"]);
		}
		
			if ($userStatus[ $key ]["statusType"] == "photoComment") {
				$regex = '/media\/photos\/(.+?)\.html/';
				$match = array();
				preg_match($regex,$userStatus[ $key ]["statusMessage"],$match);
				if (strlen($match[1]) > 0) {
				$userStatus[ $key ]["photoId"] = $match[1];
				
				}

			if (in_array($userStatus[ $key ]["photoId"], $commentedPhotos)) {
			continue;
			}
			$q = "SELECT fl_images.*, UNIX_TIMESTAMP(fl_images.insDate) AS unixTime,  fl_albums.name AS albumName,  fl_users.username AS username FROM fl_images LEFT JOIN fl_albums ON fl_images.albumId = fl_albums.id LEFT JOIN fl_users ON fl_users.id = fl_images.userId WHERE fl_images.id = '" . $userStatus[ $key ]["photoId"] . "'AND friends_only='NO'";
			$commentedPhoto = $DB->CacheGetRow( 3*60, $q, FALSE, TRUE );
			if (count($commentedPhoto) < 1) {
			continue;
			}

			unset( $onlineTime );
			// Possible date-types: Today, Yesterday, ThisYear, LastYear
			if ( date("Y-m-d", $commentedPhoto["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$onlineTime = "" . "Idag " . date( "H:i", $commentedPhoto["unixTime"] ) . "";
			}
			elseif ( date("Y-m-d", $commentedPhoto["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$onlineTime = "" . "Ig&aring;r " . date( "H:i", $commentedPhoto["unixTime"] ) . "";
			}
			elseif ( date("Y", $commentedPhoto["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$onlineTime = "" . date( "j M Y", $commentedPhoto["unixTime"] ) . "";
			}
			else
			{
				$onlineTime = "" . date( "Y-m-d", $commentedPhoto["unixTime"] ) . "";
			}

			$mediumAvatar = $baseUrl."/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $commentedPhoto["serverLocation"])) . "/large/";


			$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $commentedPhoto["serverLocation"])) . "/small-blog/\" border=\"0\" style=\"float:left;\" align=\"left\"/>";
			


			$currentcommentedPhoto = "<div style=\"float:left; margin-right:5px; border: 1px dotted #c8c8c8;padding:4px; \"><a href=\"#noexist\" onClick=\"showImage2('popupMediumCommentedImage".$key."','" . $mediumAvatar . "', 'mediumCommentedImage".$key."');\">".$avatar."</a></div>";


			$commentedPhotos[] = $userStatus[ $key ]["photoId"];
			if (strlen($commentedPhoto["name"]) > 0) {
				if (strlen($commentedPhoto["name"]) > 15) {
					$commentedPhoto["name"] = substr(strip_tags($commentedPhoto["name"]), 0, 13).".."; }
			} else {
				$commentedPhoto["name"] = "<i>Inget namn</i>";
			}


			$userStatus[ $key ]["statusMessage"] = '<a href=\"' . $baseUrl . '/media/photos/'.$commentedPhoto["id"].'.html\"><i>'.$commentedPhoto["name"].'</i></a><span class="email_date"> av </span><a href=\"' . $baseUrl . '/user/'.stripslashes($commentedPhoto["username"]).'.html\">'.$commentedPhoto["username"].'</a> <span class="email_date">uppladdad '.$onlineTime.'</span><br><span class="email_date">Bild ur albumet</span> "<a href="' . $baseUrl . '/media/album/'.$commentedPhoto["albumId"].'.html">'.$commentedPhoto["albumName"].'</a>"';
	
			$userStatus[ $key ]["statusMessage"] .= "<div style=\"position:relative;\"><div id=\"popupMediumCommentedImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px;\"><div style=\"float: left; display: block;\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumCommentedImage".$key."');\"><img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumCommentedImage".$key."\" border=\"0\" style=\"margin: 3px;\" /></a></div></div></div></div>";

			$q = "SELECT fl_comments.*, UNIX_TIMESTAMP(fl_comments.insDate) AS unixTime, fl_users.username FROM fl_comments LEFT JOIN fl_users ON fl_users.id = fl_comments.userId WHERE fl_comments.contentId = " . (int)$userStatus[ $key ]["photoId"] . " and fl_comments.type = 'photoComment' ORDER BY insDate DESC";
			$userStatusComments [ $key ] = $DB->CacheGetAssoc( 3*60, $q, FALSE, TRUE );
			if (count($userStatusComments[ $key ]) < 1) {
			continue;
			}
			}

			if ($userStatus[ $key ]["statusType"] == "tagStatus") {

			$q = "SELECT fl_images.*, UNIX_TIMESTAMP(fl_images.insDate) AS unixTime,  fl_albums.name AS albumName,  fl_users.username AS username FROM fl_images LEFT JOIN fl_albums ON fl_images.albumId = fl_albums.id LEFT JOIN fl_users ON fl_users.id = fl_images.userId WHERE fl_images.id = '" . $userStatus[ $key ]["photoIds"] . "'";
			$commentedPhoto = $DB->CacheGetRow( 3*60, $q, FALSE, TRUE );
			if (count($commentedPhoto) < 1) continue;
			
			if ((int)$userStatus[ $key ]["tagId"] > 0) {
			$q = "SELECT *  FROM `fl_tags` WHERE `id` = '" . $userStatus[ $key ]["tagId"] . "' AND `targetId` = '" . $userStatus[ $key ]["userId"] . "'";
			$confirmTags = $DB->CacheGetRow( 3*60, $q, FALSE, TRUE );
			if (count($confirmTags) < 1) continue;
			}

			
			unset( $onlineTime );
			// Possible date-types: Today, Yesterday, ThisYear, LastYear
			if ( date("Y-m-d", $commentedPhoto["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$onlineTime = "" . "Idag " . date( "H:i", $commentedPhoto["unixTime"] ) . "";
			}
			elseif ( date("Y-m-d", $commentedPhoto["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$onlineTime = "" . "Ig&aring;r " . date( "H:i", $commentedPhoto["unixTime"] ) . "";
			}
			elseif ( date("Y", $commentedPhoto["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$onlineTime = "" . date( "j M Y", $commentedPhoto["unixTime"] ) . "";
			}
			else
			{
				$onlineTime = "" . date( "Y-m-d", $commentedPhoto["unixTime"] ) . "";
			}

			$mediumAvatar = $baseUrl . "/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $commentedPhoto["serverLocation"])) . "/large/";

			$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $commentedPhoto["serverLocation"])) . "/small-blog/\" border=\"0\" style=\"float:left;\" align=\"left\"/>";
			


			$currentcommentedPhoto = "<div style=\"float:left; margin-right:5px; border: 1px dotted #c8c8c8;padding:4px; \"><a href=\"#noexist\" onClick=\"showImage2('popupMediumCommentedImage".$key."','" . $mediumAvatar . "', 'mediumCommentedImage".$key."');\">".$avatar."</a></div>";
			 

			if (strlen($commentedPhoto["name"]) > 0) {
				if (strlen($commentedPhoto["name"]) > 15) {
					$commentedPhoto["name"] = substr(strip_tags($commentedPhoto["name"]), 0, 13).".."; }
			} else {
				$commentedPhoto["name"] = "<i>Inget namn</i>";
			}


			$userStatus[ $key ]["statusMessage"] = '<span class=\"email_date\">Blev taggad i bilden</span> <a href=\"' . $baseUrl . '/media/photos/'.$commentedPhoto["id"].'.html\"><i>'.$commentedPhoto["name"].'</i></a> <span class="email_date">fr�n albumet</span> "<a href="' . $baseUrl . '/media/album/'.$commentedPhoto["albumId"].'.html">'.$commentedPhoto["albumName"].'</a>"<span class="email_date"> av </span><a href=\"' . $baseUrl . '/user/'.stripslashes($commentedPhoto["username"]).'.html\">'.$commentedPhoto["username"].'</a>';
	
			$userStatus[ $key ]["statusMessage"] .= "<div style=\"position:relative;\"><div id=\"popupMediumCommentedImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px;\"><div style=\"float: left; display: block;\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumCommentedImage".$key."');\"><img src=\"".$baseUrl."/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumCommentedImage".$key."\" border=\"0\" style=\"margin: 3px;\" /></a></div></div></div></div>";

			}


			if ($userStatus[ $key ]["statusType"] == "forumEntry") {

			$q = "SELECT fl_forum_threads.*, fl_forum_cat.shortname FROM fl_forum_threads LEFT JOIN fl_forum_cat ON fl_forum_threads.catId = fl_forum_cat.id WHERE fl_forum_threads.id = '" . (int)$userStatus[ $key ]["statusMessage"] . "'";
			$forumThreadEntry = $DB->CacheGetRow( 3*60, $q, FALSE, TRUE );
			if (count($forumThreadEntry) < 1) continue;

			if ($forumThreadEntry["newThread"] == "YES") {
				$userStatus[ $key ]["statusMessage"] = '<span class="email_date">Skapade en ny forumtr�d:</span> <a href="'.$baseUrl.'/forum/'.$forumThreadEntry["shortname"].'/'.$forumThreadEntry["slug"].'.html\">'.$forumThreadEntry["headline"].'</a>.';
			} else {
				$q = "SELECT fl_forum_threads.* FROM fl_forum_threads WHERE id = '" . (int)$forumThreadEntry["threadId"] . "'";
				$forumThreadEntry_base = $DB->CacheGetRow( 3*60, $q, FALSE, TRUE );
				if (count($forumThreadEntry_base) < 1) continue;
				$forumThreadEntry["headline"] = $forumThreadEntry_base["headline"];
				$userStatus[ $key ]["statusMessage"] = '<span class="email_date">Skrev ett inl�gg i forumtr�den:</span> <a href="'.$baseUrl.'/forum/'.$forumThreadEntry["shortname"].'/'.$forumThreadEntry["slug"].'.html\">'.$forumThreadEntry["headline"].'</a>.';

			}



	


			}

	
			if ($userStatus[ $key ]["statusType"] == "newPhotosUploaded") {
			$symbol = '<img src="' . $baseUrl . '/img/symbols/gif_purple/bild.gif" style="vertical-align:top;margin-top:0px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "personalMessage") {
			$symbol = '<img src="' . $baseUrl . '/img/symbols/gif_purple/logga_in.gif" style="vertical-align:top;margin-top:0px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "newFriend") {
			$symbol = '<img src="' . $baseUrl . '/img/symbols/gif_purple/van.gif" style="vertical-align:top;margin-top:0px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "blogEntry") {
			$symbol = '<img src="' . $baseUrl . '/img/symbols/gif_purple/blogg.gif" style="vertical-align:top;margin-top:0px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "blogComment") {
			$symbol = '<img src="' . $baseUrl . '/img/symbols/gif_purple/lamna_kommentar.gif" style="vertical-align:top;margin-top:0px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "addedEvent") {
			$symbol = '<img src="' . $baseUrl . '/img/symbols/gif_purple/typ_av_event.gif" style="vertical-align:top;margin-top:0px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "tagStatus") {
			$symbol = '<img src="' . $baseUrl . '/img/symbols/gif_purple/tagga2.gif" style="vertical-align:top;margin-top:6px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "photoComment") {
			$symbol = '<img src="' . $baseUrl . '/img/symbols/gif_purple/bild.gif" style="vertical-align:top;margin-top:0px;"  border="0">';
			//$symbol = $currentcommentedPhoto;
			} elseif ($userStatus[ $key ]["statusType"] == "forumEntry") {
			$symbol = '<img src="' . $baseUrl . '/img/symbols/gif_purple/grupp.gif" style="vertical-align:top;margin-top:3px;" border="0">';
			} else {
			$symbol = "";
			}

	$body.= "";

			if ($userStatus[ $key ]["statusType"] == "newPhotosUploaded" && $userStatus[ $key ]["photoIds"] != "") {
			

					$q = "SELECT fl_images.*, UNIX_TIMESTAMP(fl_images.insDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_images LEFT JOIN fl_users ON fl_users.id = fl_images.userId WHERE fl_images.id IN (".$userStatus[ $key ]["photoIds"].") ORDER BY fl_images.insDate ASC";

						$albumPhotos = $DB->CacheGetAssoc( 3*60, $q, FALSE, TRUE );
						if ( count( $albumPhotos ) > 0 )
						{
							if ( count( $albumPhotos ) > 1) {
								$photoString = "bilder / filmer"; 
							} else {
									$photoString = "bild / film";
							}
							$body.= "<div style=\"float: left; width: 160px; margin-right: 30px;text-align:right; margin-top:7px;\"><a href=\"" . $baseUrl . "/user/" . stripslashes($userStatus[ $key ]["username"]) . ".html\">".$symbol."</a></div><div style=\"float: left; width: 410px; margin-top:6px;\"><span class=\"presStatus\"> <span class=\"status_history\"><a href=\"" . $baseUrl . "/user/" . stripslashes($userStatus[ $key ]["username"]) . ".html\">".stripslashes($userStatus[ $key ]["username"])."</a>: <span class=\"email_date\">Laddade upp:</span> " . count( $albumPhotos ) . " ".$photoString.".</span> <span class=\"email_date\">" . $eventDate . "</span>\n";

									$body .= "<div style=\"float:left; background: url('" . $baseUrl . "/img/meny_pil_gif.gif') no-repeat 7px 0px; padding-top:10px; margin-top:3px; margin-bottom:5px;\"><div style=\"float:left; padding-top:5px; padding-left:5px; padding-bottom:5px;margin-right:10px; margin-top:0px; border: 1px dotted #c8c8c8; max-width:200px;\">";

									$albumPhotosString = "";
									$i = 1;
							while ( list( $key2, $value2 ) = each( $albumPhotos ) )
							{
							
								$hoverAction = " onMouseOver=\"document.getElementById( 'hover".$key2."').style.display='block'\" onMouseOut=\"document.getElementById( 'hover".$key2."').style.display='none';\"";
								if ( strlen( $albumPhotos[ $key2 ]["serverLocation"] ) > 0 )
								{	
									$thumbcss = "<div class=\"blog_thumbs_hoverImage\" style=\"display:none\" id=\"hover".$key2."\"></div>";
									$marginBetween = "4px";
									$removeThumb = "";
									

									//$body .= '<a href="' . $baseUrl . '/media/photos/'.$albumPhotos[ $key2 ]["id"].'.html">';
									if (($i % 4) == 0) {
									$body .= "<div class=\"blog_thumbs_Image\" OnClick=\"location.href=" . $baseUrl . "/media/photos/".$albumPhotos[ $key2 ]["id"].".html';\" style=\"background: transparent url(" . $baseUrl . "/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key2 ]["serverLocation"])) . "/small-blog/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; margin-right:5px; margin-bottom:".$marginBetween.";\"".$hoverAction.">".$thumbcss."</div>".$removeThumb."<br>";
									} else {
									$body .= "<div class=\"blog_thumbs_Image\" OnClick=\"location.href=" . $baseUrl . "/media/photos/".$albumPhotos[ $key2 ]["id"].".html';\" style=\"background: transparent url(" . $baseUrl . "/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key2 ]["serverLocation"])) . "/small-blog/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;margin-right:5px; margin-bottom:".$marginBetween.";\"".$hoverAction.">".$thumbcss."</div>".$removeThumb."";
									}
									$body .= '</a>';
								}
							}
							
						$body .= "</div></div><div style=\"clear:both; margin:0px;padding:0px;\"></div>";
							$body .= "</span></div>";
						} else {
						
						continue;
						}
		
			} else {

				if ($userStatus[ $key ]["statusType"] == "photoComment") {
				$body.= "<div style=\"float: left; width: 160px; margin-right: 30px;text-align:right; margin-top:7px;\"><a href=\"" . $baseUrl . "/user/" . stripslashes($userStatus[ $key ]["username"]) . ".html\">".$symbol."</a></div><div style=\"float: left; width: 410px; margin-top:6px;\"><span class=\"presStatus\">".$currentcommentedPhoto." <span class=\"status_commentedPhoto\">" . stripslashes( $userStatus[ $key ]["statusMessage"] ) . "</span> \n";
				} elseif ($userStatus[ $key ]["statusType"] == "tagStatus") {
					$body.= "<div style=\"float: left; width: 160px; margin-right: 30px;text-align:right; margin-top:7px;\"><a href=\"" . $baseUrl . "/user/" . stripslashes($userStatus[ $key ]["username"]) . ".html\">".$symbol."</a></div><div style=\"float: left; width: 410px; margin-top:6px;\"><span class=\"presStatus\">".$currentcommentedPhoto." <span class=\"status_commentedPhoto\"><a href=\"" . $baseUrl . "/user/" . stripslashes($userStatus[ $key ]["username"]) . ".html\">".stripslashes($userStatus[ $key ]["username"])."</a>: " . stripslashes( $userStatus[ $key ]["statusMessage"] ) . "</span> <span class=\"email_date\">" . $eventDate . "</span>\n";					
				} else {
				$body.= "<div style=\"float: left; width: 160px; margin-right: 30px;text-align:right; margin-top:7px;\"><a href=\"" . $baseUrl . "/user/" . stripslashes($userStatus[ $key ]["username"]) . ".html\">".$symbol."</a></div><div style=\"float: left; width: 410px; margin-top:6px;\"><span class=\"presStatus\"> <span class=\"status_history\"><a href=\"" . $baseUrl . "/user/" . stripslashes($userStatus[ $key ]["username"]) . ".html\">".stripslashes($userStatus[ $key ]["username"])."</a>: " . stripslashes( $userStatus[ $key ]["statusMessage"] ) . "</span> <span class=\"email_date\">" . $eventDate . "</span>\n";
				}




					if (($userStatus[ $key ]["statusType"] == "personalMessage") && (count($userStatusComments [ $key ]) < 1)) {
					
					$body .= "<a href=\"#noexist\" class=\"commentLink\" onClick=\"document.getElementById('writeComment".$key."').style.display='none';document.getElementById('statusComment".$key."').style.display='block';return false\" id=\"writeComment".$key."\">Kommentera</a>";

					}
			$body .= "<br></span>";
				$body.= "</div>";
	
			if (count($userStatusComments[$key]) > 0) {
					$body .= "<div style=\"float:left; background: url(".$baseUrl."'/img/meny_pil_gif.gif') no-repeat 0px 0px; padding-top:8px;margin-top:4px;margin-left:190px; \" id=\"statusComment".$key."\" >";
				while ( list( $key3, $value3 ) = each( $userStatusComments[$key] ) )
					{
					$q = "SELECT * FROM fl_images WHERE userId = " . (int)$userStatusComments[$key][ $key3 ]["userId"] . " AND imageType = 'profileSmall'";
					$guestImage = $DB->CacheGetRow( 20*60, $q, FALSE, TRUE );
					if ( count( $guestImage ) > 0 )
					{
						
						$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace($baseUrl.'/rwdx/user/', '', $guestImage["imageUrl"]) . "/profile-thumb/" . "\" border=\"0\" style=\"margin-bottom:8px; margin-left:4px;margin-top:8px; margin-right:5px;\"  />";

					}
					else
					{
						$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" style=\"margin-bottom:8px; margin-left:4px;margin-top:8px; margin-right:5px;\" />";
					}

					$q = "SELECT * FROM fl_images WHERE userId = " . (int)$userStatusComments[$key][ $key3 ]["userId"] . " AND imageType = 'profileMedium'";
					$guestImage = $DB->CacheGetRow( 20*60, $q, FALSE, TRUE );
					if ( count( $guestImage ) > 0 )
					{
						$mediumAvatar = $guestImage["imageUrl"];
					}
					else
					{
						$mediumAvatar = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
					}


					unset( $wallDate );
					if ( date("Y-m-d", $userStatusComments[$key][ $key3 ]["unixTime"] ) == date( "Y-m-d" ) )
					{
						// Event updated today
						$wallDate = "idag " . date( "H:i", $userStatusComments[$key][ $key3 ]["unixTime"] );
					}
					elseif ( date("Y-m-d", $userStatusComments[$key][ $key3 ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
					{
						// Event updated yesterday
						$wallDate = "ig&aring;r " . date( "H:i", $userStatusComments[$key][ $key3 ]["unixTime"] );
					}
					elseif ( date("Y", $userStatusComments[$key][ $key3 ]["unixTime"] ) == date( "Y" ) )
					{
						// Event updated this year
						$wallDate = date( "d", $userStatusComments[$key][ $key3 ]["unixTime"] ) . " " . strtolower( months( (int)date( "m", $userStatusComments[$key][ $key3 ]["unixTime"] ) ) ) . ", " . date( "H:i", $userStatusComments[$key][ $key3 ]["unixTime"] );
					}
					else
					{
						$wallDate = date( "d", $userStatusComments[$key][ $key3 ]["unixTime"] ) . " " . strtolower( months( (int)date( "m", $userStatusComments[$key][ $key3 ]["unixTime"] ) ) ) . " " . date( "Y, H:i", $userStatusComments[$key][ $key3 ]["unixTime"] );
					}
					
					$body .= "<table width=\"402px\" border=\"0\" cellpadding=\"0px\" cellspacing=\"0px\" style=\"margin-left:0px; border: 1px dotted #c8c8c8; margin-top:0px;padding-top:0px;border-bottom:0px; \">";
					$body .= "<tr style=\" width:100%;\">";
					$body .= "<td width=\"\" valign=\"top\"><center><a href=\"#noexist\" onClick=\"showImage2('popupMediumStatusImage".$key."','" . $mediumAvatar . "', 'mediumStatusImage".$key."');\" style=\"font-weight: normal\">" . $avatar . "</a></center>";
						$body .= "<div style=\"position:relative;\"><div id=\"popupMediumStatusImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px;\"><div style=\"float: left; display: block;\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumStatusImage".$key."');\"><img src=\"".$baseUrl."/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumStatusImage".$key."\" border=\"0\" style=\"margin: 3px;\" /></a></div></div></div></div>";
						$body .= "</td>";
					$body .= "<td width=\"100%\" valign=\"top\" style=\"font-size:12px;overflow:hidden;line-height:17px;padding-top:8px;\"><a href=\"" . $baseUrl . "/user/" . $userStatusComments[$key][ $key3 ]["username"] . ".html\">" . $userStatusComments[$key][ $key3 ]["username"] . "</a> <span class=\"email_date\">" . $wallDate . "</span><br />" . $userStatusComments[$key][ $key3 ]["comment"]."</td>";
					
					$body .= "</tr>";
					$body .= "<tr>";
					
					$body .= "</tr>";
					$body .= "</table>";

					$body .= "";




					}


					if ($userStatus[ $key ]["statusType"] == "personalMessage") {
						$newCommentType = "statusComment";
						$statusId = $userStatus[ $key ]["id"];
					}
					if ($userStatus[ $key ]["statusType"] == "photoComment") {
						$newCommentType = "photoComment";
						$statusId = $userStatus[ $key ]["photoId"];
					}
					$body .= "<table width=\"402px\" border=\"0\" cellpadding=\"0px\" cellspacing=\"4px\" style=\"margin-left:0px; border: 1px dotted #c8c8c8; margin-top:0px;padding:0px; background-color:#C8C8C8;\">";
					$body .= "<tr style=\" width:100%;\">";
					$body .= "<td width=\"100%\" valign=\"top\" style=\"font-size:12px; background-color:#fff;\" class=\"commentBox\">
					<form method=\"POST\"  style=\"margin: 0px; padding: 0px\">
					<input type=\"hidden\" name=\"type\" value=\"".$newCommentType."\">
					<input type=\"hidden\" name=\"statusId\" value=\"" . $statusId ."\">
					<input type=\"text\" class=\"txtSearch\" name=\"comment\"  value=\"Skriv en kommentar\" onfocus=\"changeValueTemp(this);\" onblur=\"changeValueTemp(this);\" style=\"width: 342px;color:#A1A199; font-size:12px; margin-top:1px;\" />
<input type=\"submit\" name=\"Skicka\" value=\"\" class=\"btnSearch\" /></form></td>";
					$body .= "</tr>";
					$body .= "</table> </div>";
				


				} else {
				if ($userStatus[ $key ]["statusType"] == "personalMessage") { 
				
					$body .= "<div style=\"float:left; background: url(".$baseUrl."'/img/meny_pil_gif.gif') no-repeat 0px 0px; padding-top:0px;display:none; margin-left:190px; \" id=\"statusComment".$key."\" ><table width=\"402px\" border=\"0\" cellpadding=\"0px\" cellspacing=\"4px\" style=\"margin-left:0px; border: 1px dotted #c8c8c8; margin-top:10px;padding:0px; background-color:#C8C8C8;\">";
					$body .= "<tr style=\" width:100%;\">";
					$body .= "<td width=\"100%\" valign=\"top\" style=\"font-size:12px; background-color:#fff;\" class=\"commentBox\">
					<form method=\"POST\"  style=\"margin: 0px; padding: 0px\">
					<input type=\"hidden\" name=\"type\" value=\"statusComment\">
					<input type=\"hidden\" name=\"statusId\" value=\"" . $userStatus[ $key ]["id"] ."\">
					<input type=\"text\" class=\"txtSearch\" name=\"comment\"  value=\"Skriv en kommentar\" onfocus=\"changeValueTemp(this);\" onblur=\"changeValueTemp(this);\" style=\"width: 342px;color:#A1A199; font-size:12px; margin-top:1px;\" />
<input type=\"submit\" name=\"Skicka\" value=\"\" class=\"btnSearch\" /></form></td>";
					$body .= "</tr>";
					$body .= "</table></div>";
			}
				}



			}
				$body .= "<div style=\"clear:both; margin:0px;padding:0px;height:8px;\"></div>";
	}
}








$body.= "<div style=\"clear:both\">&nbsp;</div><br><br><br>
</p>
<br><br>
</div></div>

<div id=\"right\">";

	$body.= rightMenu('frontpage');
	$body.= "</div>";

}
?>