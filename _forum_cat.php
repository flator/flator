<?php
$metaTitle = "Flator.se - Forum";
$numPerPage = 50;

if ( (int)$_SESSION["rights"] < 2 )
{
	$body .= "Endast för inloggade";
}
else
{
	
	if (strlen($_GET["thread"]) < 1) {
		

	if ($_POST['type'] == "writeForumThread") {
	  if (empty($_POST['text']) or empty($_POST['headline'])) {
		   $body .= "<script language='javascript'>alert('Du måste ange både en rubrik och ett inlägg.'); self.location.href='';</script>";
	  } else {
		$alphanum = "abcd987654321efghijklmnopqrstuvwxyz123456789";
		$rand = substr(str_shuffle($alphanum), 0, 4);
		$headlineSlug = toSlug($_POST['headline']);
		$resultHeadline = mysql_query( "SELECT id FROM fl_forum_threads WHERE slug = '".$headlineSlug."' LIMIT 1" );
		if (mysql_num_rows($resultHeadline) > 0) {
			$headlineSlug = $rand."-".$headlineSlug;
		}
		$sql = "INSERT INTO fl_forum_threads (insDate, newThread, catId, threadId, userId, headline, slug, text, lastThreadUpdate) VALUES(NOW(), 'YES', (SELECT id FROM fl_forum_cat WHERE shortname = '".addslashes($_GET["forumCat"])."' LIMIT 1), 0, '".$userProfile['id']."', '".$_POST['headline']."', '".$headlineSlug."', '".$_POST['text']."', NOW())";
		mysql_query($sql);

	   echo "<script language='javascript'>alert('Tråd skapad!'); self.location.href='".$baseUrl."/forum/".$_GET["forumCat"]."/".$headlineSlug.".html';</script>";
	  }
	} else { }


	$currentLink = array();
	$q = "SELECT fl_forum_threads.*, fl_users.username, UNIX_TIMESTAMP( fl_forum_threads.insDate ) AS unixTime FROM fl_forum_threads LEFT JOIN fl_forum_cat ON fl_forum_cat.id = fl_forum_threads.catId LEFT JOIN fl_users ON fl_forum_threads.userId = fl_users.id WHERE fl_forum_cat.shortname = '".addslashes($_GET["forumCat"])."' AND fl_forum_threads.newThread = 'YES' ORDER BY fl_forum_threads.lastThreadUpdate DESC";
	$currentLink["date"] = " class=\"current\"";

	$mailArray = $DB->GetAssoc( $q, FALSE, TRUE );
#	for( $i = 0; $i < 155; $i++ )
#	{
#		$mailArray[ $i+20 ]["username"] = $i;
#	}




	$body = "<div id=\"center\">

<span onMouseOver=\"document.ny_trad_up.src='" . $baseUrl . "/img/symbols/gif_red/blogg_inlagg.gif'\" onMouseOut=\"document.ny_trad_up.src='" . $baseUrl . "/img/symbols/gif_purple/blogg_inlagg.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupWriteForum');\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/blogg_inlagg.gif\" border=\"0\" align=\"ABSMIDDLE\" name=\"ny_trad_up\" />&nbsp;&nbsp;Ny tråd</a></span>
<table cellspacing=\"1\" style=\"border-top: 1px dotted #c8c8c8; margin-top:6px; width:100%;\">
	<tr> 
		<th  width=\"50px\" align=\"center\">&nbsp;</th>
		<th nowrap=\"nowrap\">Ämnestitel</th>
		<th width=\"50px\" style=\"text-align:center\" nowrap=\"nowrap\">Svar</th>
		<th width=\"50px\" style=\"text-align:center\" nowrap=\"nowrap\">Visad</th>

		<th width=\"120px\" nowrap=\"nowrap\">Senaste inlägg</th>
	</tr>";

	if ( count( $mailArray ) > 0 )
	{
		$i = (int)$_GET["offset"];
		$i2 = 0;

		while ( list( $key, $value ) = each( $mailArray ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$i++;

			
			if ( date("Y-m-d", $mailArray[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$f_dat = "Idag kl " . date( "H:i", $mailArray[ $key ]["unixTime"] );
			}
			elseif ( date("Y-m-d", $mailArray[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$f_dat = "Ig&aring;r kl " . date( "H:i", $mailArray[ $key ]["unixTime"] );
			}
			elseif ( date("Y", $mailArray[ $key ]["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$f_dat = date( "j M Y H:i", $mailArray[ $key ]["unixTime"] );
			}
			else
			{
				$f_dat = date( "Y-m-d H:i", $mailArray[ $key ]["unixTime"] );
			}

			$sql2 = "SELECT COUNT(id) FROM fl_forum_threads WHERE threadId = '".$mailArray[ $key ]["id"]."' AND newThread = 'NO'"; 
			$result2 = mysql_query($sql2); 
			$row2 = mysql_fetch_array($result2); 
			$scount = $row2[0];


			$f_name = "";
			$sql = "SELECT fl_forum_threads.*, fl_users.username, UNIX_TIMESTAMP( fl_forum_threads.insDate ) AS unixTime FROM fl_forum_threads LEFT JOIN fl_users ON fl_users.id = fl_forum_threads.userId WHERE threadId='".$mailArray[ $key ]["id"]."' ORDER BY id DESC LIMIT 1";

			$result = mysql_query($sql);
			while ( $row = mysql_fetch_assoc($result) ) {
			$f_name = $row['username'];
			if ( date("Y-m-d", $row['unixTime'] ) == date( "Y-m-d" ) )
						{
							// Message sent today
							$f_dat = "Idag kl " . date( "H:i", $row['unixTime'] );
						}
						elseif ( date("Y-m-d", $row['unixTime'] ) == date( "Y-m-d", ( time() - 86400 ) ) )
						{
							// Message sent yesterday
							$f_dat = "Ig&aring;r kl " . date( "H:i", $row['unixTime'] );
						}
						elseif ( date("Y", $row['unixTime'] ) == date( "Y" ) )
						{
							// Message sent this year
							$f_dat = date( "j M Y H:i", $row['unixTime'] );
						}
						else
						{
							$f_dat = date( "Y-m-d H:i", $row['unixTime'] );
						}
			}


$textSnippet = truncate(stripBBCode(stripslashes($mailArray[ $key ]["text"])), 35, "..", TRUE, TRUE);

			$body .= '
	<tr> 
		<td colspan="5"  style="padding: 0px; border-top: 1px dotted #c8c8c8;line-height:1px;font-size:1px;height:1px;">&nbsp;</td>

</tr>
<tr> 
		<td align="center" class="row2" width="1%"> <img src="'.$baseUrl.'/img/symbols/gif_purple/grupp.gif" border="0"></td>
		<td class="row2">
				<b><a href="'.$baseUrl.'/forum/'.$_GET["forumCat"].'/'.$mailArray[ $key ]["slug"].'.html">

          '.$mailArray[ $key ]["headline"].'&nbsp;&nbsp;<span class="email_date">'.$textSnippet.'</span>
</a></b>	
		</td>

		<td align="center" class="row1">'.$scount.'</td>
		
		<td align="center" class="row1">'.$mailArray[ $key ]["views"].'</td>';
if ($f_name == "") {
$body .= '<td class="row1"><a href="'.$baseUrl.'/user/'.$mailArray[ $key ]["username"].'.html">'.$mailArray[ $key ]["username"].'</a><br><span class="email_date">'.$f_dat.'</span></td>
	</tr>'; } else {
$body .= '		<td class="row1"><a href="'.$baseUrl.'/user/'.$f_name.'.html">'.$f_name.'</a><br><span class="email_date">'.$f_dat.'</span></td>
	</tr>';
	}
	}
	}
	else
	{
		if ( strlen( $_POST["mailSearchQuery"] ) > 0 )
		{
			$body.= "<tr><td colspan=\"4\">Inga meddelanden matchade din sökning. (" . htmlentities( stripslashes( $_POST["mailSearchQuery"] ) ) . ")</td></tr>";
		}
		else
		{
			$body.= "<tr><td colspan=\"4\">Ingen har skrivit i detta forum än!<br><br><span onMouseOver=\"document.ny_trad_inF.src='" . $baseUrl . "/img/symbols/gif_red/blogg_inlagg.gif'\" onMouseOut=\"document.ny_trad_inF.src='" . $baseUrl . "/img/symbols/gif_purple/blogg_inlagg.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupWriteForum');\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/blogg_inlagg.gif\" border=\"0\" align=\"ABSMIDDLE\" name=\"ny_trad_inF\" />&nbsp;&nbsp;Ny tråd</a></span></td></tr>";
		}
	}

	$body.= "</table>\n\n	
	
	<div id=\"divFooterSpace\">";
/*
	// Paging
	if ( count( $mailArray ) > $numPerPage )
	{
		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/inbox.html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&sortBy=" . (int)$_GET["sortBy"] . "\">F&ouml;reg&aring;ende sida</a></div>";
		}
		else
		{
			$body.= "<div id=\"previous\">&nbsp;</div>\n";
		}
		$body.= "<div id=\"middle\" style=\"text-align: center\"><b>" . $i2 . "</b> av <b>". count( $mailArray ) . "</b></div>\n";
		if ( $i < count( $mailArray ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/inbox.html?offset=" . $i . "&sortBy=" . (int)$_GET["sortBy"] . "\">N&auml;sta sida</a></div>";
		}
	}
	else
	{
		$body.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>" . count( $mailArray ) . "</b> av <b>" . count( $mailArray ) . "</b></div>\n";		
	}
*/
	$body.= "&nbsp;</div></p></form>

</div>

<div id=\"right\">";
$body.= rightMenu('myAccount');
$body.= "</div>";
} else {
include("_forum_thread.php");
}
}
?>