<?
include("inc.php");
include("../config.php");
	$q = "SELECT id, city from fl_cities ORDER BY id ASC";
	$cities = $DB->GetAssoc( $q, FALSE, TRUE );
$username=$userProfile["username"];

	$q = "SELECT * FROM fl_images WHERE userId = " . (int)$userProfile["id"] . " AND imageType = 'profileMedium'";
	$profileImage = $DB->GetRow( $q, FALSE, TRUE );
	if ( count( $profileImage ) > 0 )
	{
		$snap = urlencode("/user-photos/".str_replace("http://www.flator.se/rwdx/user/", "", $profileImage["imageUrl"])."/profile-chat/");
	}
	else
	{
		$snap = urlencode("30x30.png".rand(0,1000));

	}

if (!$username) $loggedin=0;else $loggedin=1;

$snap=urlencode("30x30.png?id=".rand(0,1000));
$location=urlencode( $cities[$userProfile["cityId"]]["city"]);
$age=urlencode(((int)$userProfile["currAge"] > 0 ? (int)$userProfile["currAge"] : " "));

?>server=<?=$rtmp_server?>&room=<?=$room_name?>&username=<?=$username?>&psnap=<?=$snap?>&plocation=<?=$location?>&page=<?=$age?>&loggedin=<?=$loggedin?>&loadstatus=1