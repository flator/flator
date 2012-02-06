<?php
$numPerPage = 15;
if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/blog.html";
	include( "login_new.php" );
}
else
{
	unset( $error );

if ( $_POST["type"] == "commentBlog"  && $_SESSION["demo"] != TRUE )
				{
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userId"] = (int)$userProfile["id"];
						$record["type"] = "blogComment";
						$record["contentId"] = (int)$_POST["id"];
						$record["comment"] = addslashes(nl2br($_POST["comment"]));

						$DB->AutoExecute( "fl_comments", $record, 'INSERT' ); 
						
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userid"] = (int)$userProfile["id"];
						if (strlen($_POST["comment"])> 25) $_POST["comment"] = substr($_POST["comment"],0,25)." ...";
						$record["statusMessage"] = "Kommenterade blogginlägg: <a href=\"" . $baseUrl . "/blogs/posts/".(int)$_POST["id"].".html\">".addslashes($_POST["comment"])."</a>";
						$record["mostRecent"] = "NO";
						$record["statusType"] = "blogComment";
						$DB->AutoExecute( "fl_status", $record, 'INSERT'); 

						$_POST = array();
						$thankoyu = "<li>Kommentaren har sparats.</li>\n";


				}
	

	


	if (count($currentPost) > 0) {
	$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_blog WHERE id = " . (int)$currentPost["id"] . " ORDER BY insDate DESC";
	$blogPosts = $DB->GetAssoc(  $q, FALSE, TRUE );
	} else {

	$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_blog WHERE userId = " . (int)$userPres["id"] . " ORDER BY insDate DESC";
	$blogPosts = $DB->GetAssoc(  $q, FALSE, TRUE );
	}

	while ( list( $key, $value ) = each( $blogPosts ) )
		{
			
	
		 
				$q = "SELECT id, photoId FROM fl_blog_photos WHERE blogPostId = " . (int)$blogPosts[ $key ]["id"] . " ORDER BY id ASC";
				
				$blogPosts[ $key ]["photos"] = $DB->GetAssoc( $q, FALSE, TRUE );
				while ( list( $key2, $value2 ) = each( $blogPosts[ $key ]["photos"] ) )
				{
					$blogPhotos[$key][] = $blogPosts[ $key ]["photos"][$key2]["photoId"];

				}

		}
		reset($blogPosts);

	$body = "<div id=\"center\">

<div id=\"divHeadSpace\" style=\"border: 0px; line-height: 10px\">";




$body .= "&nbsp;
</div>
<div style=\"float: left; \">";


	$body.= "<div class=\"section_headline\" style=\"padding-top: 10px; padding-bottom: 1px;border:none; border-bottom: 1px dotted #c8c8c8; width:592px; margin-bottom:10px;\" width=\"595px\">" . stripslashes( $userPres["username"] ) . "s blogg </div><span onMouseOver=\"document.blogg_inlagg_up.src='" . $baseUrl . "/img/symbols/gif_red/blogg_inlagg.gif'\" onMouseOut=\"document.blogg_inlagg_up.src='" . $baseUrl . "/img/symbols/gif_purple/blogg_inlagg.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupWriteBlog');\" style=\"font-weight: normal;\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/blogg_inlagg.gif\" border=\"0\" align=\"ABSMIDDLE\" name=\"blogg_inlagg_up\" />&nbsp;&nbsp;Nytt blogginlägg</a></span>";
$printed = 0;

if (count($currentPost) > 0) {

$body .= '<br /><br /><a href="'.$baseUrl.'/blogs/'.stripslashes( $userPres["username"] ).'.html">Tillbaka till alla '.stripslashes( $userPres["username"] ).'s blogginlägg</a>';
}
	if ( count( $blogPosts ) > 0 )
	{
		$i = (int)$_GET["offset"];
		$i2 = 0;
		
		while ( list( $key, $value ) = each( $blogPosts ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$i++;

			unset( $eventDate );
			if ( date("Y-m-d", $blogPosts[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Event updated today
				$eventDate = "idag kl " . date( "H:i", $blogPosts[ $key ]["unixTime"] );
			}
			elseif ( date("Y-m-d", $blogPosts[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Event updated yesterday
				$eventDate = "ig&aring;r kl " . date( "H:i", $blogPosts[ $key ]["unixTime"] );
			}
			elseif ( date("Y", $blogPosts[ $key ]["unixTime"] ) == date( "Y" ) )
			{
				// Event updated this year
				$eventDate = date( "d", $blogPosts[ $key ]["unixTime"] ) . " " . strtolower( months( (int)date( "m", $blogPosts[ $key ]["unixTime"] ) ) ) . ", " . date( "H:i", $blogPosts[ $key ]["unixTime"] );
			}
			else
			{
				$eventDate = date( "d", $blogPosts[ $key ]["unixTime"] ) . " " . strtolower( months( (int)date( "m", $blogPosts[ $key ]["unixTime"] ) ) ) . " " . date( "Y, H:i", $blogPosts[ $key ]["unixTime"] );
			}

			$q = "SELECT fl_comments.*, UNIX_TIMESTAMP(fl_comments.insDate) AS unixTime, fl_users.username FROM fl_comments LEFT JOIN fl_users ON fl_users.id = fl_comments.userId WHERE fl_comments.type = 'blogComment' AND fl_comments.contentId = " . (int)$blogPosts[ $key ]["id"] . " AND fl_users.rights > 2 ORDER BY fl_comments.insDate DESC";
			$comments = $DB->GetAssoc( $q, FALSE, TRUE );

			$body.= "<div class=\"blogPost\"><table border=\"0\" width=\"100%\" style=\"margin-top:20px;\"><tr>
 	<td style=\"margin:none;padding:none;\" valign=\"top\"><a href=\"".$baseUrl."/blogs/posts/".$blogPosts[ $key ]["id"].".html\" class=\"news_type\">" . stripslashes( $blogPosts[ $key ]["subject"] ) . "</a>&nbsp;&nbsp;<span class=\"email_date\" style=\"\">" . $eventDate . "</span>";
	
		if ( $editBlog == TRUE )
		{
			$body.= "<span class=\"blogEditLinks\" style=\" margin-left:20px;\" onMouseOver=\"document.deleteBlog".$blogPosts[ $key ]["id"].".src='" . $baseUrl . "/img/symbols/gif_red/radera.gif'\" onMouseOut=\"document.deleteBlog".$blogPosts[ $key ]["id"].".src='" . $baseUrl . "/img/symbols/gif_purple/radera.gif'\"><a href=\"#noexist\" OnClick=\"if(confirm('Ta bort detta blogginlägg?')) { location.search='?do=deleteBlog&id=".$blogPosts[ $key ]["id"]."'; } else { return false; }\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/radera.gif\" name=\"deleteBlog".$blogPosts[ $key ]["id"]."\" align=\"ABSMIDDLE\" border=\"0\" />Radera</a></span> <span onMouseOver=\"document.editBlog".$blogPosts[ $key ]["id"].".src='" . $baseUrl . "/img/symbols/gif_red/redigera.gif'\" onMouseOut=\"document.editBlog".$blogPosts[ $key ]["id"].".src='" . $baseUrl . "/img/symbols/gif_purple/redigera.gif'\" class=\"blogEditLinks\"><a href=\"#noexist\" onClick=\"showPopup('popupEditBlog".$blogPosts[ $key ]["id"]."');\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/redigera.gif\" name=\"editBlog".$blogPosts[ $key ]["id"]."\" align=\"ABSMIDDLE\" border=\"0\" />Redigera</a></span>";
		}
	$body .= "</td>
 </tr><tr>
 	<td style=\"margin:none;padding:none; border-top: 1px dotted #c8c8c8;\" valign=\"top\">&nbsp;</td>
 </tr></table>";
  /* DISPLAY IMAGES CONNECTED TO BLOG POST */
	if (count($blogPosts[ $key ]["photos"]) > 0) {
		$body .= "<div style=\"float:left; padding-top:5px; padding-left:5px; padding-bottom:5px;margin-right:10px; margin-top:3px; border: 1px dotted #c8c8c8; max-width:200px;\">";
		//$body .= "<span class=\"news_headline\">".count($blogPosts[ $key ]["photos"])." bilder kopplade till blogginlägget</span>";
		$q = "SELECT fl_images.*, UNIX_TIMESTAMP(fl_images.insDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_images LEFT JOIN fl_users ON fl_users.id = fl_images.userId WHERE fl_images.id IN (" . implode(",", $blogPhotos[ $key ]) . ") ORDER BY fl_images.insDate ASC";

			$albumPhotos = $DB->GetAssoc(  $q, FALSE, TRUE );
			if ( count( $albumPhotos ) > 0 )
			{
						$albumPhotosString = "";
						$i = 1;
				while ( list( $key2, $value2 ) = each( $albumPhotos ) )
				{
				
				
					if ( strlen( $albumPhotos[ $key2 ]["serverLocation"] ) > 0 )
					{	
						
							$hoverAction = " onMouseOver=\"document.getElementById( 'hover".$key2."').style.display='block'\" onMouseOut=\"document.getElementById( 'hover".$key2."').style.display='none';\"";
						if ($editBlog == TRUE) {
						$thumbcss = "<div class=\"blog_thumbs_hoverImage\" style=\"display:none\" id=\"hover".$key2."\"></div>";
						$removeThumb = "<a href=\"#noexist\" OnClick=\"if(confirm('Ta bort bild från blogginlägg?')) { location.search='?do=removeBlogPhoto&blogPost=".$blogPosts[ $key ]["id"]."&photo=".$albumPhotos[ $key2 ]["id"]."'; } else { return false; }\" style=\"margin:none;padding:none;\"><span onMouseOver=\"document.removeImage".$key2.".src='" . $baseUrl . "/img/symbols/gif_red/kryss.gif'\" onMouseOut=\"removeImage".$key2.".src='" . $baseUrl . "/img/symbols/gif_purple/kryss.gif'\"><div style=\"float:left; margin-left:-10px; margin-top:-5px;\"><img src=\"".$baseUrl."/img/symbols/gif_purple/kryss.gif\" border=\"0\" name=\"removeImage".$key2."\"></div></span></a>";
						$marginBetween = "15px";
						} else {
						$thumbcss = "<div class=\"blog_thumbs_hoverImage\" style=\"display:none\" id=\"hover".$key2."\"></div>";
						$marginBetween = "4px";
						$removeThumb = "";
						}

						//$body .= '<a href="http://www.flator.se/media/photos/'.$albumPhotos[ $key2 ]["id"].'.html">';
						if (($i % 4) == 0) {
						$body .= "<div class=\"blog_thumbs_Image\" OnClick=\"location.href=".$baseUrl."'/media/photos/".$albumPhotos[ $key2 ]["id"].".html';\" style=\"background: transparent url(".$baseUrl."/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key2 ]["serverLocation"])) . "/small-blog/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; margin-right:5px; margin-bottom:".$marginBetween.";\"".$hoverAction.">".$thumbcss."</div>".$removeThumb."<br>";
						} else {
						$body .= "<div class=\"blog_thumbs_Image\" OnClick=\"location.href=".$baseUrl."'/media/photos/".$albumPhotos[ $key2 ]["id"].".html';\" style=\"background: transparent url(".$baseUrl."/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key2 ]["serverLocation"])) . "/small-blog/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;margin-right:5px; margin-bottom:".$marginBetween.";\"".$hoverAction.">".$thumbcss."</div>".$removeThumb."";
						}
						$body .= '</a>';
					}
					else
					{
						$body = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/grupp_avantar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
					}

					$i++;
					
				}
			}

$body .= "</div>";
	}
	/* END OF BLOG POST IMAGES */
	$allowedTags='<a><br><b><h1><h2><h3><h4><i>' .
             '<li><ol><p><strong><u><ul>';
  
 $body .= strip_tags(stripslashes( $blogPosts[ $key ]["content"] ), $allowedTags) . "\n <br><br>";
 
 $body .= "<table border=\"0\" width=\"100%\"><tr><td align=\"left\" style=\"font-family: arial; font-size: 11px; letter-spacing: 1px; line-height: 14px;\">";
 	if ( count( $comments ) > 0 )
			{
	if ( count( $comments) > 3 ) {
		$body .= "<a id=\"commentHeader".$blogPosts[ $key ]["id"]."\" href=\"javascript:toggleComments('commentContent".$blogPosts[ $key ]["id"]."','commentHeader".$blogPosts[ $key ]["id"]."');\" >Visa alla kommentarer</a> (".count( $comments ).")";
	} else {
		$body .= "<a id=\"commentHeader".$blogPosts[ $key ]["id"]."\" href=\"javascript:toggleComments('commentContent".$blogPosts[ $key ]["id"]."','commentHeader".$blogPosts[ $key ]["id"]."');\" >Dölj kommentarer</a> (".count( $comments ).")";
	}
		}
		$body .= "</td><td align=\"right\" style=\"font-family: arial; font-size: 11px; letter-spacing: 1px; line-height: 14px;\">";

$body .= "<span onMouseOver=\"document.kommentera_img.src='".$baseUrl."/img/symbols/gif_red/lamna_kommentar.gif'\" onMouseOut=\"document.kommentera_img.src='".$baseUrl."/img/symbols/gif_purple/lamna_kommentar.gif'\"><a id=\"writeCommentHeader".$blogPosts[ $key ]["id"]."\" href=\"javascript:toggleWriteComments('writeCommentContent".$blogPosts[ $key ]["id"]."','writeCommentHeader".$blogPosts[ $key ]["id"]."');\" >Kommentera <img src=\"".$baseUrl."/img/symbols/gif_purple/lamna_kommentar.gif\" name=\"kommentera_img\" align=\"ABSMIDDLE\" border=\"0\" /></a></span></td></tr><tr><td colspan=\"2\" style=\"margin:none;padding:none; border-top: 1px dotted #c8c8c8;\" valign=\"top\">&nbsp;</td></tr></table>";


		$body .= "<div id=\"writeCommentContent".$blogPosts[ $key ]["id"]."\" style=\"display: none; float:right; margin-top:20px; margin-right:30px;\"><form method=\"post\" enctype=\"multipart/form-data\" name=\"commentForm".$blogPosts[ $key ]["id"]."\">
<input type=\"hidden\" name=\"type\" value=\"commentBlog\" />
<input type=\"hidden\" name=\"id\" value=\"".$blogPosts[ $key ]["id"]."\" />
	<div style=\"display: inline; float: right; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<textarea name=\"comment\" style=\"width: 365px; height: 40px; border: 0px\"></textarea>

	</div><div style=\"clear:both;\"></div><div style=\"float:right;\">
		<span onMouseOver=\"document.pub_komment_img.src='".$baseUrl."/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.pub_komment_img.src='".$baseUrl."/img/symbols/gif_purple/skicka.gif'\"><nobr><a href=\"#noexist\" onClick=\"document.commentForm".$blogPosts[ $key ]["id"].".submit();\">Publicera kommentar <img src=\"".$baseUrl."/img/symbols/gif_purple/skicka.gif\" name=\"pub_komment_img\" align=\"ABSMIDDLE\" border=\"0\" /></a></nobr></span></div>
		</form></div>";
		if ( count( $comments) > 0 ) {
		if ( count( $comments) > 3 ) {
		$body .= "<div id=\"commentContent".$blogPosts[ $key ]["id"]."\" style=\"display: none; float:right; width:595px; margin-top:20px;\">";
		} else {
		$body .= "<div id=\"commentContent".$blogPosts[ $key ]["id"]."\" style=\"display: block;float:right; width:595px;  margin-top:20px;\">";
		}

			while ( list( $key3, $value3 ) = each( $comments ) )
			{
				$q = "SELECT * FROM fl_images WHERE userId = " . (int)$comments[ $key3 ]["userId"] . " AND imageType = 'profileSmall'";
				$profileImage = $DB->CacheGetRow( 20*60, $q, FALSE, TRUE );
				if ( count( $profileImage ) > 0 )
				{
					$avatar = "<img src=\"" . $profileImage["imageUrl"] . "\" border=\"0\" width=\"" . $profileImage["width"] . "\" height=\"" . $profileImage["height"] . "\" />";
				}
				else
				{
					$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
				}
				$comments[ $key3 ]["avatar"] = $avatar;

				$q = "SELECT * FROM fl_images WHERE userId = " . (int)$comments[ $key3 ]["userId"] . " AND imageType = 'profileMedium'";
				$guestImage = $DB->CacheGetRow( 20*60, $q, FALSE, TRUE );
				if ( count( $guestImage ) > 0 )
				{
					$comments[ $key3 ]["mediumAvatar"] = $guestImage["imageUrl"];
				}
				else
				{
					$comments[ $key3 ]["mediumAvatar"] = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
				}

				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$comments[ $key3 ]["userId"] . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
				$statusRow = $DB->CacheGetRow( 3*60, $q, FALSE, TRUE );
				$comments[ $key3 ]["status"] = $statusRow["statusMessage"];
			}
			reset($comments);
$body .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px\">";
while ( list( $key3, $value3 ) = each( $comments ) )
		{
		




			unset( $onlineTime );
			// Possible date-types: Today, Yesterday, ThisYear, LastYear
			if ( date("Y-m-d", $comments[ $key3 ]["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$onlineTime = "<div class=\"email_date\">" . "Idag kl " . date( "H:i", $comments[ $key3 ]["unixTime"] ) . "</div>";
			}
			elseif ( date("Y-m-d", $comments[ $key3 ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$onlineTime = "<div class=\"email_date\">" . "Ig&aring;r kl " . date( "H:i", $comments[ $key3 ]["unixTime"] ) . "</div>";
			}
			elseif ( date("Y", $comments[ $key3 ]["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$onlineTime = "<div class=\"email_date\">" . date( "j M Y H:i", $comments[ $key3 ]["unixTime"] ) . "</div>";
			}
			else
			{
				$onlineTime = "<div class=\"email_date\">" . date( "Y-m-d H:i", $comments[ $key3 ]["unixTime"] ) . "</div>";
			}

			$body.= "<tr>
			<td style=\"padding-bottom: 10px; width:30px;\" valign=\"top\">&nbsp;</td>
 	<td style=\"width: 30px; padding-bottom: 10px; padding-right: 10px\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . stripslashes( $comments[ $key3 ]["username"] ) . ".html\" style=\"font-weight: normal\">" . $comments[ $key3 ]["avatar"] . "</a></td>
 	<td style=\"width: 110px;padding-bottom: 10px\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . stripslashes( $comments[ $key3 ]["username"] ) . ".html\">" . $comments[ $key3 ]["username"] . "</a><br />" . $onlineTime . "

 	</td>
  	<td style=\"padding-bottom: 10px\" valign=\"top\">" . stripslashes($comments[ $key3 ]["comment"]) . "</td>
 </tr><tr><td colspan=\"4\" style=\"margin:none;padding:none; border-top: 1px dotted #c8c8c8;\" valign=\"top\">&nbsp;</td></tr>";
#			$body.= "<tr>
# 	<td colspan=\"4\" style=\"padding-bottom: 5px; border-top: 1px dotted #c8c8c8;\" valign=\"top\">&nbsp;</td>
# </tr>";




		

		}
		$body .= "</table></div>";
			}
		

			$printed++;
			$body .= "</div>";


			if ($editBlog == TRUE) {
				


		
$body .= "
<div id=\"popupEditBlog".$blogPosts[ $key ]["id"]."\" class=\"popup\" style=\"display: none\">

<div id=\"divHeadSpace\" style=\"boder-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;\">

	<div style=\"float: left; display: block\"><h3>Redigera blogginlägg</h3></div>
	<div style=\"float: right; display: block\"><a href=\"#\" onclick=\"closePopup('popupEditBlog".$blogPosts[ $key ]["id"]."');\"><img src=\"".$baseUrl."/img/kryss_edit.gif\" name=\"closeFriendPopup\" border=\"0\" onMouseOver=\"document.closeFriendPopup.src='".$baseUrl."/img/kryss_edit_red.gif'\" onMouseOut=\"document.closeFriendPopup.src='".$baseUrl."/img/kryss_edit.gif'\" style=\"margin: 10px\" /></a></div>

&nbsp;</div>

<form method=\"post\" enctype=\"multipart/form-data\" style=\" padding-bottom: 20px\" name=\"editBlog".$blogPosts[ $key ]["id"]."form\">
<input type=\"hidden\" name=\"type\" value=\"editBlog\" />
<input type=\"hidden\" name=\"id\" value=\"".$blogPosts[ $key ]["id"]."\" />
<div style=\"float: left; width: 130px;margin-left: 30px;\">Rubrik:</div>


<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
<input type=\"text\" name=\"subject\" style=\"width: 197px; border: 0px\" value=\"".stripslashes(str_replace("\"", "&quot;", $blogPosts[ $key ]["subject"]))."\"></div>&nbsp;&nbsp;
<div style=\"float:none;\"></div><br>

<div style=\"float: left; width: 130px;margin-left: 30px;\">Inlägg:</div>

<div style=\"display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;\">
	<textarea name=\"content\" style=\"width: 397px; height: 300px; border:0px; \">".stripslashes( br2nl($blogPosts[ $key ]["content"]) )."</textarea>
	</div>
<div style=\"clear:both;\"></div><br>
		
<br>

<span onMouseOver=\"document.addFriendSubmit.src='".$baseUrl."/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.addFriendSubmit.src='".$baseUrl."/img/symbols/gif_purple/skicka.gif'\" style=\"margin-left: 10px;\"><nobr><a href=\"#noexist\" onClick=\"document.editBlog".$blogPosts[ $key ]["id"]."form.submit();\" style=\"margin-left: 30px;\"><img src=\"".$baseUrl."/img/symbols/gif_purple/skicka.gif\" name=\"addFriendSubmit\" align=\"ABSMIDDLE\" border=\"0\" />Spara ändringar</a></nobr></span>
</form>

</div>
";


			}

		}
	} else {
		if ($editBlog == TRUE) {
						$body.= "<br><br><p style=\"margin-left:30px;\">Du har inte skrivit något i din blogg än.</p><br>";

		} else {
		$body .= "<p>" . stripslashes( $userPres["username"] ) . " har inte skrivit något i sin blogg än.</p>";
		}
	}

$body .= "<div style=\"clear:both;\"></div>";
	// Paging
	if ( count( $blogPosts ) > $numPerPage )
	{
		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"#noexist\" onClick=\"javascript: location.search='?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "';\">F&ouml;reg&aring;ende sida</a></div>";
		}
		else
		{
			$body.= "<div id=\"previous\">&nbsp;</div>\n";
		}
		$body.= "<div id=\"middle\" style=\"text-align: center\"><b>" . $printed . "</b> av <b>". count( $blogPosts ) . "</b></div>\n";
		if ( $i < count( $blogPosts ) )
		{
			$body.= "<div id=\"next\"><a href=\"#noexist\" onClick=\"javascript: location.search='?offset=" . $i . "';\">N&auml;sta sida</a></div>";
		}
	}
	else
	{
		if ($printed > 0) {
		$body.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>" .  $printed  . "</b> av <b>" . count( $blogPosts ) . "</b></div>\n";		
		}
	}

	$body.= "



</div>

</div><div id=\"right\">";
if ( $editBlog == TRUE )
{
	$body.= rightMenu('blog');
}
else
{
	$body.= rightMenu('userBlog');
}
$body.= "</div>";

}
?>