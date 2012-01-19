<?php

function redirect($url) {
   header("HTTP/1.1 301 Moved Permanently");
   header("Location: $url");
   exit();
}


function pagingButtons($totalResults, $numPerPage = 10, $offset, $printed, $url) {

	if ( $totalResults > $numPerPage )
	{
		if ( (int)$offset > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $url . (strpos($url, "?") !== FALSE ? '&' : '?') . "offset=0\">< Första sidan </a>
			<a href=\"" . $url . (strpos($url, "?") !== FALSE ? '&' : '?') . "offset=" . ( (int)$offset - $numPerPage ) . "\">< F&ouml;reg&aring;ende sida</a>";
		}
		else
		{
			$body.= "<div id=\"previous\">&nbsp;\n";
		}
		$body .= "</div>";
		$pagenum = (ceil($offset/$numPerPage) == 0 ? 1 : ceil($offset/$numPerPage)+1);
		$maxpage = ceil($totalResults/$numPerPage);
$pagetotal = 7; // maximum page numbers to display at once, must be an odd number
$pagelimit = ($pagetotal-1)/2;
$pagemax = $pagetotal>$maxpage?$maxpage:$pagetotal;
if ($pagenum - $pagelimit < 1) {
$pagemin = 1;
}
if ($pagenum - $pagelimit >=1 && $pagenum + $pagelimit <= $maxpage) {
$pagemin = $pagenum - $pagelimit;
$pagemax = $pagenum + $pagelimit;
}
if ($pagenum - $pagelimit >=1 && $pagenum + $pagelimit > $maxpage) {
$pagemin = ($maxpage-$pagetotal+1)<1?1:($maxpage-$pagetotal+1);
$pagemax = $maxpage;
}
if ($pagenum + $pagelimit > $maxpage) {
$pagemax = $maxpage;
}
#$body.= "Pagelimit: $pagelimit Pagetotal: $pagetotal Pagenum: $pagenum Offset: $offset Pagemin: $pagemin Pagemax: $pagemax";

for($page = $pagemin; $page <= $pagemax; $page++)
{
  if ($page == $pagenum)
  {
     $pages .= " $page "; // no need to create a link to current page
  }
  else
  {
     $pages .= " <a href=\"" . $url . (strpos($url, "?") !== FALSE ? '&' : '?') . "offset=" . (($page * $numPerPage)-10) . "\">".floor($page)."</a> ";
  }
}


		$body.= "<div id=\"middle\" style=\"text-align: center;\">".$pages."<br /><b>" . (int)$offset.' - '.((int)$offset+$printed)  . "</b> av totalt <b>". $totalResults . "</b></div>\n";
		if ( ($printed + $offset) < $totalResults )
		{
			$body.= "<div id=\"next\"><a href=\"" . $url . (strpos($url, "?") !== FALSE ? '&' : '?') . "offset=" . ($printed + $offset) . "\">N&auml;sta sida > </a>
			<a href=\"" . $url . (strpos($url, "?") !== FALSE ? '&' : '?') . "offset=" . ($totalResults - $numPerPage) . "\">Sista sidan > </a></div>";
		}
	}
	else
	{
		$body.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center;\"><b>" .  $printed  . "</b> av <b>" . $totalResults . "</b></div>\n";		
	}
return $body;
}

function convert_datetime($str) {

list($date, $time) = explode(' ', $str);
list($year, $month, $day) = explode('-', $date);
list($hour, $minute, $second) = explode(':', $time);

$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

return $timestamp;
}

function br2nl($text)
    {
    
    return str_replace("<br>","",$text);
    }


function toSlug($string,$space="-") {
	
	if (function_exists('iconv')) {
		$string = @iconv('UTF-8', 'ASCII//TRANSLIT', $string);
	}

	$string = preg_replace("/[^a-zA-Z0-9 -]/", "", $string);
	$string = strtolower($string);
	$string = trim($string);
	$string = ereg_replace(" +", $space, $string);
	if (strlen($string) > 15) {
	$string = substr($string, 0, 15);
	}
	return $string;
}

function uploadPhotos($newAlbumId = 0) {
	global $_FILES, $DB, $_SESSION, $_POST;
	
			ini_set('memory_limit', '300M');  
			 ini_set('max_input_time', '420');
			 ini_set('max_execution_time', '420');
			 ini_set('post_max_size', '100M');
			 ini_set('upload_max_filesize', '500M');

			$folder = '/var/www/flator.se/rwdx/photos/';

			$extension = "ffmpeg";

			$extension_soname = $extension . "." . PHP_SHLIB_SUFFIX;
			$extension_fullname = PHP_EXTENSION_DIR . "/" . $extension_soname;
			
			if (!extension_loaded($extension)) {
			dl($extension_soname) or die("Can't load extension $extension_fullname\n");
			}
			$array_path = explode("/",$_SERVER['SCRIPT_FILENAME']);
			$dynamic_path = "";
			for ($i=0;$i<sizeof($array_path)-1;$i++)
			if($array_path[$i]!="")
			$dynamic_path =$dynamic_path."/".$array_path[$i];

$flvpath = "flvfiles/";

$moviepath = "movies/" ;



			$added = array();			
			$i = 0;
			foreach ($_FILES["bild"]["error"] as $key => $error) {
				$alphanum = "APBHCPDEFGHIJKARLCAMDENSCPRIQPTRSTUVWXYZ123456789";
				$rand = substr(str_shuffle($alphanum), 0, 3);

			

				if ($error == UPLOAD_ERR_OK) {
					#echo "File uploaded OK!";
					$tmp_name = $_FILES["bild"]["tmp_name"][$key];
					$size = getimagesize($tmp_name);
					//echo "Size: $size";
					
					$name = $_FILES["bild"]["name"][$key];
					$name = str_replace("+", "", $name);

					$fileName = $name;
					$fileNameParts = explode( ".", $fileName );
					$fileExtension = end( $fileNameParts );
					$fileExtension = strtolower( $fileExtension );
					$newpath = $folder.$name;
					if (file_exists($folder.$name))
						{
							echo "Fil finns";
							$name = $rand.'_'.$name;
							$newpath = $folder.$name; 
						}
					if (move_uploaded_file($tmp_name, $newpath)) {
					//echo "Bild $i laddades upp: $newpath\n<br>";
					
					 
			 
						$large_max_width = 3000;
				
						
				
					 // ÄNDRA STORLEK PÅ STORA BILDEN
					if ($size[0] <= $large_max_width) {
					  } else {
						echo $newpath;
						 createThumb($newpath, $newpath, $newwidth, $newheight);
					  }



					if (file_exists($newpath)) {

						if($fileExtension=="avi" || $fileExtension=="wmv" || $fileExtension=="mpeg" || $fileExtension=="mpg" || $fileExtension=="mov" )
							{


							if( $fileExtension == "wmv" ) {


								$output = runExternal( "ffmpeg -i ".$newpath." -sameq -acodec libmp3lame -ar 22050 -ab 32 -f flv -s 320x240 ".$folder."".$fileNameParts[0].".flv", $code );
								#echo $output;
								}

								if( $fileExtension == "avi" || $fileExtension=="mpg" ||
								$fileExtension=="mpeg" || $fileExtension=="mov" ) {
								$execCommand = "ffmpeg -i ".$newpath." -sameq -acodec libmp3lame -ar 22050 -ab 32 -f flv -s 320x240 ".$folder."".$fileNameParts[0].".flv";
								#echo $execCommand;
								$output = runExternal( $execCommand, $code );
								#echo $output;


								}

								/******************create thumbnail***************/
								$execCommand = "ffmpeg -y -i ".$newpath." -vframes 1 -ss 00:00:03 -an -vcodec png -f rawvideo -s 110x90 ".$folder."".$fileNameParts[0].".png";
								#echo $execCommand;
								$output = runExternal( $execCommand, $code );
								#echo $output;
								
								unlink($newpath);
								$videopath = $folder."".$fileNameParts[0].".flv";
								$newpath = $folder."".$fileNameParts[0].".png";
								$imageType = "albumVideo";

							} else {
								$imageType = "albumPhoto";
							}
						


						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						
						
						$record["userId"] = (int)$_SESSION["userId"];
						$record["name"] = addslashes($_POST["name"]);
						$record["description"] = addslashes( $_POST["description"] );
						$record["albumId"] = addslashes( ($newAlbumId > 0 ? $newAlbumId : $_POST["album"]) );
						$record["imageType"] = $imageType;
						$record["imageUrl"] = addslashes( str_replace($folder, "http://www.flator.se/rwdx/photos/", $newpath) );
						$record["serverLocation"] = addslashes( $newpath );
						$record["videoLocation"] = addslashes( $videopath );

						$DB->AutoExecute( "fl_images", $record, 'INSERT' ); 
						$record = array();
						$added[] = $DB->Insert_ID();

						$q = "SELECT * FROM fl_albums WHERE id = " . (int)($newAlbumId > 0 ? $newAlbumId : $_POST["album"]);
						$album_update_aiid = $DB->GetRow( $q, FALSE );

						$q = "SELECT * FROM fl_images WHERE albumId = " . (int)($newAlbumId > 0 ? $newAlbumId : $_POST["album"])." AND imageType IN ('albumPhoto', 'albumVideo') order by id desc limit 1";
						$image_update_aiid = $DB->GetRow( $q, FALSE );

						if (($album_update_aiid["album_image_id"] == 0) || ( count( $currentPhoto ) < 1 )) {

							
							if ((int)$image_update_aiid["id"] > 0) {
								$record["album_image_id"] = $image_update_aiid["id"];
								$DB->AutoExecute( "fl_albums", $record, 'UPDATE', 'id = '.(int)($newAlbumId > 0 ? $newAlbumId : $_POST["album"]) ); 
								
							}

						}
						
	
					
						

					} else {
						//echo "Något gick snett.. Kontrollera om din bild hamnade i fotoalbumet, gör ett nytt försök i annat fall!";

					}

					
					
					
					
					
					
					
					
					} else {
						//echo "Något gick snett.. Kontrollera om dina bilder hamnade i fotoalbumet, gör ett nytt försök i annat fall!";

					}


				} else {
				echo "Fel uppstod: ".$error;
				}
					
					
				
				$i++;

			}





			if (count($added) > 0) {
			$record = array();
			$record["insDate"] = date("Y-m-d H:i:s");
			$record["userId"] = (int)$_SESSION["userId"];
			$record["statusMessage"] = "Laddade upp ".count($added)." bilder.";
			$record["photoIds"] = implode(",", $added);
			$record["statusType"] = "newPhotosUploaded";
			$DB->AutoExecute( "fl_status", $record, 'INSERT' ); 
			}











#redirect($baseUrl ."/media/album/".(int)($newAlbumId > 0 ? $newAlbumId : $_POST["album"]).".html");

$_POST = array();
}



function runExternal( $cmd, $code ) {

$descriptorspec = array(
0 => array("pipe", "r"), // stdin is a pipe that the child willread from
1 => array("pipe", "w"), // stdout is a pipe that the child willwrite to
2 => array("pipe", "w") // stderr is a file to write to
);

$pipes= array();
$process = proc_open($cmd, $descriptorspec, $pipes);

$output= "";

if (!is_resource($process)) return false;

#close child's input imidiately
fclose($pipes[0]);

stream_set_blocking($pipes[1],false);
stream_set_blocking($pipes[2],false);

$todo= array($pipes[1],$pipes[2]);

while( true ) {
$read= array();
if( !feof($pipes[1]) ) $read[]= $pipes[1];
if( !feof($pipes[2]) ) $read[]= $pipes[2];

if (!$read) break;

$ready= stream_select($read, $write=NULL, $ex= NULL, 2);

if ($ready === false) {
break; #should never happen - something died
}

foreach ($read as $r) {
$s= fread($r,1024);
$output.= $s;
}
}

fclose($pipes[1]);
fclose($pipes[2]);

$code= proc_close($process);

return $output;
}
function GetAge($BirthYear, $BirthMonth, $BirthDay)

{

        // Explode the date into meaningful variables

        

        // Find the differences

        $YearDiff = date("Y") - $BirthYear;

        $MonthDiff = date("m") - $BirthMonth;

        $DayDiff = date("d") - $BirthDay;
		#echo "DayDiff: $DayDiff MonthDiff: $MonthDiff YearDiff: $YearDiff Year: ".date("Y")." BirthYear: ".$BirthYear;
        // If the birthday has not occured this year

        if ($MonthDiff < 0 || ($DayDiff < 0 && $MonthDiff < 1)) $YearDiff--;

        return $YearDiff;

}

function stripBBCode($text_to_search) {
 $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
 $replace = '';
 return preg_replace($pattern, $replace, $text_to_search);
}
#
function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
#
        if ($considerHtml) {
#
            // if the plain text is shorter than the maximum length, return the whole text
#
            if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
#
                return $text;
#
            }
#
           
#
            // splits all html-tags to scanable lines
#
            preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
#
   
#
            $total_length = strlen($ending);
#
            $open_tags = array();
#
            $truncate = '';
#
           
#
            foreach ($lines as $line_matchings) {
#
                // if there is any html-tag in this line, handle it and add it (uncounted) to the output
#
                if (!empty($line_matchings[1])) {
#
                    // if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
#
                    if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
#
                        // do nothing
#
                    // if tag is a closing tag (f.e. </b>)
#
                    } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
#
                        // delete tag from $open_tags list
#
                        $pos = array_search($tag_matchings[1], $open_tags);
#
                        if ($pos !== false) {
#
                            unset($open_tags[$pos]);
#
                        }
#
                    // if tag is an opening tag (f.e. <b>)
#
                    } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
#
                        // add tag to the beginning of $open_tags list
#
                        array_unshift($open_tags, strtolower($tag_matchings[1]));
#
                    }
#
                    // add html-tag to $truncate'd text
#
                    $truncate .= $line_matchings[1];
#
                }
#
               
#
                // calculate the length of the plain text part of the line; handle entities as one character
#
                $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
#
                if ($total_length+$content_length> $length) {
#
                    // the number of characters which are left
#
                    $left = $length - $total_length;
#
                    $entities_length = 0;
#
                    // search for html entities
#
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
#
                        // calculate the real length of all entities in the legal range
#
                        foreach ($entities[0] as $entity) {
#
                            if ($entity[1]+1-$entities_length <= $left) {
#
                                $left--;
#
                                $entities_length += strlen($entity[0]);
#
                            } else {
#
                                // no more characters left
#
                                break;
#
                            }
#
                        }
#
                    }
#
                    $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
#
                    // maximum lenght is reached, so get off the loop
#
                    break;
#
                } else {
#
                    $truncate .= $line_matchings[2];
#
                    $total_length += $content_length;
#
                }
#
               
#
                // if the maximum length is reached, get off the loop
#
                if($total_length>= $length) {
#
                    break;
#
                }
#
            }
#
        } else {
#
            if (strlen($text) <= $length) {
#
                return $text;
#
            } else {
#
                $truncate = substr($text, 0, $length - strlen($ending));
#
            }
#
        }
#
       
#
        // if the words shouldn't be cut in the middle...
#
        if (!$exact) {
#
            // ...search the last occurance of a space...
#
            $spacepos = strrpos($truncate, ' ');
#
            if (isset($spacepos)) {
#
                // ...and cut the text in this position
#
                $truncate = substr($truncate, 0, $spacepos);
#
            }
#
        }
#
       
#
        // add the defined ending to the text
#
        $truncate .= $ending;
#
       
#
        if($considerHtml) {
#
            // close all unclosed html-tags
#
            foreach ($open_tags as $tag) {
#
                $truncate .= '</' . $tag . '>';
#
            }
#
        }
#
       
#
        return $truncate;
#
       
#
    }



function createThumb( $name, $filename, $new_w, $new_h)
{
#	echo "<p>Name: " . $name . "<br>Filename: " . $filename . "<br>Width: " . $new_w . "<br>Height: " . $new_h . "</p>\n";
	$system = explode( '.', $name );
	if ( preg_match( '/jpg|jpeg|JPG|JPEG/',$system[2] ) ) 
	{
		$src_img = imagecreatefromjpeg( $name );
	}	if ( preg_match( '/png|PNG/',$system[2] ) ) 
	{		$src_img = imagecreatefrompng( $name );	}
	if ( preg_match('/gif|GIF/',$system[2] ) )
	{		$src_img = imagecreatefromgif( $name );	}
	$old_x = imageSX( $src_img );	$old_y = imageSY( $src_img );

	if ( $old_x > $new_w ) // Larger then the maximum width
	{
		$thumb_w = $new_w;
		$thumb_h = ceil( $new_w * ( $old_y / $old_x ) );
	}
	else
	{
		$thumb_w = $old_x;
		$thumb_h = $old_y;		
	}


#	if ( $old_x > $old_y )
#	{#		$thumb_w = $new_w;#		$thumb_h = $old_y * ( $new_h / $old_x );#	}#	if ( $old_x < $old_y )
#	{#		$thumb_w = $old_x * ( $new_w / $old_y );#		$thumb_h = $new_h;#	}#	if ( $old_x == $old_y )
#	{#		$thumb_w = $new_w;#		$thumb_h = $new_h;#	}

	$dst_img = ImageCreateTrueColor( $thumb_w, $thumb_h );	imagecopyresampled( $dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y );
	if ( preg_match( '/jpg|jpeg|JPG|JPEG/',$system[2] ) )
	{
		imagejpeg( $dst_img, $filename );
	}
	if ( preg_match( "/png|PNG/", $system[2] ) )	{		imagepng( $dst_img, $filename ); 	}
	if ( preg_match( "/gif|GIF/", $system[2] ) )
	{		imagegif( $dst_img, $filename );	}	imagedestroy( $dst_img ); 	imagedestroy( $src_img ); }



function months ( $month )
{
	$monthArr = array(1 => "jan",
				 2 => "feb",
				 3 => "mar",
				 4 => "apr",
				 5 => "maj",
				 6 => "jun",
				 7 => "jul",
				 8 => "aug",
				 9 => "sep",
				 10 => "okt",
				 11 => "nov",
				 12 => "dec" );	

	return $monthArr[ $month ];
}

function days ( $day )
{
	$dayArr = array(1 => "måndag",
				 2 => "tisdag",
				 3 => "onsdag",
				 4 => "torsdag",
				 5 => "fredag",
				 6 => "lördag",
				 7 => "söndag" );

	return $dayArr[ $day ];
}

function isCurrentFriend ( $userId, $friendUserId, $isApproved = "YES" )
{
	global $DB;

	$userFriendList = array();
	if ( $isApproved == "YES" )
	{
		$q = "SELECT * FROM fl_friends WHERE approved = 'YES' AND ( userId = " . (int)$friendUserId . " OR friendUserId = " . (int)$friendUserId . " )";
	}
	else
	{
		$q = "SELECT * FROM fl_friends WHERE ( userId = " . (int)$friendUserId . " OR friendUserId = " . (int)$friendUserId . " )";
	}
#	echo $q;
	$userFriends = $DB->GetAssoc( $q, FALSE, TRUE );
	if ( count( $userFriends ) > 0 )
	{
		while ( list( $key, $value ) = each( $userFriends ) )
		{
			if ( $userFriends[ $key ]["userId"] != (int)$friendUserId )
			{
				$userFriendList[ $userFriends[ $key ]["userId"] ] = TRUE;
			}
			else
			{
				$userFriendList[ $userFriends[ $key ]["friendUserId"] ] = TRUE;
			}
		}
		if ( $userFriendList[ $userId ] == TRUE )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	else
	{
		return FALSE;
	}
}
function isCurrentAlbum ( $userId, $albumName )
{
	global $DB;

	
		$q = "SELECT * FROM fl_albums WHERE userId = " . (int)$userId . " AND name = '" . addslashes($albumName)."'";
	
	#echo $q;
	$userAlbum = $DB->GetAssoc( $q, FALSE, TRUE );
	if ( count( $userAlbum ) > 0 )
	{

			return TRUE;

	}
	else
	{
		return FALSE;
	}
}
function getMessage ( $origMessageId, $messageId, $userId )
{
	global $DB;

	// Fetch message
	$q = "SELECT fl_messages.*, fl_users.username, UNIX_TIMESTAMP( fl_messages.insDate ) AS unixTime FROM fl_messages LEFT JOIN fl_users ON fl_users.id = fl_messages.userId WHERE ((fl_messages.userId = " . (int)$userId . " AND fl_messages.senderDeleted = 'NO') OR (fl_messages.recipentUserId = " . (int)$userId . " AND fl_messages.deleted = 'NO')) AND (fl_messages.id = " . (int)$origMessageId . " OR fl_messages.origMessageId = " . (int)$origMessageId . ") AND fl_messages.id != " . (int)$messageId;
echo $q;
	$message = $DB->GetRow( $q, FALSE, TRUE );
	return $message;
}



function templateLink ( $type, $configType = "" )
{
	global $DB, $baseUrl;

	$q = "SELECT * FROM fl_templates WHERE templateType = '" . $type . "' AND active = 'YES' ORDER BY name ASC";
	$row = $DB->GetAssoc( $q, FALSE, TRUE );
	if ( strlen( $configType ) > 0 ) $type = $configType;
	if ( count( $row ) > 0 )
	{
		if ( $type == "invite" )
		{
			$body = "<a href=\"#nonexist\" onClick=\"getContent('select_template.php?target=selectTemplate&type=" . $type . "&action=select');\">V&auml;lj/redigera mall</a>";
			$body.= " <a href=\"" . $baseUrl . "/admin_invite_template.html\" onClick=\"openPopup(this.href,'admin_invite_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
		}
		elseif ( $type == "newsletter" )
		{
			$body = "<a href=\"#nonexist\" onClick=\"getContent('select_template.php?target=selectTemplate&type=" . $type . "&action=select');\">V&auml;lj/redigera mall</a>";
			$body.= " <a href=\"" . $baseUrl . "/admin_newsletter_template.html\" onClick=\"openPopup(this.href,'admin_newsletter_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
		}
		else
		{
			$body = "<a href=\"#nonexist\" onClick=\"getContent('select_template.php?target=" . $configType . "&type=" . $type . "&action=select');\">V&auml;lj/redigera mall</a>";
			$body.= " <a href=\"" . $baseUrl . "/admin_template.html?type=" . $configType . "\" onClick=\"openPopup(this.href,'admin_" . $configType . "_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
		}
		return $body;
	}
	else
	{
		if ( $type == "invite" )
		{
			return "<a href=\"" . $baseUrl . "/admin_invite_template.html\" onClick=\"openPopup(this.href,'admin_invite_template', 800, 400); return false;\">Skapa mail/mall</a>\n";
		}
		elseif ( $type == "newsletter" )
		{
			return "<a href=\"" . $baseUrl . "/admin_newsletter_template.html\" onClick=\"openPopup(this.href,'admin_newsletter_template', 800, 400); return false;\">Skapa mail/mall</a>\n";
		}
		else
		{
			return "<a href=\"" . $baseUrl . "/admin_template.html?type=" . $configType . "\" onClick=\"openPopup(this.href,'admin_" . $configType . "_template', 800, 400); return false;\">Skapa mall</a>\n";
		}
	}
}

function randCode ($length = 30)
{
	$charset = "abcdefghijklmnopqrstuvwxyz";
	for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
	return $key;
}

function sendMail( $to, $from, $from_name, $subject, $message )
{
    require_once('htmlMimeMail5/htmlMimeMail5.php');
    
    $mail = new htmlMimeMail5();

    /**
    * Set the from address
    */
    $mail->setFrom( $from_name . " <" . $from . ">");
    
    /**
    * Set the subject
    */
    $mail->setSubject($subject);
    
    /**
    * Set high priority
    */
    $mail->setPriority('normal');

    /**
    * Set the text of the Email
    */
    $mail->setText("This is a MIME encoded message.");
    
    /**
    * Set the HTML of the email
    */
    $mail->setHTML($message);
    
    /**
    * Add an embedded image
    */
#    $mail->addEmbeddedImage(new fileEmbeddedImage('background.gif'));
    
    /**
    * Add an attachment
    */
#    $mail->addAttachment(new fileAttachment('example.zip'));

    /**
    * Send the email
    */
    $mail->send(array($to));
/*
	//add From: header 
	$headers = "From: " . $from . "\r\n"; 

	//specify MIME version 1.0 
	$headers .= "MIME-Version: 1.0\r\n"; 

	//unique boundary 
	$boundary = uniqid("NEWS"); 

	//tell e-mail client this e-mail contains//alternate versions 
#	$headers .= "Content-Type: multipart/alternative; boundary = ".$boundary."\r\n\r\n"; 
	$headers .= "Content-Type: multipart/mixed; boundary = ".$boundary."\r\n\r\n"; 

	//message to people with clients who don't 
	//understand MIME 
	$body = "This is a MIME encoded message.\r\n\r\n"; 

#	if ($attachment == "") {
#		//plain text version of message 
#		$body .= "--".$boundary."\r\n" . 
#		   "Content-Type: text/plain; charset=ISO-8859-1\r\n" . 
#		   "Content-Transfer-Encoding: base64\r\n\r\n"; 
#		$body .= chunk_split(base64_encode(strip_tags($message))); 
#	}

	//HTML 
	$body .= "--".$boundary."\r\n" . 
	   "Content-Type: text/html; charset=ISO-8859-1\r\n" . 
	   "Content-Transfer-Encoding: base64\r\n\r\n"; 
	$body .= chunk_split(base64_encode($message)); 

	//send 
	mail($to, $subject, $body, $headers); 
*/
}

// Check personal code number (personnummer)
function checkPnr( $string )
{
	if(preg_match("/^[0-9]{10}$/", $string))
	{
		if ( substr( $string, 6, 4 ) == "0000" ) return false;
		$n = 2;
		// Calculate the controlnumber
		for ($i=0; $i<9; $i++)
		{
			$tmp = $string[$i] * $n;
			($tmp > 9) ? $sum += 1 + ($tmp % 10) : $sum += $tmp;
			($n == 2) ? $n = 1 : $n = 2;
		}
		return !(($sum + $string[9]) % 10);
	}
	else
	{
		return false;
	}
}
?>