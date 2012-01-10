<?php
include( "../config.php" );
if (!$_SESSION["rights"]) exit;
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=utf-8");

if (isset($_GET['q']) && $_GET['q'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$search = addslashes($_GET['q']);

		//Get every page title for the site.
		$q = "SELECT * from fl_users WHERE username LIKE '%" . $search . "%' AND rights > 1 ORDER BY username ASC LIMIT 0,10";
	
	$result = mysql_query( $q );
	if ( mysql_errno() > 0 )
	{
		echo "MySQL Error (" . mysql_errno() . "): " . mysql_error() . "\n";
	}
	else
	{
		if ( mysql_num_rows( $result ) > 0 )
		{
			$q = "SELECT id, city from fl_cities ORDER BY id ASC";
			$cities = $DB->GetAssoc( $q, FALSE, TRUE );
			$i = 0;
			echo "<font style=\"font-size:2px;line-height:2px;\">&nbsp;</font>";
			while( $suggest = mysql_fetch_array( $result ) )
			{
				$i++;
				if ( $i == 10 )
				{
					echo "<div style=\"clear:both;color:#A09C96; font-family:verdana; font-size:9px; font-weight:bold; margin-left:4px; margin-top:4px; margin-bottom:4px;\">Maximalt 9 visas h&auml;r, klicka p&aring; f&ouml;rstoringsglaset eller tryck 'enter' f&ouml;r att visa fler.</div>";
				}
				else
				{
					$q = "SELECT * FROM fl_images WHERE userId = " . (int)$suggest["id"] . " AND imageType = 'profileSmall'";
					$guestImage = $DB->GetRow( $q, FALSE, TRUE );
					if ( count( $guestImage ) > 0 )
					{
						//$avatar = "<img src=\"" . $guestImage["imageUrl"] . "\" border=\"0\" width=\"" . ceil($guestImage["width"] / 2) . "\" height=\"" . ceil($guestImage["height"] / 2) . "\" style=\"margin-bottom:2px;  margin-top:2px; margin-right:4px;\" align=\"ABSMIDDLE\" />";
						$guestImage["imageUrl"] = "http://www.flator.se/user-photos/".str_replace("/srv/www/htdocs/rwdx/user/", "", $guestImage["serverLocation"])."/profile-small/";
						$avatar = "<img src=\"" . $guestImage["imageUrl"] . "\" border=\"0\" width=\"45\" height=\"45\" style=\"float:left;margin-bottom:0px;  margin-top:4px; margin-right:4px;\" align=\"left\" />";
					}
					else
					{
						$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avatar_stor.png\" border=\"0\" width=\"45\" height=\"45\" style=\"float:left;margin-bottom:0px;  margin-top:4px; margin-right:4px;\" align=\"left\" />";
					}

					$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$suggest["id"] . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
					$statusRow = $DB->GetRow( $q, FALSE, TRUE );
					
					
					echo "<div id=\"rad".$i."\" style=\"margin-left:0px;padding-left:4px;padding-top:3px; padding-bottom:5px;border-bottom:1px dotted #c8c8c8;cursor:hand;cursor:pointer;height:60px;width:165px;float:left;\" onMouseOver=\"document.getElementById('rad".$i."').style.background='#a35e7b';document.getElementById('rubrik".$i."').style.color='#ffffff';document.getElementById('text".$i."').style.color='#ffffff';\" onMouseOut=\"document.getElementById('rad".$i."').style.background='#ffffff';document.getElementById('rubrik".$i."').style.color='';document.getElementById('text".$i."').style.color='#A09C96';\"  onClick=\"showLoad('tagImg');getContent('tagImg.php?target=tagImg&photoId=".$_GET["photoId"]."&alt=".$_GET["alt"]."&setUser=".(int)$suggest["id"]."');\" align=\"top\">";
					echo "<span style=\"font-size: 11px\"><a id=\"rubrik".$i."\" href=\"javascript:void();\" style=\"text-decoration: none;\">" . $avatar . "";
					echo " ";
#if ( $user_id == 1 ) echo $q;
					echo eregi_replace( $search, "<b>" . $search . "</b>", $suggest["username"] )."</a>";

					$statusMessage = truncate(stripslashes($statusRow["statusMessage"]), 25, "..", TRUE, TRUE);

					$city = htmlentities($cities[ $suggest["cityId"] ]["city"]);
					echo "<br><span style=\"color:#A09C96;font-size:9px; font-family:verdana;\" id=\"text".$i."\">";
					if ((int)$suggest["currAge"] > 0 && strlen($city) > 0) {
					echo $suggest["currAge"]." &aring;r, ".$city."<br />";
					} elseif ((int)$suggest["currAge"] > 0) {
					echo $suggest["currAge"]." &aring;r<br />";
					} elseif (strlen($city) > 0) {
					echo "".$city."<br />";
					}
					echo "";






					echo "".htmlentities($statusMessage, ENT_COMPAT, "ISO-8859-1",FALSE)."</span>";
		
						echo "</span></div>\n";
					
				}
			}
						echo "<div style=\"clear:both;\"></div>\n";
									

		}
		else
		{
			echo "<div style=\"clear:both;color:#A09C96; font-family:verdana; font-size:9px; font-weight:bold; margin-left:4px; margin-top:4px; margin-bottom:4px;\">Klicka p&aring; enter f&ouml;r att spara \"".htmlentities($_GET['q'], ENT_COMPAT, "ISO-8859-1",FALSE)."\" som personen p&aring; bilden.</div>\n";
		}
	}
	echo "";
}

?>