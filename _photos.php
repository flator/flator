<?php
//$metaTitle = "Flator.se - Mina sidor - Bilder/filmer";
$numPerPage = 50;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/photos.html";
	include( "login_new.php" );
}
else
{
	$currentLink = array();
	if ( $_GET["sortBy"] == "asc" )
	{
		$q = "SELECT fl_images.*, UNIX_TIMESTAMP(fl_images.insDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_images LEFT JOIN fl_users ON fl_users.id = fl_images.userId WHERE fl_images.albumId = " . (int)$currentPhoto["albumId"] . " ORDER BY fl_images.insDate ASC";
		$albumPhotos_pre = $DB->GetAssoc( $q, FALSE, TRUE );
		$currentLink["asc"] = " class=\"current\"";
	}
	elseif ( !$_GET["sortBy"] )
	{
		$q = "SELECT fl_images.*, UNIX_TIMESTAMP(fl_images.insDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_images LEFT JOIN fl_users ON fl_users.id = fl_images.userId WHERE fl_images.albumId = " . (int)$currentPhoto["albumId"] . " ORDER BY fl_images.insDate DESC";
		$albumPhotos_pre = $DB->GetAssoc( $q, FALSE, TRUE );
		$currentLink["desc"] = " class=\"current\"";
	}
	elseif ( $_GET["sortBy"] == "visits" )
	{
		$q = "SELECT fl_images.*, UNIX_TIMESTAMP(fl_images.insDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_images LEFT JOIN fl_users ON fl_users.id = fl_images.userId WHERE fl_images.albumId = " . (int)$currentPhoto["albumId"] . " ORDER BY fl_images.noViews DESC";
		$albumPhotos_pre = $DB->GetAssoc( $q, FALSE, TRUE );
		$currentLink["visits"] = " class=\"current\"";
	}

	
$i = 1;
	while ( list( $key, $value ) = each( $albumPhotos_pre ) )
	{
		$albumPhotos[$i] = $value;

		if ($value["id"] == $currentPhoto["id"]) {
		$currentPhoto["number"] = $i;
		$albumPhotos[$i]["current"] = TRUE;
		}
		if ($value["id"] == $currentAlbum["album_image_id"]) {
		$albumPhotos[$i]["ai"] = TRUE;
		}
		$i++;
	}

		$q = "SELECT fl_albums.*, UNIX_TIMESTAMP(fl_albums.modifiedDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_albums LEFT JOIN fl_users ON fl_users.id = fl_albums.userId WHERE fl_albums.userId = " . (int)$userPres["id"] . " ORDER BY fl_albums.insDate DESC";
		$albums = $DB->GetAssoc( $q, FALSE, TRUE );

		$q = "SELECT fl_comments.*, UNIX_TIMESTAMP(fl_comments.insDate) AS unixTime, fl_users.username FROM fl_comments LEFT JOIN fl_users ON fl_users.id = fl_comments.userId WHERE fl_comments.type = 'photoComment' AND fl_comments.contentId = " . (int)$currentPhoto["id"] . " AND fl_users.rights > 2 ORDER BY fl_comments.insDate DESC";
		$comments = $DB->GetAssoc( $q, FALSE, TRUE );
		/*
			if (($_GET["size"] == "") || ($_GET["size"] == "medium")) {
			$size = "medium";
			$altSize = "large";
			} elseif ($_GET["size"] == "large") {
			$size = $_GET["size"];
			$altSize = "medium";
			}


			$currentImage = "<a href=\"".$baseUrl."/media/photos/".$currentPhoto["id"].".html?size=".$altSize."\"><img src=\"http://www.flator.se/user-photos/" . urlencode(str_replace("/srv/www/htdocs/rwdx/photos/", "", $currentPhoto["serverLocation"])) . "/".$size."/\" border=\"0\" style=\"margin-top:0px;\"/></a><br><font class=\"news_headline\">".$currentPhoto["name"]."</font>&nbsp;&nbsp;<font class=\"news_type\">".$currentPhoto["description"]."</font>";
*/
	$numPerPage = 9;
			
				if ($currentPhoto["videoLocation"] != "" && $currentPhoto["imageType"] == "albumVideo") {

			$currentImage = '<div id="videocontainer"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</div>
	<script type="text/javascript" src="'.$baseUrl.'/swfobject.js"></script>
	<script type="text/javascript">
		var s1 = new SWFObject("'.$baseUrl.'/mediaplayer.swf","mediaplayer","600","457","8");
		s1.addParam("allowfullscreen","true");
		s1.addParam("wmode","transparent");
		s1.addVariable("width","600");';
		$currentImage .= '
		s1.addVariable("height","457");
		s1.addVariable("file","'.str_replace($usedImagesServerPaths, $baseUrl."/rwdx/photos/", $currentPhoto["videoLocation"]).'");
		s1.addVariable(\'enablejs\',\'true\');
          s1.addVariable(\'overstretch\',\'fit\');';
		  $currentImage .= '
          s1.addVariable(\'backcolor\',\'0x333333\');
          s1.addVariable(\'frontcolor\',\'0xCCCCCC\');
          s1.addVariable(\'lightcolor\',\'0x009999\');
          s1.addVariable(\'screencolor\',\'0x888888\');
		  s1.addVariable(\'linktarget\', \'_self\');
		s1.addVariable("image",'.$baseUrl . '"/user-photos/' . urlencode(str_replace($usedImagesServerPaths, "", $currentPhoto["serverLocation"])) . '/large/");
		s1.addVariable(\'type\', \'flv\');
		s1.write("videocontainer");
		</script>';

			} else {

			$currentImage = "<img src=\"".$baseUrl . "/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $currentPhoto["serverLocation"])) . "/large/\" border=\"0\" style=\"margin-top:0px;\"/>";

			}


			unset( $onlineTime );
			// Possible date-types: Today, Yesterday, ThisYear, LastYear
			if ( date("Y-m-d", $currentPhoto["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$onlineTime = "" . "Idag " . date( "H:i", $currentPhoto["unixTime"] ) . "";
			}
			elseif ( date("Y-m-d", $currentPhoto["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$onlineTime = "" . "Ig&aring;r " . date( "H:i", $currentPhoto["unixTime"] ) . "";
			}
			elseif ( date("Y", $currentPhoto["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$onlineTime = "" . date( "j M Y", $currentPhoto["unixTime"] ) . "";
			}
			else
			{
				$onlineTime = "" . date( "Y-m-d", $currentPhoto["unixTime"] ) . "";
			}
		

	$body = "<div id=\"center\">
	<div id=\"divHeadSpace\">";




		if (( isCurrentFriend ( (int)$_SESSION["userId"], (int)$userPres["id"] ) == FALSE ) && ((int)$_SESSION["userId"] != (int)$userPres["id"]) && ($currentAlbum["friends_only"] == 'YES'))
		{
		$currentPhoto = array();
		$albumPhotos = array();
		$friendsOnly = TRUE;
		} else {
		
		}



	if ( (int)$currentPhoto["id"] > 0 )
	{
$body .= "
<div class=\"headlinks\" style=\"float:left;\"><span style=\"font-weight:bold;font-color:#645D54;font-size:12px;margin-left:15px;\">".stripslashes($currentPhoto["name"])."</span></div>";

if ($currentPhoto["number"] > 1) {
	$offsetValue = (int)$_GET["offset"];
	if (($currentPhoto["number"]-1) % $numPerPage == 0) {
	$offsetValue = (int)$_GET["offset"]-$numPerPage;
	}
	$prevUrl = $baseUrl . "/media/photos/".$albumPhotos[($currentPhoto["number"]-1)]["id"].".html?offset=" . $offsetValue . "&sortBy=" . $_GET["sortBy"] . "";
	$prevLink = "<span onMouseOver=\"document.pil_vanster.src='" . $baseUrl . "/img/symbols/gif_red/pil_vanster.gif'\" onMouseOut=\"document.pil_vanster.src='" . $baseUrl . "/img/symbols/gif_purple/pil_vanster.gif'\">
				
				<a href=\"".$prevUrl."\">
				<img src=\"" . $baseUrl . "/img/symbols/gif_purple/pil_vanster.gif\" name=\"pil_vanster\" align=\"ABSMIDDLE\" border=\"0\" />Föregående bild
				</a>
				</span> ";
} else {
	$prevUrl = "#noexist";
	$prevLink = "";
}

if ($currentPhoto["number"] < count($albumPhotos)) {

	$offsetValue = (int)$_GET["offset"];
	if ($currentPhoto["number"] % $numPerPage == 0) {
	$offsetValue = $currentPhoto["number"];
	}
	$nextUrl = $baseUrl . "/media/photos/".$albumPhotos[($currentPhoto["number"]+1)]["id"].".html?offset=" . $offsetValue . "&sortBy=" . $_GET["sortBy"] . "";
	$nextLink = "<span onMouseOver=\"document.pil_hoger.src='" . $baseUrl . "/img/symbols/gif_red/pil_hoger.gif'\" onMouseOut=\"document.pil_hoger.src='" . $baseUrl . "/img/symbols/gif_purple/pil_hoger.gif'\"><a href=\"".$nextUrl."\">
				Nästa bild <img src=\"" . $baseUrl . "/img/symbols/gif_purple/pil_hoger.gif\" name=\"pil_hoger\" align=\"ABSMIDDLE\" border=\"0\" />
				</a>
				</span>";
} else {
	$nextUrl = $baseUrl."/media/album/".$currentAlbum["id"].".html";
	$nextLink = "";
}

			$body.= "<div id=\"headLinks\" style=\"float:right;\">
			".$prevLink."
			
			<a href=\"#noexist\" class=\"current\" style=\"margin-left:20px;margin-right:20px;\"> Bild ".$currentPhoto["number"]." av ".count($albumPhotos)."</a>


			
			
			".$nextLink;
			$body .= "</div>";
	}
	$body.= "
&nbsp;</div>
<p>
".$thankoyu."
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px;\"><tbody>";



	include( "imageDisplay.php" );

	$body.= "&nbsp;</div></p>";

	$body .= "
</div>

<div id=\"right\">";
if ( $editMedia == TRUE )
{
	$body.= rightMenu('photo');
}
else
{
	$body.= rightMenu('userPhoto');
}
$body.= "</div>";

}
?>