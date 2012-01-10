<?php
/* Get configuration */
require ("href_config.php");

/* Build current URL, if one hasn't manually alreday been set */
$seo_current_url = ( @$_SERVER["HTTPS"] == "on" ) ? "https://":"http://";
$seo_current_url.= strtolower( $_SERVER["HTTP_HOST"] );
if ( strlen( $_SERVER["REQUEST_URI"] ) > 0 )
{
	$seo_current_url.= $_SERVER["REQUEST_URI"];
}
elseif ( strlen( $_SERVER["ORIG_PATH_INFO"] ) > 0 )
{
	$seo_current_url.= $_SERVER["ORIG_PATH_INFO"];
	if ( strlen( $_SERVER["QUERY_STRING"] ) > 0 )
	{
		$seo_current_url.= "?" . $_SERVER["QUERY_STRING"];
	}
}
$seo_current_url = eregi_replace( "([?|&]+)(osCsid=([^&]*))", "\\1", $seo_current_url ); // Remove OS Commerce Session ID
$seo_current_url = eregi_replace( "([?|&]+)(PHPSESSID=([^&]*))", "\\1", $seo_current_url ); // Remove PHPSESSID

unset( $href_output );

/* Get data */
if ( $data_stored == "text" )
{
	list( $template_id, $ads ) = text_get_ads( $relative_path . "hreflink.data.db", $seo_current_url, @$seo_config_url, $relative_path );
	$template = text_get_template( $relative_path . "hreflink.template.db", $seo_current_url, @$seo_config_url, $relative_path, $template_id );
}
elseif ( $data_stored == "mysql" )
{
	/* Connect to MySQL database */
	$db_seo = @mysql_connect( $db_host, $db_username, $db_password );
	if ( mysql_errno() > 0 ) 
	{
		echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
		echo "\n<br />[SEO-01] Problems accessing the database, or invalid login information?\n";
	}
	@mysql_select_db( $db_name );
	if ( mysql_errno() > 0 ) 
	{
		echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
		echo "\n<br />[SEO-02] Wrong database name?\n";
	}

	list( $template, $ads ) = mysql_get_data($db_seo, $db_table_prefix, $seo_current_url, $seo_config_url);
}

if ( count( $ads ) > 0 ) // Are any ads found?
{
	if ( count( $template ) > 0 ) // Look for a template
	{
		@$href_output .= $template["header"]."\n";

		while( list( $key, $value ) = each( $ads ) )
		{
			$ad = $template["link_body"];
			$ad = str_replace("[url]", urldecode( $ads[ $key ]["url"] ), $ad );
			$ad = str_replace("[main_url]", urldecode( $ads[ $key ]["main_url"] ), $ad );
			$ad = str_replace("[anchor_text]", $ads[ $key ]["anchor_text"], $ad );
			if ( @$template["anchor_text_link"] == "YES" )
			{
				
				$pattern = '/\b'.$ads[ $key ]["anchor_text"].'\b/i';
				if ( preg_match( $pattern, $ads[ $key ]["description"], $matches ) )
				{
					
					$ads[ $key ]["description"] = preg_replace( $pattern, "<a href=\"" . urldecode( $ads[ $key ]["url"] ) . "\">".$matches[0]."</a>", $ads[ $key ]["description"], 1 );
					
					$ad = str_replace( "[read_more]", "", $ad);
				}
				else
				{
					if ( strlen( @$template["read_more"] ) > 0 )
					{
						$read_more = $template["read_more"];
						$read_more = str_replace("[url]", urldecode( $ads[ $key ]["url"] ), $read_more );
						$read_more = str_replace("[main_url]", urldecode( $ads[ $key ]["main_url"] ), $read_more );
						$read_more = str_replace("[anchor_text]", $ads[ $key ]["anchor_text"], $read_more );
						$read_more = str_replace("[description]", $ads[ $key ]["description"], $read_more );
						$read_more = str_replace("[title]", $ads[ $key ]["title"], $read_more );
						$ad = str_replace( "[read_more]", $read_more, $ad);
					}
					else
					{
						$ads[ $key ]["description"] .= " <a href=\"" . urldecode( $ads[ $key ]["url"] ) . "\">" . $ads[ $key ]["anchor_text"] . "</a>";
					}
				}
			}
			$ad = str_replace( "[read_more]", "", $ad );
			$ad = str_replace("[description]", $ads[ $key ]["description"], $ad );
			$ad = str_replace("[title]", $ads[ $key ]["title"], $ad );
			$href_output .= urldecode( $ad )."\n";
		}

		$href_output .= $template["footer"]."\n";
	}
}
else
{
	$href_output = "-";
	if ( $_SERVER["REMOTE_ADDR"] == "194.218.229.18" ) $href_output .= " - " . $seo_current_url;
}

function text_get_ads( $file, $seo_current_url = "", $seo_config_url = "", $relative_path = "" )
{
	$tmp_url = urlencode( $seo_current_url );

	$content = @file_get_contents( $file ); // Get data from text-file.
	if ( strlen( $content ) > 0 )
	{
		$rows = explode( "\n", $content );

		if ( count( $rows ) > 0 ) // If text-file isn't empty
		{
			while ( list( $key, $value ) = each( $rows ) )
			{
				$columns = explode( "]|[", $value );
				if ( count( $columns ) > 0 )
				{
					$ref1 = $columns[0];

					if ( eregi( "^template", @$columns[1] ) ) // Get the template name
					{
						list ( $tmp, $template_id ) = split( "\]=\[", $columns[1] );
						$ads[ $ref1 ]["template"] = $template_id;
					}
					elseif ( eregi( "^ads", @$columns[1] ) ) // Get the ads for this URL
					{
						$i = 0;
						while( list( $key2, $value2 ) = each( $columns ) )
						{
							$i++;
							if ( $i == 3 ) $ref2 = $value2;
							if ( $i > 3 )
							{
								list ( $key3, $value3 ) = split( "\]=\[", $value2 );
								$ads[ $ref1 ]["ads"][ $ref2 ][ $key3 ] = $value3;
							}

						}
					}
				}
			}
		}
	}

	if ( @$ads[ $tmp_url ]["template"] )
	{
		$template_id = trim( $ads[ $tmp_url ]["template"] );
		$ads2 = $ads[ $tmp_url ]["ads"];
	}
	else
	{
		// Save new URL to queue. Don't search for duplicate, this is done when picked up by server
		if ( $fp = fopen( $relative_path . "hreflink.queue.db", "a" ) )
		{
			fwrite( $fp, $seo_current_url . "]|[" . $seo_config_url . "\n" );

			fclose( $fp );
		}
		else
		{
			echo "\n<br />[SEO-06] Cannot open file (" . $relative_path . "hreflink.queue.db" . ")";
		}

	}

	return array( @$template_id, @$ads2 );
}

function text_get_template( $file, $seo_current_url = "", $seo_config_url = "", $relative_path = "", $template_id = "" )
{
	$content = @file_get_contents( $file ); // Get template from text-file.
	if ( strlen( $content ) > 0 )
	{
		$rows = explode( "\n", $content );
		if ( count( $rows ) > 0 ) // If text-file isn't empty
		{
			while ( list( $key, $value ) = each( $rows ) )
			{
				$columns = explode( "]|[", $value );
				if ( count( $columns ) > 0 )
				{
					$ref1 = $columns[0];

					$i = 0;
					while( list( $key2, $value2 ) = each( $columns ) )
					{
						$i++;
						if ( $i > 1 )
						{
							list ( $key3, $value3 ) = split( "\]=\[", $value2 );
							$template[ $ref1 ][ $key3 ] = $value3;
						}
					}
				}
			}
		}
	}

	return @$template[ $template_id ];
}

function mysql_get_data($db_seo, $db_table_prefix = "", $seo_current_url = "", $seo_config_url = "")
{
	/* Save all templates */
	$template = array();
	$q = "SELECT * FROM " . $db_table_prefix . "template";
	$result = @mysql_query( $q, $db_seo );
	if ( mysql_errno() > 0 ) // Error when trying to open tables
	{
		echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
		echo "\n<br />[SEO-03] Problem with tables, not configured?\n";

		// Create ads-table.
		$q = "CREATE TABLE " . $db_table_prefix . "ads (\nid int(10) unsigned NOT NULL auto_increment,\nins_date datetime NOT NULL default '0000-00-00 00:00:00',\n";
		$q.= "data_id int(10) unsigned NOT NULL default '0',\nprio smallint(5) unsigned NOT NULL default '0',\nad_id int(10) unsigned NOT NULL default '0',\n";
		$q.= "url varchar(255) NOT NULL default '',\nmain_url varchar(255) NOT NULL default '',\nanchor_text varchar(255) NOT NULL default '',\n";
		$q.= "description text NOT NULL,\ntitle varchar(255) NOT NULL default '',\nPRIMARY KEY  (id),\nKEY data_id (data_id,ad_id)\n ) TYPE=MyISAM;";
        @mysql_query( $q, $db_seo );

		// Create data-table
		$q = "CREATE TABLE " . $db_table_prefix . "data (\nid int(10) unsigned NOT NULL auto_increment,\nins_date datetime NOT NULL default '0000-00-00 00:00:00',\n";
		$q.= "url varchar(255) NOT NULL default '',\ntemplate_id varchar(23) NOT NULL default '',\nPRIMARY KEY  (id),\nKEY url (url)\n ) TYPE=MyISAM;";
        @mysql_query( $q, $db_seo );

		// Create queue-table
		$q = "CREATE TABLE " . $db_table_prefix . "queue (\nid int(10) unsigned NOT NULL auto_increment,\nins_date datetime NOT NULL default '0000-00-00 00:00:00',\n";
		$q.= "url varchar(255) NOT NULL default '',\nconfig_url varchar(255) NOT NULL default '',\nfound enum('NO','YES') NOT NULL default 'NO',\n";
		$q.= "PRIMARY KEY  (id),\nKEY found (found),\nKEY url (url)\n ) TYPE=MyISAM;";
        @mysql_query( $q, $db_seo );

		// Create template-table
		$q = "CREATE TABLE " . $db_table_prefix . "template (\nid int(10) unsigned NOT NULL auto_increment,\nins_date datetime NOT NULL default '0000-00-00 00:00:00',\n";
		$q.= "template_id varchar(23) NOT NULL default '',\nheader text NOT NULL,\nlink_body text NOT NULL,\nfooter text NOT NULL,\nread_more text NOT NULL,\n";
		$q.= "anchor_text_link enum('NO','YES') NOT NULL default 'NO',\nPRIMARY KEY  (id),\nKEY template_id (template_id)\n ) TYPE=MyISAM;";
        @mysql_query( $q, $db_seo );
	}
	else
	{
		if ( mysql_num_rows( $result ) > 0 )
		{
			while ( $row = @mysql_fetch_array( $result ) ) // Get template-data.
			{
				$template[ $row["template_id"] ]["header"] = $row["header"];
				$template[ $row["template_id"] ]["link_body"] = $row["link_body"];
				$template[ $row["template_id"] ]["footer"] = $row["footer"];
				$template[ $row["template_id"] ]["anchor_text_link"] = $row["anchor_text_link"];
				$template[ $row["template_id"] ]["read_more"] = $row["read_more"];
			}
		}
	}

	/* Find ads for current URL */
	$q = "SELECT " . $db_table_prefix . "ads.id, " . $db_table_prefix . "ads.prio, " . $db_table_prefix . "ads.url, " . $db_table_prefix . "ads.main_url, " . $db_table_prefix . "ads.anchor_text, " . $db_table_prefix . "ads.description, " . $db_table_prefix . "ads.title, " . $db_table_prefix . "data.template_id FROM " . $db_table_prefix . "data LEFT JOIN " . $db_table_prefix . "ads ON " . $db_table_prefix . "data.id = " . $db_table_prefix . "ads.data_id WHERE " . $db_table_prefix . "data.url = '" .  $seo_current_url . "' ORDER BY " . $db_table_prefix . "ads.prio ASC";
	$result = @mysql_query( $q, $db_seo );
	if ( mysql_errno() > 0 ) // Error when trying to open tables
	{
		echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
		echo "\n<br />[SEO-03] Problem with tables, not configured?\n";
	}
	else
	{
		if ( mysql_num_rows( $result ) < 1 ) // Matching URL not found, look for it in queue, if not found, add
		{
			/* Search for current URL in queue */
			$q = "SELECT * FROM " . $db_table_prefix . "queue WHERE url = '" . addslashes( $seo_current_url ) . "'";
			$result = @mysql_query( $q, $db_seo );
			if ( mysql_errno() > 0 ) 
			{
				echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
				echo "\n<br />[SEO-04] Problem with queue table, not configured?\n";
			}
			else
			{
				if ( mysql_num_rows( $result ) < 1 ) // Not found in queue, add
				{
					$q = "INSERT INTO " . $db_table_prefix . "queue (ins_date, url, config_url, found) VALUES (NOW(), '" . addslashes( $seo_current_url ) . "', '" . addslashes( $seo_config_url ) . "',  'NO')";
					@mysql_query( $q, $db_seo );
					if ( mysql_errno() > 0 ) 
					{
						echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
						echo "\n<br />[SEO-05] Unable to queue, invalid permissions?\n";
					}
				}
			}
		}
		else
		{
			while ( $row = @mysql_fetch_array( $result ) ) // Get ad-data.
			{
				// Table columns: ads.id, ads.prio, ads.url, ads.main_url, ads.anchor_text, ads.description, ads.title, config.template
				$template_id = $row["template_id"];
				$ads[ $row["id"] ]["prio"] = $row["prio"];
				$ads[ $row["id"] ]["url"] = stripslashes( urldecode( $row["url"] ) );
				$ads[ $row["id"] ]["main_url"] = stripslashes( urldecode( $row["main_url"] ) );
				$ads[ $row["id"] ]["anchor_text"] = stripslashes( $row["anchor_text"] );
				$ads[ $row["id"] ]["description"] = stripslashes( $row["description"] );
				$ads[ $row["id"] ]["title"] = stripslashes( $row["title"] );
			}
			return array( $template[ $template_id ], $ads );
		}
	}
	return;
}

?>