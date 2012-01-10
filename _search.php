<?php
$metaTitle = "Flator.se - Sök";
$numPerPage = 100;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/search.html";
	include( "login_new.php" );
}
else
{

	if ( $_REQUEST["SearchQuery"] == "" && $_GET["SearchQuery"] != "") $_REQUEST["SearchQuery"] = urldecode($_GET["SearchQuery"]);
	if ( $_REQUEST["city_id"] == "" && $_GET["city_id"] != "") $_REQUEST["city_id"] = $_GET["city_id"];
	if ( $_REQUEST["highAge"] == "" && $_GET["highAge"] != "") $_REQUEST["highAge"] = $_GET["highAge"];
	if ( $_REQUEST["lowAge"] == "" && $_GET["lowAge"] != "") $_REQUEST["lowAge"] = $_GET["lowAge"];
	if ( $_REQUEST["type"] == "" && $_GET["type"] != "") $_REQUEST["type"] = $_GET["type"];
	if ( $_REQUEST["SearchQuery"] == "Sök flata (se alla = enter)" ) unset( $_REQUEST["SearchQuery"] );
	if ( $_REQUEST["SearchQuery"] == "" && $_GET["order"] == "") $_GET["order"] = "loginTime";

	if ( $_REQUEST["type"] == "advSearch" ) {

		if ((int)$_REQUEST["city_id"] > 0) {
			$city_query = "AND cityId = ".(int)$_REQUEST["city_id"];
			$urlParams .= "&city_id=".(int)$_REQUEST["city_id"];
		} else {
			$city_query = "";
		}
		$specific_query = "fl_users.username LIKE '%" . addslashes( $_REQUEST["SearchQuery"] ) . "%' AND currAge <= " . addslashes( $_REQUEST["highAge"] ) . " AND currAge >= " . addslashes( $_REQUEST["lowAge"] ) . " ".$city_query;
		if ($_GET["order"] == "") $_GET["order"] = "loginTime";
		$urlParams .= "&lowAge=".(int)$_REQUEST["lowAge"]."&highAge=".(int)$_REQUEST["highAge"];
		$urlParams .= "&type=advSearch";
		





	$record = array();
	$record["insDate"] = date("Y-m-d H:i:s");
	$record["userId"] = (int)$userProfile["id"];
	$record["searchUrl"] = addslashes($baseUrl.$_SERVER["REQUEST_URI"]);
	if (strlen($_REQUEST["SearchQuery"]) > 0) {
	$record["searchDesc"] .= "\"".addslashes($_REQUEST["SearchQuery"])."\", ";
	}
	if ( (int)$_REQUEST["city_id"] < 1) {
	$searchCity = "Hela Sverige";
	} else {
	$searchCity = $cities[(int)$_REQUEST["city_id"]]["city"];
	}
	$record["searchDesc"] .= $searchCity;
	$record["searchDesc"] .= ", ".(int)$_REQUEST["lowAge"]." - ".(int)$_REQUEST["highAge"]." år";
	$DB->AutoExecute( "fl_searches", $record, 'INSERT' ); 




	} else {
#	if ( $_REQUEST["SearchQuery"] == "danielsHemligaSök" )
#	{
#		$q = "SELECT * FROM fl_users WHERE rights > 1";
##echo $q;
#		$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
#	}
#	elseif ( strlen( $_REQUEST["SearchQuery"] ) > 2 )
#	{
$specific_query = "fl_users.username LIKE '%" . addslashes( $_REQUEST["SearchQuery"] ) . "%'";
}

$limitQuery = " LIMIT ".((int)$_GET["offset"] > 0 ? (int)$_GET["offset"].', '.$numPerPage : $numPerPage);
	

	if ( $_GET["order"] == "online" ) {
		$q = "SELECT fl_users.*, UNIX_TIMESTAMP(lastVisibleOnline) AS unixTime FROM fl_users WHERE ".$specific_query." AND fl_users.rights > 1 AND lastVisibleOnline > DATE_SUB( NOW(), INTERVAL 900 SECOND) ORDER BY username ASC, lastVisibleOnline DESC".$limitQuery;
		$countQuery = "SELECT count(id) FROM fl_users WHERE ".$specific_query." AND fl_users.rights > 1 AND lastVisibleOnline > DATE_SUB( NOW(), INTERVAL 900 SECOND)";
		$order = "online";
	
	} elseif ( $_GET["order"] == "loginTime" ) {
		$q = "SELECT fl_users.*, UNIX_TIMESTAMP(lastVisibleOnline) AS unixTime FROM fl_users WHERE ".$specific_query." AND fl_users.rights > 1 ORDER BY lastVisibleOnline DESC".$limitQuery;
		$countQuery = "SELECT count(id) FROM fl_users WHERE ".$specific_query." AND fl_users.rights > 1";
		$order = "loginTime";
	
	} elseif ( $_GET["order"] == "username" ) {
		$order = "abc";
		$q = "SELECT fl_users.* FROM fl_users WHERE ".$specific_query." AND rights > 1 ORDER BY username ASC".$limitQuery;
		$countQuery = "SELECT count(id) FROM fl_users WHERE ".$specific_query." AND fl_users.rights > 1";
	} else {
		$order = "abc";
		$q = "SELECT fl_users.* FROM fl_users WHERE ".$specific_query." AND rights > 1 ORDER BY username ASC".$limitQuery;
		$countQuery = "SELECT count(id) FROM fl_users WHERE ".$specific_query." AND fl_users.rights > 1";
	}
#echo $countQuery;
		
#	}
	#echo $countQuery;
	
	$countResult = $DB->CacheGetRow( 1*60, $countQuery, FALSE, TRUE );

	$searchResult = $DB->CacheGetAssoc( 1*60, $q, FALSE, TRUE );
	if (count($searchResult) == 1 && strlen($_REQUEST["SearchQuery"]) > 1) {
		while ( list( $key, $value ) = each( $searchResult ) )
		{
		redirect($baseUrl ."/user/".$searchResult[ $key ]["username"].".html");
		}
	}


	$body = "<div id=\"center\">
	<div id=\"divHeadSpace\">";
		if ( (int)$_SESSION["rights"] > 1 )
		{
			$body.= "<div id=\"headLinks\" style=\"width: 480px;\">Sortera efter: <a href=\"".$baseUrl."/search.html?SearchQuery=".urlencode($_REQUEST["SearchQuery"])."&order=username".$urlParams."\""; if ($order == "abc") $body .= " class=\"current\""; $body .= ">Bokstavsordning</a> | <a href=\"".$baseUrl."/search.html?SearchQuery=".urlencode($_REQUEST["SearchQuery"])."&order=loginTime".$urlParams."\""; if ($order == "loginTime") $body .= " class=\"current\""; $body .= ">Senast inloggad</a> | <a href=\"".$baseUrl."/search.html?SearchQuery=".urlencode($_REQUEST["SearchQuery"])."&order=online".$urlParams."\""; if ($order == "online") $body .= " class=\"current\""; $body .= ">Endast online</a></div>";
		}
	$body .= "&nbsp;</div>

<p>
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px;\">";
$printed = 0;
	if ( count( $searchResult ) > 0 )
	{

		
		while ( list( $key, $value ) = each( $searchResult ) )
		{
			


			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$searchResult[ $key ]["id"] . " AND imageType = 'profileSmall'";
			$mailImage = $DB->CacheGetRow( 20*60, $q, FALSE, TRUE );
			if ( count( $mailImage ) > 0 )
			{
				$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://www.flator.se/rwdx/user/', '', $mailImage["imageUrl"]) . "/profile-thumb/" . "\" border=\"0\"  />";

			}
			else
			{
				$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
			}

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$searchResult[ $key ]["id"] . " AND imageType = 'profileMedium'";
			$guestImage = $DB->CacheGetRow( 20*60, $q, FALSE, TRUE );
			if ( count( $guestImage ) > 0 )
			{
				$mediumAvatar = $guestImage["imageUrl"];
			}
			else
			{
				$mediumAvatar = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
			}

			$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$searchResult[ $key ]["id"] . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
			$statusRow = $DB->CacheGetRow( 3*60, $q, FALSE, TRUE );
			$searchResult[ $key ]["status"] = $statusRow["statusMessage"];

			$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_users_online WHERE userId = " . (int)$searchResult[ $key ]["id"] . " ORDER BY insDate DESC LIMIT 0,1";
			$onlineRow = $DB->CacheGetRow( 1*60, $q, FALSE, TRUE );
			if ( ( time() - $onlineRow["unixTime"] ) < 900 && $onlineRow["unixTime"] > 0 )
			{
				$searchResult[ $key ]["online"] = "Online";
			}
			else
			{
				if ( $onlineRow["unixTime"] > 0 )
				{
					$searchResult[ $key ]["online"] = $onlineRow["unixTime"];
				}
				else
				{
					$searchResult[ $key ]["online"] = "never";
				}
			}			

			unset( $onlineTime );
			if ( $searchResult[ $key ]["online"] == "Online" )
			{
				$onlineTime = "<div class=\"email_date\">Online</div>";
			} elseif ( $searchResult[ $key ]["online"] == "never" )
			{
				$onlineTime = "<div class=\"email_date\">Aldrig inloggad</div>";
			}
			else
			{
				// Possible date-types: Today, Yesterday, ThisYear, LastYear
				if ( date("Y-m-d", $searchResult[ $key ]["online"] ) == date( "Y-m-d" ) )
				{
					// Message sent today
					$onlineTime = "<div class=\"email_date\">" . "Idag kl " . date( "H:i", $searchResult[ $key ]["online"] ) . "</div>";
				}
				elseif ( date("Y-m-d", $searchResult[ $key ]["online"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
				{
					// Message sent yesterday
					$onlineTime = "<div class=\"email_date\">" . "Ig&aring;r kl " . date( "H:i", $searchResult[ $key ]["online"] ) . "</div>";
				}
				elseif ( date("Y", $searchResult[ $key ]["online"] ) == date( "Y" ) )
				{
					// Message sent this year
					$onlineTime = "<div class=\"email_date\">" . date( "j M Y H:i", $searchResult[ $key ]["online"] ) . "</div>";
				}
				else
				{
					$onlineTime = "<div class=\"email_date\">" . date( "Y-m-d H:i", $searchResult[ $key ]["online"] ) . "</div>";
				}
			}
if ((int)$_SESSION["rights"] > 1) {
$body.= "<tr>
 	<td style=\"width: 60px; padding-bottom: 30px;\" valign=\"top\"><a href=\"javascript:void(null)\" onClick=\"showImage2('popupMediumImage".$key."','" . $mediumAvatar . "', 'mediumProfileImage".$key."');\" style=\"font-weight: normal;\">" . $avatar . "</a></td>
 	<td style=\"padding-bottom: 30px;\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . $searchResult[ $key ]["username"] . ".html\">" . $searchResult[ $key ]["username"] . "</a> " . stripslashes($searchResult[ $key ]["status"]) . "<br />" . $onlineTime;
	$age = $searchResult[ $key ]["currAge"];


	$city = $cities[$searchResult[ $key ]["cityId"]]["city"];
	$body .= "<div class=\"email_date\">";
	if ((int)$age > 0 && strlen($city) > 0) {
	$body .= $age." år, ".$city."<br />";
	} elseif ((int)$age > 0) {
	$body .= $age." år<br />";
	} elseif (strlen($city) > 0) {
	$body .= "".$city."<br />";
	}
	$body .= "</div>";
	
	$body .= "<div style=\"position:relative;\"><div id=\"popupMediumImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px;\"><div style=\"float: left; display: block;\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumImage".$key."');\"><img src=\"".$baseUrl."/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumProfileImage".$key."\" border=\"0\" style=\"margin: 3px;\" /></a></div></div></div></div></td>
 </tr>";
} else {
$body.= "<tr>
 	<td style=\"width: 60px; padding-bottom: 30px;\" valign=\"top\"><a href=\"#noexist\" onClick=\"showImage('popupMediumImage','" . $mediumAvatar . "');\" style=\"font-weight: normal;\">" . $avatar . "</a></td>
 	<td style=\"padding-bottom: 30px;\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . $searchResult[ $key ]["username"] . ".html\">" . $searchResult[ $key ]["username"] . "</a> " . $searchResult[ $key ]["status"] . "<br />" . $onlineTime . "</td>
 </tr>";
}
			
 $printed++;
		}
	}
	else
	{
		$body.= "<tr><td colspan=\"4\">Inga flator matchade din sökning. (" . htmlentities( stripslashes( $_REQUEST["SearchQuery"] ) ) . ")</td></tr>";
	}

	$body.= "</table>\n\n	<div id=\"divFooterSpace\" style=\"border: 0px;\">";


	$body .= pagingButtons($countResult[0], $numPerPage, (int)$_GET["offset"], $printed,  $baseUrl . "/search.html?order=" . $_GET["order"] . "&SearchQuery=" . $_REQUEST["SearchQuery"]);

	$body.= "&nbsp;</div></p></form>

</div>

<div id=\"right\">";
$body.= rightMenu('search');
$body.= "</div>";

}
?>