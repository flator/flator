<?php
/*Don't edit this file*/
$version = 2; // DON'T CHANGE
set_time_limit(0);
ini_set("memory_limit","512M");

/* Get configuration */
require("href_config.php");

/* Validate browser */
if ( @$_GET["site_code"] != $site_code ) exit;
$ads_limit = @$_GET["adslimit"];
$hostname = gethostbyaddr(@$_SERVER['REMOTE_ADDR']);
if ( !eregi( "seowebb.se$", $hostname ) && @$_SERVER["REMOTE_ADDR"] != "194.218.229.18" && @$_SERVER["REMOTE_ADDR"] != "217.28.206.15" ) exit;



/* What should be done? Update ads/templates or send queue-data */
if ( $_GET["action"] == "queue" )
{
	/* Get data */
	if ( $data_stored == "text" )
	{

		$queue_list = text_queue( $relative_path . "hreflink.queue.db" );
	}
	elseif ( $data_stored == "mysql" )
	{
		/* Connect to MySQL database */
		$db_seo = @mysql_connect( $db_host, $db_username, $db_password );
		if ( mysql_errno() > 0 ) 
		{
			echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
			echo "\n<br />[SEO-09] Problems accessing the database, or invalid login information?\n";
		}
		@mysql_select_db( $db_name );
		if ( mysql_errno() > 0 ) 
		{
			echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
			echo "\n<br />[SEO-10] Wrong database name?\n";
		}

		$queue_list = mysql_queue();
	}

	echo $queue_list;
}
elseif ( $_GET["action"] == "ads" )
{
	/* Get updated ads */
	$url = "http://crm.seowebb.se/ADSEO/updater/print_url_update.php?site_id=" . $site_id . "&site_code=" . $site_code . "&adslimit=" . $ads_limit . "&version=" . $version . "&path=" . urlencode($relative_path) . "&datastored=" . $data_stored;

	$content = fetchURL( $url );

	/* Read data into array */
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

					if ( eregi( "^template", $columns[1] ) ) // Get the template name
					{
						list ( $tmp, $template_id ) = split( "\]=\[", $columns[1] );
						$ads[ $ref1 ]["template"] = $template_id;
					}
					elseif ( eregi( "^ads", $columns[1] ) ) // Get the ads for this URL
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

	/* Match and update data */
	if ( $data_stored == "text" )
	{

		$content2 = @file_get_contents( $relative_path . "hreflink.data.db" ); // Get data from text-file.
		if ( strlen( $content2 ) > 0 )
		{
			$rows = explode( "\n", $content2 );

			if ( count( $rows ) > 0 ) // If text-file isn't empty
			{
				while ( list( $key, $value ) = each( $rows ) )
				{
					$columns = explode( "]|[", $value );
					if ( count( $columns ) > 0 )
					{
						$ref1 = $columns[0];

						if ( eregi( "^template", $columns[1] ) ) // Get the template name
						{
							list ( $tmp, $template_id ) = split( "\]=\[", $columns[1] );
							$ads2[ $ref1 ]["template"] = $template_id;
						}
						elseif ( eregi( "^ads", $columns[1] ) ) // Get the ads for this URL
						{
							$i = 0;
							while( list( $key2, $value2 ) = each( $columns ) )
							{
								$i++;
								if ( $i == 3 ) $ref2 = $value2;
								if ( $i > 3 )
								{
									list ( $key3, $value3 ) = split( "\]=\[", $value2 );
									$ads2[ $ref1 ]["ads"][ $ref2 ][ $key3 ] = $value3;
								}

							}
						}
					}
				}
			}
		}

		/* Loop through all url's and check if they already exist */
		if ( count( @$ads ) > 0 )
		{
			while ( list( $key, $value ) = each( $ads ) )
			{
				if ( !$ads2[ $key ]["template"] ) // New URL, insert data
				{
					$ads2[ $key ]["template"] = $ads[ $key ]["template"];
				}
				elseif ( $ads2[ $key ]["template"] != $ads[ $key ]["template"] ) // New template, update data
				{
					$ads2[ $key ]["template"] = $ads[ $key ]["template"];
				}

				/* Loop through all ads for this URL, save new ads and save changes */
				if ( count( $ads[ $key ]["ads"] ) > 0 )
				{
					while ( list( $key2, $value2 ) = each( $ads[ $key ]["ads"] ) )
					{
						if ( $ads[ $key ]["ads"][ $key2 ]["prio"] == "delete" ) // Ad deleted
						{
							unset( $ads2[ $key ]["ads"][ $key2 ] );
						}
						else
						{
							$ads2[ $key ]["ads"][ $key2 ] = $ads[ $key ]["ads"][ $key2 ];
						}
					}
				}
			}
		}

		/* Loop through array and save data to file */
		@reset( $ads2 );
		unset( $content );
		if ( count( $ads2 ) > 0 )
		{
			while ( list( $key, $value ) = each( $ads2 ) )
			{
				$content .= $key . "]|[template]=[" . $ads2[ $key ]["template"] . "\n";

				if ( count( $ads2[ $key ]["ads"] ) > 0 )
				{
					while ( list( $key2, $value2 ) = each( $ads2[ $key ]["ads"] ) )
					{
						$content .= $key . "]|[ads]|[" . $key2 . "]|[prio]=[" . $ads2[ $key ]["ads"][ $key2 ]["prio"] . "]|[url]=[" . $ads2[ $key ]["ads"][ $key2 ]["url"] . "]|[main_url]=[" . $ads2[ $key ]["ads"][ $key2 ]["main_url"] . "]|[anchor_text]=[" . $ads2[ $key ]["ads"][ $key2 ]["anchor_text"] . "]|[description]=[" . $ads2[ $key ]["ads"][ $key2 ]["description"] . "]|[title]=[" . $ads2[ $key ]["ads"][ $key2 ]["title"] . "\n";
					}
				}
			}
		}

		if ( $fp = fopen( $relative_path . "hreflink.data.db", "w" ) )
		{
			fwrite( $fp, @$content );

			fclose( $fp );
		}
	}
	elseif ( $data_stored == "mysql" )
	{
		/* Connect to MySQL database */
		$db_seo = @mysql_connect( $db_host, $db_username, $db_password );
		if ( mysql_errno() > 0 ) 
		{
			echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
			echo "\n<br />[SEO-09] Problems accessing the database, or invalid login information?\n";
		}
		@mysql_select_db( $db_name );
		if ( mysql_errno() > 0 ) 
		{
			echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
			echo "\n<br />[SEO-10] Wrong database name?\n";
		}

		$urls = array();
		$q = "SELECT * FROM " . $db_table_prefix . "data";
		$result = @mysql_query( $q, $db_seo );
		if ( mysql_errno() > 0 ) // Error when trying to open tables
		{
			echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
			echo "\n<br />[SEO-11] Unable to save url-data\n";
		}
		else
		{
			if ( mysql_num_rows( $result ) > 0 ) // URL's found
			{
				while ( $row = @mysql_fetch_array( $result ) ) // Print queue
				{
					$urls[ urlencode( $row["url"] ) ]["id"] = $row["id"];
					$urls[ urlencode( $row["url"] ) ]["template_id"] = $row["template_id"];
				}
			}
		}

		$current_ads = array();
		$q = "SELECT * FROM " . $db_table_prefix . "ads";
		$result = @mysql_query( $q, $db_seo );
		if ( mysql_errno() > 0 ) // Error when trying to open tables
		{
			echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
			echo "\n<br />[SEO-11] Unable to save url-data\n";
		}
		else
		{
			if ( mysql_num_rows( $result ) > 0 ) // URL's found
			{
				while ( $row = @mysql_fetch_array( $result ) ) // Print queue
				{
					$current_ads[ $row["data_id"] ][ $row["ad_id"] ] = $row["prio"];
				}
			}
		}

		/* Loop through all url's and check if they already exist */
		if ( count( $ads ) > 0 )
		{
			while ( list( $key, $value ) = each( $ads ) )
			{
				if ( !$urls[ $key ]["id"] ) // New URL, insert data
				{
					$q = "INSERT INTO " . $db_table_prefix . "data (ins_date, url, template_id) VALUES (NOW(), '" . urldecode( $key ) . "', '" . $ads[ $key ]["template"] . "')";
					mysql_query( $q );
					$url_id = mysql_insert_id();
					$urls[ $key ]["id"] = $url_id;
					$urls[ $key ]["template_id"] = $ads[ $key ]["template"];
				}
				elseif ( $urls[ $key ]["template_id"] != $ads[ $key ]["template"] ) // New template, update data
				{
					$q = "UPDATE " . $db_table_prefix . "data SET template_id = '" . $ads[ $key ]["template"] . "' WHERE id = '" . $urls[ $key ]["id"] . "'";
					mysql_query( $q );
					$urls[ $key ]["template_id"] = $ads[ $key ]["template"];
				}

				/* Loop through all ads for this URL, save new ads and save changes */
				if ( count( $ads[ $key ]["ads"] ) > 0 )
				{
					while ( list( $key2, $value2 ) = each( $ads[ $key ]["ads"] ) )
					{
						if ( !$current_ads[ $urls[ $key ]["id"] ][ $key2 ] ) // New ad, insert
						{
							if ($ads[ $key ]["ads"][ $key2 ]["prio"] == "delete") {
								$q = "DELETE FROM " . $db_table_prefix . "ads WHERE data_id = '" . $urls[ $key ]["id"] . "' AND ad_id = '" . $key2 . "'";
									} else {
							$q = "INSERT INTO " . $db_table_prefix . "ads (ins_date, data_id, prio, ad_id, url, main_url, anchor_text, description, title) VALUES (NOW(), '" . $urls[ $key ]["id"] . "', '" . $ads[ $key ]["ads"][ $key2 ]["prio"] ."', '" . $key2 . "', '" . addslashes( $ads[ $key ]["ads"][ $key2 ]["url"] ) ."', '" . addslashes( $ads[ $key ]["ads"][ $key2 ]["main_url"] ) ."', '" . addslashes( $ads[ $key ]["ads"][ $key2 ]["anchor_text"] ) ."', '" . addslashes( $ads[ $key ]["ads"][ $key2 ]["description"] ) ."', '" . $ads[ $key ]["ads"][ $key2 ]["title"] ."')";
								}
echo "<p><b>SQL Query: " . $q . "</p>\n";
							mysql_query( $q );
							$current_ads[ $urls[ $key ]["id"] ][ $key2 ] = $ads[ $key ]["ads"][ $key2 ]["prio"];
						}
						elseif ( $current_ads[ $urls[ $key ]["id"] ][ $key2 ] ) // Update ad
						{
							if ($ads[ $key ]["ads"][ $key2 ]["prio"] == "delete") {
							$q = "DELETE FROM " . $db_table_prefix . "ads WHERE data_id = '" . $urls[ $key ]["id"] . "' AND ad_id = '" . $key2 . "'";
							} else {
							$q = "UPDATE " . $db_table_prefix . "ads SET ins_date = NOW(), prio = '" . $ads[ $key ]["ads"][ $key2 ]["prio"] ."', url = '" . addslashes( $ads[ $key ]["ads"][ $key2 ]["url"] ) ."', main_url = '" . addslashes( $ads[ $key ]["ads"][ $key2 ]["main_url"] ) ."', anchor_text = '" . addslashes( $ads[ $key ]["ads"][ $key2 ]["anchor_text"] ) ."', description = '" . addslashes( $ads[ $key ]["ads"][ $key2 ]["description"] ) ."', title = '" . addslashes( $ads[ $key ]["ads"][ $key2 ]["title"] ) ."' WHERE data_id = '" . $urls[ $key ]["id"] . "' AND ad_id = '" . $key2 . "'"; }
echo "<p><b>SQL Query: " . $q . "</p>\n";
							mysql_query( $q );
						}

						
					}
				}
			}
		}
	}
}
elseif ( $_GET["action"] == "clear" )
{
	if ( $data_stored == "text" ) 
	{
		unlink($relative_path . "hreflink.data.db"); 
		unlink($relative_path . "hreflink.template.db");
		echo "Data stored in text, files deleted.";
	}
	elseif ( $data_stored == "mysql" )
	{
		echo "Data stored in MySQL, truncating tables...";
		$db_seo = @mysql_connect( $db_host, $db_username, $db_password );
				if ( mysql_errno() > 0 ) 
		{
			echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
			echo "\n<br />[SEO-09] Problems accessing the database, or invalid login information?\n";
		}
		@mysql_select_db( $db_name );
		if ( mysql_errno() > 0 ) 
		{
			echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
			echo "\n<br />[SEO-10] Wrong database name?\n";
		}
		$q = "TRUNCATE TABLE " . $db_table_prefix . "data";
		mysql_query( $q );
		echo $q . "\n";
		$q = "TRUNCATE TABLE " . $db_table_prefix . "ads";
		mysql_query( $q );
		echo $q . "\n";
		$q = "TRUNCATE TABLE " . $db_table_prefix . "template";
		mysql_query( $q );
		echo $q . "\n";
		
	}
}
elseif ( $_GET["action"] == "template" )
{
	/* Get updated templates */
	$url = "http://crm.seowebb.se/ADSEO/updater/print_template_update.php?site_id=" . $site_id . "&site_code=" . $site_code;
	$content = fetchURL( $url );

	/* Read data into array */
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

	/* Match and update data */
	if ( $data_stored == "text" )
	{
		unlink( $relative_path . "hreflink.template.db" );
		$content2 = @file_get_contents( $relative_path . "hreflink.template.db" ); // Get template from text-file.
		if ( strlen( $content2 ) > 0 )
		{
			$rows = explode( "\n", $content2 );

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
								$template2[ $ref1 ][ $key3 ] = $value3;
							}
						}
					}
				}
			}
		}

		/* Loop through all templates and check if they already exist */
		if ( count( $template ) > 0 )
		{
			while ( list( $key, $value ) = each( $template ) )
			{
				$template2[ $key ] = $template[ $key ]; // Update old data and save new data

				if ( count ( $template2 ) > 0 ) // Loop through all saved templates on server
				{
					reset( $template2 );
					while ( list( $key3, $value3 ) = each( $template2 ) )
					{
						if ( !$template[ $key3 ] ) // Template deleted
						{
							unset( $template2[ $key3 ] );
						}
					}
				}
			}
		}

		/* Loop through array and save data to file */
		@reset( $template2 );
		unset( $content );
		if ( count( $template2 ) > 0 )
		{
			while ( list( $key, $value ) = each( $template2 ) )
			{
				$content .= $key . "]|[header]=[" . $template2[ $key ]["header"] . "]|[link_body]=[" . $template2[ $key ]["link_body"] . "]|[footer]=[" . $template2[ $key ]["footer"] . "]|[anchor_text_link]=[" . $template2[ $key ]["anchor_text_link"] . "]|[read_more]=[" . $template2[ $key ]["read_more"] . "\n";
			}
		}
		if ( $fp = fopen( $relative_path . "hreflink.template.db", "w" ) )
		{
			fwrite( $fp, $content );

			fclose( $fp );
		}
	}
	elseif ( $data_stored == "mysql" )
	{
		/* Connect to MySQL database */
		$db_seo = @mysql_connect( $db_host, $db_username, $db_password );
		if ( mysql_errno() > 0 ) 
		{
			echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
			echo "\n<br />[SEO-09] Problems accessing the database, or invalid login information?\n";
		}
		@mysql_select_db( $db_name );
		if ( mysql_errno() > 0 ) 
		{
			echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
			echo "\n<br />[SEO-10] Wrong database name?\n";
		}
		
		if (!fieldexists($db_table_prefix . "template", 'read_more')) { 
			 $q = "alter TABLE " . $db_table_prefix . "template" . " ADD read_more TEXT NOT NULL"; 
			 mysql_query($q, $db_seo); 
		}
		$template2 = array();
		$q = "TRUNCATE TABLE " . $db_table_prefix . "template";
		mysql_query($q);
		$q = "SELECT * FROM " . $db_table_prefix . "template";
		$result = @mysql_query( $q, $db_seo );
		if ( mysql_errno() > 0 ) // Error when trying to open tables
		{
			echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
			echo "\n<br />[SEO-11] Unable to save url-data\n";
		}
		else
		{
			if ( mysql_num_rows( $result ) > 0 ) // URL's found
			{
				while ( $row = @mysql_fetch_array( $result ) ) // Print queue
				{
					$template2[ $row["template_id"] ]["header"] = $row["header"];
					$template2[ $row["template_id"] ]["link_body"] = $row["link_body"];
					$template2[ $row["template_id"] ]["footer"] = $row["footer"];
					$template2[ $row["template_id"] ]["anchor_text_link"] = $row["anchor_text_link"];
					$template2[ $row["template_id"] ]["read_more"] = $row["read_more"];
				}
			}
		}

		/* Loop through all templates and check if they already exist */
		if ( count( $template ) > 0 )
		{
			while ( list( $key, $value ) = each( $template ) )
			{
				if ( !$template2[ $key ] ) // New URL, insert data
				{
					$q = "INSERT INTO " . $db_table_prefix . "template (ins_date, template_id, header, link_body, footer, anchor_text_link, read_more) VALUES (NOW(), '" . $key . "', '" . $template[ $key ]["header"] . "', '" . $template[ $key ]["link_body"] . "', '" . $template[ $key ]["footer"] . "', '" . $template[ $key ]["anchor_text_link"] . "', '" . $template[ $key ]["read_more"] . "')";
echo "<p><b>SQL Query: " . $q . "</p>\n";
					mysql_query( $q );
					$template2[ $key ] = $template[ $key ];
				}
				elseif ( $urls[ $key ]["template_id"] != $ads[ $key ]["template"] ) // New template, update data
				{
					$q = "UPDATE " . $db_table_prefix . "template SET header = '" . $template[ $key ]["header"] . "', link_body = '" . $template[ $key ]["link_body"] . "', footer = '" . $template[ $key ]["footer"] . "', anchor_text_link = '" . $template[ $key ]["anchor_text_link"] . "', read_more = '" . $template[ $key ]["read_more"] . "' WHERE template_id = '" . $key . "'";
echo "<p><b>SQL Query: " . $q . "</p>\n";
					mysql_query( $q );
					$template2[ $key ] = $template[ $key ];
				}

				if ( count ( $template2 ) > 0 ) // Loop through all saved templates on server
				{
					reset( $template2 );
					while ( list( $key3, $value3 ) = each( $template2 ) )
					{
						if ( !$template[ $key3 ] ) // Template deleted
						{
							$q = "DELETE FROM " . $db_table_prefix . "template WHERE template_id = '" . $key3 . "'";
echo "<p><b>SQL Query: " . $q . "</p>\n";
							mysql_query( $q );
						}
					}
				}
			}
		}
	}
}

function text_queue( $file )
{
	$content = file_get_contents( $file ); // Get data from text-file.
	if ( strlen( $content ) > 0 )
	{
		unlink( $file ); // Empty current queue

		return $content;
	}
}

function mysql_queue()
{
	global $db_seo, $db_table_prefix;

	unset( $content );

	/* Update queue and identify all URLs as being fetched */
	$q = "UPDATE " . $db_table_prefix . "queue SET found = 'YES'";
	$result = @mysql_query( $q, $db_seo );
	if ( mysql_errno() > 0 ) // Error when trying to open tables
	{
		echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
		echo "\n<br />[SEO-07] Unable to update queue\n";
	}

	/* Get all updated queue-data */
	$q = "SELECT * FROM " . $db_table_prefix . "queue WHERE found = 'YES'";
	$result = @mysql_query( $q, $db_seo );
	if ( mysql_errno() > 0 ) // Error when trying to open tables
	{
		echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
		echo "\n<br />[SEO-08] Unable to get queue-data\n";
	}
	else
	{
		if ( mysql_num_rows( $result ) > 0 ) // Queue not empty
		{
			while ( $row = @mysql_fetch_array( $result ) ) // Print queue
			{
				$content .= $row["url"] . "]|[" . $row["config_url"] . "\n";
			}
		}

		/* Delete fetched data */
		$q = "DELETE FROM " . $db_table_prefix . "queue WHERE found = 'YES'";
		$result = @mysql_query( $q, $db_seo );
		if ( mysql_errno() > 0 ) // Error when trying to open tables
		{
			echo "MySQL Error (" . mysql_errno() . "): " . mysql_error();
			echo "\n<br />[SEO-08] Unable to delete queue\n";
		}

		return $content;
	}
}

function fetchURL( $url )
{
	$url_parsed = parse_url($url);
	$host = $url_parsed["host"];
	$port = (@$url_parsed["port"] > 0) ? @$url_parsed["port"]:"80";
	$path = $url_parsed["path"];

	//if url is http://example.com without final "/"
	if (empty($path)) $path="/";
	if (empty($host)) return;

	if ($url_parsed["query"] != "") $path .= "?".$url_parsed["query"];
	$out = "GET ".$path." HTTP/1.0\r\nHost: ".$host."\r\n\r\n";
	if ($fp = fsockopen($host, $port, $errno, $errstr, 30)) {
		fwrite($fp, $out);
		while (!feof($fp)) {
			@$s .= fgets($fp, 999);
		}
		fclose($fp);
	}

	$content = explode( "\n", $s );
	unset( $header );
	unset( $body );
	$body_tag = 0;
	while ( list( $key, $value ) = each( $content ) )
	{
		if ( !@$body && $value != "\r" )
		{
			@$header.= $value;
		}
		else
		{
			@$body.= $value . "\n";
		}
	}

	return trim( $body );
}
function getSelectArray( $query ) 
{ 
 $res = mysql_query( $query ); 
 $resnum = mysql_num_rows( $res ); 
 for ( $i = 0; $i < $resnum; $i++ ) 
 { 
 $t[$i] = mysql_fetch_assoc( $res ); 
 } 
 return $t; 
} // end function getSelectArray( )

function fieldexists($table, $field) 
{ 
 $ret = FALSE; 
 $q = "DESC ".$table; 
 $fields = getSelectArray($q); 
 foreach($fields as $val) 
 { 
 if($val['field'] == $field) 
 $ret = TRUE; 
 } 
 return $ret; 
} // end function fieldexists()
?>