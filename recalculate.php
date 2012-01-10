<?php
include('adodb5/adodb.inc.php');
include('functions.php');
$DB = NewADOConnection('mysql');
if ( DEBUG_MODE == TRUE )
{
	#$DB->debug = TRUE;
}
$DB->Connect("localhost", "root", "sx53gmQ9", "flator");
$q = "SELECT * FROM fl_users ORDER BY username ASC";
#	echo "CurrYear: ".date("Y");
#	echo " CurrMonth: ".date("m");
#	echo " CurrDay: ".date("d");
$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
while ( list( $key, $value ) = each( $searchResult ) )
		{
			$age = 0;
			if ( strlen( $searchResult[ $key ]["personalCodeNumber"]) > 0 )
			{
				$searchResult[ $key ]["personalCodeNumber"] = str_replace( "-", "", $searchResult[ $key ]["personalCodeNumber"] );
				$searchResult[ $key ]["personalCodeNumber"] = str_replace( "+", "", $searchResult[ $key ]["personalCodeNumber"] );
				if ( strlen( $searchResult[ $key ]["personalCodeNumber"] ) == 10 )
				{
					$birthDay = (int)substr( $searchResult[ $key ]["personalCodeNumber"], 4, 2 );
					$birthMonth = strtolower( (int)substr( $searchResult[ $key ]["personalCodeNumber"], 2, 2 )  );
					if ((int)substr( $searchResult[ $key ]["personalCodeNumber"], 0, 2 ) > 10) {
					$birthYear = "19" . substr( $searchResult[ $key ]["personalCodeNumber"], 0, 2 );
					} else {
					$birthYear = "20" . substr( $searchResult[ $key ]["personalCodeNumber"], 0, 2 );
					}
				}
				elseif ( strlen( $searchResult[ $key ]["personalCodeNumber"] ) == 12 )
				{
					$birthDay = (int)substr( $searchResult[ $key ]["personalCodeNumber"], 6, 2 );
					$birthMonth = strtolower( (int)substr( $searchResult[ $key ]["personalCodeNumber"], 4, 2 )  );
					$birthYear = substr( $searchResult[ $key ]["personalCodeNumber"], 0, 4 );
				}
				elseif ( strlen( $searchResult[ $key ]["personalCodeNumber"] ) == 8 )
				{
					$birthDay = (int)substr( $searchResult[ $key ]["personalCodeNumber"], 6, 2 );
					$birthMonth = strtolower( (int)substr( $searchResult[ $key ]["personalCodeNumber"], 4, 2 )  );
					$birthYear = substr( $searchResult[ $key ]["personalCodeNumber"], 0, 4 );
				}
				$age = GetAge($birthYear, $birthMonth, $birthDay);
			}
				#echo "UserId: ".(int)$searchResult[ $key ]["id"]." Birthday: $birthDay Month: $birthMonth Year: $birthYear Age: $age"."<br>\n";
				$record = array();	
				if ($searchResult[ $key ]["approved"] == "YES" && strlen($searchResult[ $key ]["personalCodeNumber"]) > 0) {
				$record["personalCodeNumber"] = $birthYear.(strlen($birthMonth) > 1 ? $birthMonth : "0".$birthMonth).(strlen($birthDay) > 1 ? $birthDay : "0".$birthDay);
				}
				$record["currAge"] = $age;
				$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = '.(int)$searchResult[ $key ]["id"] ); 

		}










$searchResult = array();
$q = "SELECT *  FROM fl_tags WHERE notified = 'NO' AND type = 'photo' AND targetId > 0";

$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
while ( list( $key, $value ) = each( $searchResult ) )
		{
			
				
				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["userId"] = (int)$searchResult[ $key ]["targetId"];
				$record["statusMessage"] = "Blev taggad";
				$record["photoIds"] = (int)$searchResult[ $key ]["mediaId"];
				$record["mostRecent"] = "NO";
				$record["statusType"] = "tagStatus";
				$record["private"] = "NO";
				$record["tagId"] = (int)$searchResult[ $key ]["id"];
				$DB->AutoExecute( "fl_status", $record, 'INSERT' ); 
				
				
				$record = array();
				$record["notified"] = "YES";
				$DB->AutoExecute( "fl_tags", $record, 'UPDATE', 'id = '.(int)$searchResult[ $key ]["id"] ); 

		}




















			$configuration = array();
			$q = "SELECT * FROM fl_configuration";
			$row = $DB->GetAssoc( $q, FALSE, TRUE );
			if ( count( $row ) > 0 )
			{
				while ( list( $key, $value ) = each( $row ) )
				{
					$configuration[ $row[ $key ]["type"] ] = $row[ $key ]["value"];
				}
			}



$searchResult = array();
$q = "SELECT * FROM fl_users WHERE fl_users.rights > 1 AND fl_users.reminded = 'NO' AND lastLogin < DATE_SUB(NOW(), INTERVAL 1 MONTH) AND lastLogin > DATE_SUB(NOW(), INTERVAL 2 MONTH) AND insDate < DATE_SUB(NOW(), INTERVAL 1 MONTH) ORDER BY lastLogin DESC";

$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
if (count($searchResult) > 0) {
while ( list( $key, $value ) = each( $searchResult ) )
		{
				$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["weMissYou"];
				$row = $DB->GetRow( $q, FALSE, TRUE );
				if ( count( $row ) > 0 )
				{
					$message = $row["content"];
					$subject = $row["subject"];
					if ( strlen( $subject ) < 1 )
					{
						$subject = "Snygging, vi saknar dig!";
					}
					$tmpMessage = $message;
					$tmpMessage = str_replace( "{username}", $searchResult[ $key ]["username"], $tmpMessage );
					$tmpMessage = str_replace( "{missingTime}", "en hel månad", $tmpMessage );
					$tmpMessage = str_replace( "{extraText}", "", $tmpMessage );
					// Send email
					sendMail( $searchResult[ $key ]["email"], "crew@flator.se", "Flator.se Crew", $subject, $tmpMessage );

					$record = array();
					$record["insDate"] = date( "Y-m-d H:i:s" );
					$record["emailType"] = "email";
					$record["recipientUserId"] = $searchResult[ $key ]["id"];
					$record["email"] = $searchResult[ $key ]["email"];
					$record["message"] = $tmpMessage;
					$DB->AutoExecute("fl_email_log", $record, 'INSERT');
					
					$record = array();
					$record["reminded"] = "YES";
					$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . $searchResult[ $key ]["id"] );

				}
		}
}



$searchResult = array();
$q = "SELECT * FROM fl_users WHERE fl_users.rights > 1 AND fl_users.reminded2 = 'NO' AND lastLogin < DATE_SUB(NOW(), INTERVAL 2 MONTH) AND lastLogin > DATE_SUB(NOW(), INTERVAL 3 MONTH) AND insDate < DATE_SUB(NOW(), INTERVAL 2 MONTH) ORDER BY lastLogin DESC";

$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
if (count($searchResult) > 0) {
while ( list( $key, $value ) = each( $searchResult ) )
		{
				$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["weMissYou"];
				$row = $DB->GetRow( $q, FALSE, TRUE );
				if ( count( $row ) > 0 )
				{
					$message = $row["content"];
					$subject = $row["subject"];
					if ( strlen( $subject ) < 1 )
					{
						$subject = "Snygging, nu har vi väntat länge nog!";
					}
					$tmpMessage = $message;
					$tmpMessage = str_replace( "{username}", $searchResult[ $key ]["username"], $tmpMessage );
					$tmpMessage = str_replace( "{missingTime}", "två hela månader", $tmpMessage );
					$tmpMessage = str_replace( "{extraText}", "Du har väl inte missat allt nytt som är på gång på sajten? Det blåser nya vindar och kommer hända mycket de närmsta veckorna, in och kika i forumet för att följa våra diskussioner vetja!", $tmpMessage );
					// Send email
					sendMail( $searchResult[ $key ]["email"], "crew@flator.se", "Flator.se Crew", $subject, $tmpMessage );

					$record = array();
					$record["insDate"] = date( "Y-m-d H:i:s" );
					$record["emailType"] = "email";
					$record["recipientUserId"] = $searchResult[ $key ]["id"];
					$record["email"] = $searchResult[ $key ]["email"];
					$record["message"] = $tmpMessage;
					$DB->AutoExecute("fl_email_log", $record, 'INSERT');
					
					$record = array();
					$record["reminded2"] = "YES";
					$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . $searchResult[ $key ]["id"] );

				}
		}
}




$searchResult = array();
$q = "SELECT * FROM fl_users WHERE fl_users.rights > 1 AND fl_users.reminded3 = 'NO' AND lastLogin < DATE_SUB(NOW(), INTERVAL 3 MONTH) AND lastLogin > DATE_SUB(NOW(), INTERVAL 4 MONTH) AND insDate < DATE_SUB(NOW(), INTERVAL 3 MONTH) ORDER BY lastLogin DESC";

$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
if (count($searchResult) > 0) {
while ( list( $key, $value ) = each( $searchResult ) )
		{
				$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["weMissYou"];
				$row = $DB->GetRow( $q, FALSE, TRUE );
				if ( count( $row ) > 0 )
				{
					$message = $row["content"];
					$subject = $row["subject"];
					if ( strlen( $subject ) < 1 )
					{
						$subject = "Snygging, var är du!?";
					}
					$tmpMessage = $message;
					$tmpMessage = str_replace( "{username}", $searchResult[ $key ]["username"], $tmpMessage );
					$tmpMessage = str_replace( "{missingTime}", "tre långa månader", $tmpMessage );
					$tmpMessage = str_replace( "{extraText}", "Du har väl inte missat allt nytt som är på gång på sajten? Det blåser nya vindar och kommer hända mycket de närmsta veckorna, in och kika i forumet för att följa våra diskussioner vetja!", $tmpMessage );
					// Send email
					sendMail( $searchResult[ $key ]["email"], "crew@flator.se", "Flator.se Crew", $subject, $tmpMessage );

					$record = array();
					$record["insDate"] = date( "Y-m-d H:i:s" );
					$record["emailType"] = "email";
					$record["recipientUserId"] = $searchResult[ $key ]["id"];
					$record["email"] = $searchResult[ $key ]["email"];
					$record["message"] = $tmpMessage;
					$DB->AutoExecute("fl_email_log", $record, 'INSERT');
					
					$record = array();
					$record["reminded3"] = "YES";
					$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . $searchResult[ $key ]["id"] );

				}
		}
}





if ($alwaysFalse == TRUE) {
define("END_OF_LINE_MARKER", "\r\n");
$q = "SELECT * FROM fl_users WHERE checkedId = 'NO' ORDER BY id DESC";
$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
if (count($searchResult > 1)) {
while ( list( $keyPC, $valuePC ) = each( $searchResult ) )
		{
			#echo "Personnummer: ".$searchResult[ $keyPC ]["personalCodeNumber"]."<br>";
			$checkUrl = "http://www.upplysning.se/";
			if ( $searchResult[ $keyPC ]["personalCodeNumber"] != "") {
				$name = "";
				$name2 = "";
				$searchkey = "";
			$parsed = parse_url($checkUrl);
			if ($parsed["host"] != $host) $cookies = array();
			$host = $parsed["host"];
			$port = ($parsed["port"] > 0) ? $parsed["port"]:"80";
			$path = ($parsed["path"]) ? $parsed["path"]:"/";
			if ($parsed["query"]) $parsed["query"] = str_replace("&amp;", "&", $parsed["query"]);
			$path.= ($parsed["query"]) ? "?".$parsed["query"]:"";
			if (substr($url, -1, 1) == "?") {
				$path .= "?";
			}

			$out = "GET ".$path." HTTP/1.0".END_OF_LINE_MARKER;
			$out.= "Accept: */*\r\n";
			$out.= "User-Agent: ".$user_agent.END_OF_LINE_MARKER;
#			$out.= "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)\r\n";
			$out.= "Host: ".$host.END_OF_LINE_MARKER;
			$out.= "Connection: Close\r\n";

			$out.= END_OF_LINE_MARKER;
			//echo $out;
			$content = array();
			$timeout = 10;
			 
			if ($fp = @fsockopen($host, $port, $errno, $errstr, 5)) {
			fwrite($fp, $out);
			unset($data);
			unset($found_header);


			stream_set_blocking($fp, FALSE );
			

			//echo "Initiating download - Memory used: " . number_format(memory_get_usage()) . "<br />\n";
			$start= time();

			while (!feof($fp)) {
			$data = fgets($fp);
			  if (!feof($fp)) {
					if (eregi("Content-type:", $data) && !$found_header) {
					if (!eregi("Content-type: text/", $data)) {
						
						break;
					} else {
						$found_header = TRUE;
					}
				}
				if ($data != "") {
				$content[] = $data;
				$data = "";
				}
			  }
			 }
			//echo "After download - Memory used: " . number_format(memory_get_usage()) . "<br />\n";
//print_r($content);
			fclose($fp);
			if (count($content) > 0) {
			unset($header);
			unset($body);
			while (list ($key, $value) = each ($content)) {
				if (!$body && $value != "\r\n") {
					$header.= $value;
				} else {
					$body.= $value;
				}
			}



			if (iconv('UTF-8', 'UTF-8', $body) == $body) {
				$body = utf8_decode($body);
			}
			$body = html_entity_decode($body);
			}
			}

				
				$regex = '/name\=\"searchkey\" value\=\"(.+?)\"/';
				$match = array();
				preg_match($regex,$body,$match);
				if (strlen($match[1]) > 0) {
				$searchkey = $match[1];
				}
				echo "SearchKey: $searchkey\n<br>";


				 
		

			$checkUrl = "http://www.upplysning.se/search.aspx?what=".$searchResult[ $keyPC ]["personalCodeNumber"]."&where=&bs=S%F6k&searchkey=".$searchkey;
			echo "Checking: $checkUrl <br>";
			$parsed = parse_url($checkUrl);
			if ($parsed["host"] != $host) $cookies = array();
			$host = $parsed["host"];
			$port = ($parsed["port"] > 0) ? $parsed["port"]:"80";
			$path = ($parsed["path"]) ? $parsed["path"]:"/";
			if ($parsed["query"]) $parsed["query"] = str_replace("&amp;", "&", $parsed["query"]);
			$path.= ($parsed["query"]) ? "?".$parsed["query"]:"";
			if (substr($url, -1, 1) == "?") {
				$path .= "?";
			}

			$out = "GET ".$path." HTTP/1.0".END_OF_LINE_MARKER;
			$out.= "Accept: */*\r\n";
#			$out.= "User-Agent: ".$user_agent.END_OF_LINE_MARKER;
			$out.= "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)\r\n";
			$out.= "Host: ".$host.END_OF_LINE_MARKER;
			$out.= "Connection: Close\r\n";

			$out.= END_OF_LINE_MARKER;
			//echo $out;
			$content = array();
			$timeout = 10;
			 
			if ($fp = @fsockopen($host, $port, $errno, $errstr, 5)) {
			fwrite($fp, $out);
			unset($data);
			unset($found_header);


			stream_set_blocking($fp, FALSE );
			

			//echo "Initiating download - Memory used: " . number_format(memory_get_usage()) . "<br />\n";
			$start= time();

			while (!feof($fp)) {
			$data = fgets($fp);
			  if (!feof($fp)) {
					if (eregi("Content-type:", $data) && !$found_header) {
					if (!eregi("Content-type: text/", $data)) {
						
						break;
					} else {
						$found_header = TRUE;
					}
				}
				if ($data != "") {
				$content[] = $data;
				$data = "";
				}
			  }
			 }
			//echo "After download - Memory used: " . number_format(memory_get_usage()) . "<br />\n";
//print_r($content);
			fclose($fp);
			if (count($content) > 0) {
			unset($header);
			unset($body);
			while (list ($key, $value) = each ($content)) {
				if (!$body && $value != "\r\n") {
					$header.= $value;
				} else {
					$body.= $value;
				}
			}



			if (iconv('UTF-8', 'UTF-8', $body) == $body) {
				$body = utf8_decode($body);
			}
			$body = html_entity_decode($body);
			}
			}
			//echo $body;
			
			echo "<br><br><br>";
				$regex = '/href\=\"show\.aspx(.+?)\<\/a\>/';
				$match = array();
				preg_match($regex,$body,$match);
				if (strlen($match[1]) > 0) {
				$name = $match[1];
				}






				$matches = array();
				$regex = '/href\=\"show\.aspx(.+?)\<\/a\>/';
				preg_match_all($regex,$body,$matches);
				while (list($key, $value) = each($matches[1])) {
				$name2 = $value;
				}






				$name = end(explode('">',$name));
				$name = str_replace("<i>", "", $name);
				$name = str_replace("</i>", "", $name);
				$name2 = end(explode('">',$name2));
				$name2 = str_replace("<i>", "", $name2);
				$name2 = str_replace("</i>", "", $name2);
				echo "Name: $name";
				echo "Name2: $name2";
				if (strlen($name) > strlen($name2)) {
				$name2 = $name;
				}
				$record = array();
				$record["checkedId"] = "YES";
				$record["verifiedName"] = addslashes($name2);
				$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . $searchResult[ $keyPC ]["id"] );
				
				sleep(1);

			}
		}
}
}




$q = "SELECT fl_users.id, fl_users.username, count(fl_forum_threads.id) as antalPosts FROM fl_users LEFT JOIN fl_forum_threads on fl_users.id = fl_forum_threads.userId GROUP BY fl_users.id ORDER BY fl_users.id ASC";
$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
if (count($searchResult > 1)) {
while ( list( $keyPC, $valuePC ) = each( $searchResult ) )
		{

				$record = array();
				$record["forumPosts"] = (int)$searchResult[ $keyPC ]["antalPosts"];
				$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . $searchResult[ $keyPC ]["id"] );

		}
}



$q = "SELECT fl_users.id, fl_users.username, count(fl_forum_threads.id) as antalPosts FROM fl_users LEFT JOIN fl_forum_threads on fl_users.id = fl_forum_threads.userId WHERE fl_forum_threads.insDate > DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY fl_users.id ORDER BY fl_users.id ASC";
$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
if (count($searchResult > 1)) {
while ( list( $keyPC, $valuePC ) = each( $searchResult ) )
		{

				$record = array();
				$record["forumPostsLastWeek"] = (int)$searchResult[ $keyPC ]["antalPosts"];
				$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . $searchResult[ $keyPC ]["id"] );

		}
}



$q = "SELECT * FROM fl_forum_threads WHERE writtenStatus = 'NO' ORDER BY id ASC";
$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
if (count($searchResult > 1)) {
while ( list( $keyPC, $valuePC ) = each( $searchResult ) )
		{

				$record = array();
				$record["writtenStatus"] = "YES";
				$DB->AutoExecute( "fl_forum_threads", $record, 'UPDATE', 'id = ' . $searchResult[ $keyPC ]["id"] );

				$record = array();
				$record["insDate"] = $searchResult[ $keyPC ]["insDate"];
				$record["userID"] = $searchResult[ $keyPC ]["userId"];
				$record["statusMessage"] = $searchResult[ $keyPC ]["id"];
				$record["private"] = "NO";
				$record["statusType"] = "forumEntry";
				$DB->AutoExecute( "fl_status", $record, 'INSERT');

		}
}



$q = "SELECT * FROM fl_images WHERE imageType = 'albumPhoto' AND albumId = 0 AND userId > 0 ORDER BY id ASC";
$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
if (count($searchResult > 1)) {
while ( list( $keyPC, $valuePC ) = each( $searchResult ) )
		{

				$q = "SELECT * FROM fl_albums WHERE userId = " . (int)$searchResult[ $keyPC ]["userId"] . " ORDER BY fl_albums.insDate DESC LIMIT 1";
				$albums = $DB->GetRow( $q, FALSE, TRUE );

				if ( count( $albums ) > 0 )
				{
					$record = array();
					$record["albumId"] = $albums["id"];
					$DB->AutoExecute( "fl_images", $record, 'UPDATE', 'id = ' . $searchResult[ $keyPC ]["id"] );



						$q = "SELECT * FROM fl_albums WHERE id = " . (int)$albums["id"];
						$album_update_aiid = $DB->GetRow( $q, FALSE );

						$q = "SELECT * FROM fl_images WHERE albumId = " . (int)$albums["id"]." AND imageType IN ('albumPhoto', 'albumVideo') order by id desc limit 1";
						$image_update_aiid = $DB->GetRow( $q, FALSE );

						if ($album_update_aiid["album_image_id"] == 0) {

							
							if ((int)$image_update_aiid["id"] > 0) {
								$record = array();
								$record["album_image_id"] = $image_update_aiid["id"];
								$DB->AutoExecute( "fl_albums", $record, 'UPDATE', 'id = '.(int)$albums["id"] ); 
								
							}

						}
				}




		}
}


echo "<br />Scheduled tasks performed!";
?>