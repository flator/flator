<?=$_GET["target"]?>[-END-]
<?php
include( "config.php" );

sleep(1);

if( strlen( $_GET["name"] ) > 0 && strlen( $_GET["suggestion"] ) > 0 )
{
	$q = "INSERT INTO fl_suggestions (insDate, name, suggestion, remoteAddr) VALUES (NOW(), '" . addslashes( $_GET["name"] ) . "', '" . addslashes( $_GET["suggestion"] ) . "', '" . addslashes( $_SERVER["REMOTE_ADDR"] ) . "')";
    if ( $DB->Execute($q) === FALSE ) { 
        echo "<div id=\"error\">Error inserting: " . $DB->ErrorMsg() . "</div>\n"; 
    }
	else
	{
		echo "<div id=\"thankyou\">Tack f&ouml;r f&ouml;rslaget! :-)</div>";
	}
}
else
{
	echo "<div id=\"error\">Du m&aring;ste ange b&aring;de namn och f&ouml;rslag.</div>\n";
}

?>