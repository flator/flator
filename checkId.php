<?
include('adodb5/adodb.inc.php');
include('functions.php');

$DB = NewADOConnection('mysql');
if ( DEBUG_MODE == TRUE )
{
	$DB->debug = TRUE;
}
$DB->Connect("localhost", "flator", "bkmFTD96s", "flator");




define("END_OF_LINE_MARKER", "\r\n");
$q = "SELECT * FROM fl_users ORDER BY id DESC";
$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
if (count($searchResult > 1)) {
while ( list( $keyPC, $valuePC ) = each( $searchResult ) )
		{
			echo "Personnummer: ".$searchResult[ $keyPC ]["personalCodeNumber"]."<br>";
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
				
$sleepTime=rand(1,4);
sleep($sleepTime);
			}
		}
}
		





?>