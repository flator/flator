<?=$_GET["target"]?>[-END-]
<?php
include( "config.php" );


$q = "SELECT * FROM fl_tags WHERE type = 'photo' AND mediaId = '".(int)$_GET["photoId"]."' order by alt ASC";
$tags = $DB->GetAssoc( $q, FALSE, TRUE );

if ($_GET["number"] != "" && $_SESSION["demo"] != TRUE ) {


	$DB->_Execute( "DELETE FROM fl_tags where mediaId = ".(int)$_GET["photoId"] ); 
	$alt = 0;
	if ( count( $tags ) > 0 )
	{
		while ( list( $key, $value ) = each( $tags ) )
		{
			if ($alt >= (int)$_GET["number"]) break;
			$record = array();
			$record["type"] = $tags[ $key ]["type"];
			$record["mediaId"] = $tags[ $key ]["mediaId"];
			$record["targetId"] = $tags[ $key ]["targetId"];
			$record["targetStr"] = $tags[ $key ]["targetStr"];
			$record["xCo"] = $tags[ $key ]["xCo"];
			$record["yCo"] = $tags[ $key ]["yCo"];
			$record["xSize"] = $tags[ $key ]["xSize"];
			$record["ySize"] = $tags[ $key ]["ySize"];
			$record["posStr"] = $tags[ $key ]["posStr"];
			$record["alt"] = $alt;
			$DB->AutoExecute( "fl_tags", $record, 'INSERT'); 
			$alt++;
		}
	}

	while ($alt < (int)$_GET["number"]) {
			$record = array();
			$record["type"] = "photo";
			$record["mediaId"] = (int)$_GET["photoId"];
			$record["targetId"] = 0;
			$record["xCo"] = "0";
			$record["yCo"] = "0";
			$record["xSize"] = "0";
			$record["ySize"] = "0";
			$record["posStr"] = "0";
			$record["alt"] = $alt;
			$DB->AutoExecute( "fl_tags", $record, 'INSERT'); 
			$alt++;

	}


$q = "SELECT * FROM fl_tags WHERE type = 'photo' AND mediaId = '".(int)$_GET["photoId"]."' order by alt ASC";
$tags = $DB->GetAssoc( $q, FALSE, TRUE );
}

if ((int)$_GET["setUser"] > 0 && $_SESSION["demo"] != TRUE ) {
			$record = array();
			$record["targetId"] = (int)$_GET["setUser"];
			$record["targetStr"] = "";
			$record["notified"] = "NO";
			$DB->AutoExecute( "fl_tags", $record, 'UPDATE', 'alt = '.(int)$_GET["alt"].' AND mediaId = '.(int)$_GET["photoId"].' AND type = "photo"'); 

			$q = "SELECT * FROM fl_tags WHERE type = 'photo' AND mediaId = '".(int)$_GET["photoId"]."' order by alt ASC";
			$tags = $DB->GetAssoc( $q, FALSE, TRUE );
}
if (strlen($_GET["setUserStr"]) > 0 && $_SESSION["demo"] != TRUE ) {
			$record = array();
			
			$record["targetId"] = 0;
			$record["notified"] = "NO";
			$record["targetStr"] = addslashes($_GET["setUserStr"]);
			$DB->AutoExecute( "fl_tags", $record, 'UPDATE', 'alt = '.(int)$_GET["alt"].' AND mediaId = '.(int)$_GET["photoId"].' AND type = "photo"'); 

			$q = "SELECT * FROM fl_tags WHERE type = 'photo' AND mediaId = '".(int)$_GET["photoId"]."' order by alt ASC";
			$tags = $DB->GetAssoc( $q, FALSE, TRUE );
}
?>
<table width="100%">
<tr><td align="left" valign="bottom" style="border-bottom: 1px dotted rgb(200, 200, 200);font-size:1px;line-height:1px;">&nbsp;</td></tr></table>

<?
echo "<p style=\"font-size:11px;margin-top:4px;margin-bottom:0px;\">Antal personer p&aring; bilden: <select onchange=\"getContent('tagImg.php?target=".$_GET["target"]."&number='+this.value+'&photoId=".(int)$_GET["photoId"]."');\" style=\"font-size:10px;\">";
$i = 0;
while ($i < 8) {
	if ($i == count($tags)) {
		$str = "selected";
	} else {
		$str = "";
	}
	echo "<option value=\"".$i."\" ".$str.">".$i."</option>";

	$i++;
}
echo "</select></p>";

if (count($tags) > 0) {

		while ( list( $key, $value ) = each( $tags ) )
		{
					if ((int)$tags[$key]["targetId"] > 0) {
						$q = "SELECT * FROM fl_users WHERE id = " . (int)$tags[$key]["targetId"];
						$taggedUser = $DB->GetRow( $q, FALSE, TRUE );
						if ( count( $taggedUser ) > 0 ) {
						
						$userName = stripslashes($taggedUser["username"]);

						$q = "SELECT fl_images.*, fl_users.username FROM fl_images left join fl_users on fl_images.userId = fl_users.id WHERE userId = " . (int)$tags[$key]["targetId"] . " AND imageType = 'profileSmall'";
						$guestImage = $DB->GetRow( $q, FALSE, TRUE );
						if ( count( $guestImage ) > 0 )
						{
							//$avatar = "<img src=\"" . $guestImage["imageUrl"] . "\" border=\"0\" width=\"" . ceil($guestImage["width"] / 2) . "\" height=\"" . ceil($guestImage["height"] / 2) . "\" style=\"margin-bottom:2px;  margin-top:2px; margin-right:4px;\" align=\"ABSMIDDLE\" />";
							$guestImage["imageUrl"] = "http://www.flator.se/user-photos/".str_replace("/srv/www/htdocs/rwdx/user/", "", $guestImage["serverLocation"])."/profile-small/";
							$avatarImg = $guestImage["imageUrl"];
						}
						else
						{
							$avatarImg = $baseUrl . "/img/symbols/gif_avatars/person_avatar_stor.png";
						}


					} else {

						$userName = "Användaren existerar inte.";
					}

					} elseif (strlen($tags[$key]["targetStr"]) > 0) {
		
							$avatarImg = $baseUrl . "/img/symbols/gif_avatars/person_avatar_stor.png";
							$userName = stripslashes($tags[$key]["targetStr"]);
						

					} else {
						$avatarImg = $baseUrl . "/img/symbols/gif_avatars/person_avatar_stor.png";
						$userName = "Ej vald";
					}

					echo "<div id=\"alt".$key."\" style=\"float:left; margin-right:45px;cursor:pointer;\" onClick=\"document.getElementById('alt".$key."').style.borderBottom='1px dotted #c8c8c8';showLoad('tagSearchBox');getContent('tagImgSearch.php?target=tagSearchBox&alt=".$tags[$key]["alt"]."&photoId=".(int)$_GET["photoId"]."');\"><img src=\"" . $avatarImg . "\" border=\"0\" width=\"45\" height=\"45\" style=\"float:left;margin-bottom:0px;  margin-top:4px; margin-right:4px;\" align=\"left\" /><br>
					<p>".htmlentities($userName, ENT_COMPAT, "ISO-8859-1",FALSE)."</p></div>";


		}
}
echo "<div id=\"tagSearchBox\" style=\"clear:both;margin-top:0px;\"></div>
";
?>
<span onMouseOver="document.closeTag.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeTag.src='<?=$baseUrl?>/img/kryss_edit.gif'"><a href="#" onClick="document.getElementById('tagImg').innerHTML='&nbsp;';location.reload(true);"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeTag" border="0" >&nbsp;St&auml;ng</a></span>
