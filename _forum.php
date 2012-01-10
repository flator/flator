<?php
$metaTitle = "Flator.se - Forum";
$numPerPage = 50;

if ( (int)$_SESSION["rights"] < 2 )
{
	$body .= "Endast för inloggade";
}
else
{

	$currentLink = array();
	$q = "SELECT * FROM fl_forum_cat ORDER BY name ASC";
	$currentLink["date"] = " class=\"current\"";

	$mailArray = $DB->GetAssoc( $q, FALSE, TRUE );
#	for( $i = 0; $i < 155; $i++ )
#	{
#		$mailArray[ $i+20 ]["username"] = $i;
#	}




	$body = "<div id=\"center\">
";

$body .= "

<table cellspacing=\"1\">
	<tr> 
		<th >Kategori</th>
		<th width=\"50px\">Trådar</th>
		<th width=\"50px\">Svar</th>

		<th width=\"120px\">Senaste inlägg</th>
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



			$sql2 = "SELECT COUNT(id) FROM fl_forum_threads WHERE catId = '".$mailArray[ $key ]["id"]."' AND newThread='YES'"; 
			$result2 = mysql_query($sql2); 
			$row2 = mysql_fetch_array($result2); 
			$tcount = $row2[0];

			$sql2 = "SELECT COUNT(id) FROM fl_forum_threads WHERE catId='".$mailArray[ $key ]["id"]."' AND newThread='NO'"; 
			$result2 = mysql_query($sql2); 
			$row2 = mysql_fetch_array($result2); 
			$svcount = $row2[0];

			if ($tcount >= '1') {

				$sql = "SELECT fl_forum_threads.*, fl_users.username, UNIX_TIMESTAMP( fl_forum_threads.insDate ) AS unixTime FROM fl_forum_threads LEFT JOIN fl_users ON fl_users.id = fl_forum_threads.userId WHERE catId='".$mailArray[ $key ]["id"]."' ORDER BY id DESC LIMIT 1";
				$result = mysql_query($sql);
				while ( $row = mysql_fetch_assoc($result) ) {
					$f_name = '<span class="email_date">Av:</span> <a href="'.$baseUrl.'/user/'.$row['username'].'.html">'.$row['username'].'</a>';
					$f_dat = $row['insDate'];
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
						if ($row['newThread'] == "NO") {

							$sql = "SELECT fl_forum_threads.* FROM fl_forum_threads WHERE id='".$row['threadId']."' AND newThread = 'YES' ORDER BY id DESC LIMIT 1";
							$result2 = mysql_query($sql);
							while ( $row2 = mysql_fetch_assoc($result2) ) {
								$f_rub = '<a href="'.$baseUrl.'/forum/'.$forumCats[ $mailArray[ $key ]["id"] ][ "shortname" ].'/'.$row2['slug'].'.html">'.$row2['headline'].'</a>';
							}
						} else {
							$f_rub = $row['headline'];
							$f_rub = '<a href="'.$baseUrl.'/forum/'.$forumCats[ $mailArray[ $key ]["id"] ][ "shortname" ].'/'.$row['slug'].'.html">'.$row['headline'].'</a>';

						}
				}

			}


$f_rub = truncate($f_rub, 25, "..", TRUE, TRUE);


			$body .= '
	<tr> 
		<td colspan="5"  style="padding: 0px; border-top: 1px dotted #c8c8c8;line-height:1px;font-size:1px;height:1px;">&nbsp;</td>

</tr>
<tr> 
		<td style="vertical-align:top; padding-top:5px; padding-bottom:6px; padding-right:50px;">
				<b><a href="'.$baseUrl.'/forum/'.$mailArray[ $key ]["shortname"].'.html">'.$mailArray[ $key ]["name"].'</a></b>
				<br />
				<span class="forumdesc">'.$mailArray[ $key ]["desc"].'</span>	
		</td>

		<td style="vertical-align:middle; width:50px; padding-top:5px; padding-bottom:6px;">'.$tcount.'</td>
		<td style="vertical-align:middle; width:50px; padding-top:5px; padding-bottom:6px;">'.$svcount.'</td>
		<td style="vertical-align:top; width:120px; padding-top:5px; padding-bottom:6px;" nowrap="nowrap"><span class="email_date">';

		if ($tcount >= '1') {
		$body .= $f_dat.'<br></span>
		'.$f_rub.'<br /> '.$f_name;
		}

$body .= '</span></td>
	</tr>
';


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
			$body.= "<tr><td colspan=\"4\">Du har inga meddelanden i din inbox.</td></tr>";
		}
	}

	$body.= "</table>\n\n	<div id=\"divFooterSpace\">";
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

}
?>