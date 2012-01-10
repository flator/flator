<?php
#	ini_set('display_errors','On');
#	error_reporting( 8 );
session_start();

if ( $_SESSION["debug"] == TRUE )
{
	define( "DEBUG_MODE", TRUE );
}
else
{
	define( "DEBUG_MODE", FALSE );
}

/* Set different error_reporting levels for debug mode and live mode */
#if ( DEBUG_MODE == TRUE )
#{
#	ini_set('display_errors','On');
#	error_reporting( 8 );
#}
#else
#{
#	ini_set('display_errors','Off');
#	error_reporting( 0 );
#}

$baseUrl = "http://www.flator.se";
$usedImagesServerPaths = array("/srv/www/htdocs/rwdx/photos/", "/var/www/rwdx/photos/", "/srv/www/htdocs/rwdx/user/", "/var/www/rwdx/user/");

/* Include the database library and open the connection */
include('adodb5/adodb.inc.php');
$DB = NewADOConnection('mysql');
if ( DEBUG_MODE == TRUE )
{
	$DB->debug = TRUE;
}
#$DB->debug = TRUE;
$db->memCache = true;
$db->memCacheHost = "127.0.0.1"; /// $db->memCacheHost = $ip1; will work too
$db->memCachePort = 11211; /// this is default memCache port
$db->memCacheCompress = false; /// Use 'true' to store the item compressed (uses zlib)
$db->cacheSecs = 60*30;
 
$DB->Connect("localhost", "root", "sx53gmQ9", "flator");

	$q = "SELECT id, city from fl_cities ORDER BY id ASC";
	$cities = $DB->CacheGetAssoc( 3600*24, $q, FALSE, TRUE );

if ( (int)$_SESSION["rights"] > 1 )
{
	$q = "SELECT * FROM fl_users WHERE id = " . (int)$_SESSION["userId"];
	$userProfile = $DB->GetRow( $q, FALSE, TRUE );

	$q = "SELECT COUNT(*) newMail FROM fl_messages WHERE newMessage = 'YES' AND deleted = 'NO' AND recipentUserId = " . (int)$_SESSION["userId"] . " GROUP BY recipentUserId";
	$newMessages = $DB->GetRow( $q, FALSE, TRUE );
	$unReadMessages = $newMessages["newMail"];

	if ( $userProfile["visible"] == "YES" )
	{
		$record = array();
		$record["insDate"] = date("Y-m-d H:i:s");
		$record["userId"] = (int)$_SESSION["userId"];
		$DB->AutoExecute( "fl_users_online", $record, 'INSERT' ); 
		$record = array();

		$record["lastVisibleOnline"] = date("Y-m-d H:i:s");
		$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id =  '.(int)$_SESSION["userId"]); 
	}

	


	$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$_SESSION["userId"] . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
	$lastStatus = $DB->CacheGetRow( 1*60, $q, FALSE, TRUE );
	if ( strlen( $lastStatus["statusMessage"] ) > 0 )
	{
		$userProfile["statusMessage"] = $lastStatus["statusMessage"];
		$userProfile["statusDate"] = $lastStatus["insDate"];
	}
	else
	{
		$userProfile["statusMessage"] = "Skriv direkt här!";
	}


	if ($_POST["type"] == "survey" && $_POST["pollId"] != "" && $_POST["optionId"] != "") {
					$q = "DELETE FROM fl_polls_answers WHERE userId = " . (int)$userProfile["id"] . " AND pollId = '".$_POST["pollId"]."'";
					$DB->Execute( $q );
					$record = array();
					$record["insDate"] = date( "Y-m-d H:i:s" );
					$record["userId"] = (int)$userProfile["id"];
					$record["pollId"] = addslashes($_POST["pollId"]);
					$record["optionId"] = addslashes($_POST["optionId"]);
					$DB->AutoExecute( "fl_polls_answers", $record, 'INSERT');
	}
	
	$q = "SELECT * FROM fl_polls WHERE active = 'YES' ORDER BY insDate DESC LIMIT 1";
	$currPoll = $DB->CacheGetRow( 20*60, $q, FALSE, TRUE );
	if ((int)$currPoll["id"] > 0) {
		$q = "SELECT * FROM fl_polls_options WHERE pollId = '".(int)$currPoll["id"]."' ORDER BY ID ASC";
		$currPollOptions = $DB->CacheGetAssoc( 20*60, $q, FALSE, TRUE );

		if (count($currPollOptions) > 1) {



			$q = "SELECT * FROM fl_polls_answers WHERE userId = '".(int)$userProfile["id"]."' AND pollId = '".(int)$currPoll["id"]."' ORDER BY insDate DESC LIMIT 1";
			$currPollAnswer = $DB->CacheGetRow( 1, $q, FALSE, TRUE );
			if ((int)$currPollAnswer["id"] > 0) {
				$userProfile["currentPoll"] = (int)$currPollAnswer["optionId"];
			} elseif ($currPoll["popup"] == "YES") {
				$displaySurvey = TRUE;
			} elseif ($currPoll["popup"] == "NO") {
				$displaySurveyBox = TRUE;
			}
		}
	}

	$newNotes = FALSE;
	$newFriends = 0;
	$newFlirts = 0;
	$newWall = 0;
	$q = "SELECT fl_friends.*, UNIX_TIMESTAMP( fl_friends.insDate ) AS unixTime, fl_users.username FROM fl_friends LEFT JOIN fl_users ON fl_users.id = fl_friends.userId WHERE fl_friends.approved = 'NO' AND friendUserId = " . (int)$_SESSION["userId"];
	$friendApproveList = $DB->CacheGetAssoc( 1*60, $q, FALSE, TRUE );
	if ( count( $friendApproveList ) > 0 )
	{
		$newNotes = TRUE;
		$newFriends = count( $friendApproveList );
	}


	$q = "SELECT fl_guestbook.*, UNIX_TIMESTAMP( fl_guestbook.insDate ) AS unixTime FROM fl_guestbook WHERE readByOwner = 'NO' AND deleted = 'NO' and recipentUserId = " . (int)$_SESSION["userId"];
	$newWallList = $DB->CacheGetAssoc( 1*60, $q, FALSE, TRUE );
	if ( count( $newWallList ) > 0 )
	{
		$newNotes = TRUE;
		$newWall = count( $newWallList );
	}

	$q = "SELECT fl_flirts.*, UNIX_TIMESTAMP( fl_flirts.insDate ) AS unixTime FROM fl_flirts WHERE seen = 'NO' and recipientUserId = " . (int)$_SESSION["userId"];
	$newFlirtList = $DB->CacheGetAssoc( 1*60, $q, FALSE, TRUE );
	if ( count( $newFlirtList ) > 0 )
	{

		$newFlirts = count( $newFlirtList );
	}
$videoChatInvitations = "";
	

	$q = "SELECT fl_videochat_invitations.*, MAX(fl_videochat_invitations.insDate) as lastDate, fl_users.username as invitingUsername FROM fl_videochat_invitations LEFT JOIN fl_users ON fl_videochat_invitations.invitingUser = fl_users.id WHERE fl_videochat_invitations.invitedUser = " . (int)$_SESSION["userId"] . " AND fl_videochat_invitations.response = 'NA' AND fl_videochat_invitations.insDate > DATE_SUB( NOW(), INTERVAL 900 SECOND) GROUP BY fl_videochat_invitations.invitingUser ";
	$videoChatInvites = $DB->CacheGetAssoc( 3600*24, $q, FALSE, TRUE );
	if ( count( $videoChatInvites ) > 0 )
	{
		/*$videoChatInvitations = "<script type=\"text/javascript\">
 if (confirm(\"";
*/
 $videoChatInvitations = "javascript: if (confirm('";
		$videoChatInvitations .= "Du har fått ".(count( $videoChatInvites ) > 1 ? count( $videoChatInvites )." inbjudningar" : count( $videoChatInvites )." inbjudning")." till att videochatta med: ";
		$iVC = 0;
		while ( list( $key, $value ) = each( $videoChatInvites ) )
		{
			if ($iVC > 0) $videoChatInvitations .=  ", ";
			$videoChatInvitations .=  $videoChatInvites[ $key ]["invitingUsername"];
			$inviteUser = $videoChatInvites[ $key ]["invitingUsername"];
			$iVC++;
		}
		$videoChatInvitations .=  ". Vill du starta videochatten? Tryck på OK. Om du inte vill videochatta, klicka på avbryt.";
		$videoChatInvitations .= "')) {
   window.open('http://www.flator.se/videochatt/?invite_user=".$inviteUser."','videochat','width=800,height=620'); } else {	 return false;  }";
					$record = array();
					$record["response"] = "YES";
					$DB->AutoExecute( "fl_videochat_invitations", $record, 'UPDATE', 'invitedUser = ' . (int)$_SESSION["userId"]);
    $bodyOnload = "onLoad=\"".$videoChatInvitations."\"";
	}












/*

if ($_SESSION["seenInvitations5"] != TRUE) {
$displayInvitations = TRUE;
$_SESSION["seenInvitations5"] = TRUE;
}
*/









}


include( "functions.php" );
include( "sidebar.php" );
?>