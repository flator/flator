<?php

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/admin_events.html";
	include( "login.php" );
}
else
{
	if ( strlen( $_POST["name"] ) > 0 && strlen( $_POST["city"] ) > 0 )
	{
		if ( strlen( $_POST["startDate"] ) < 1 ) $_POST["startDate"] = "0000-00-00 00:00:00";
		if ( strlen( $_POST["endDate"] ) < 1 ) $_POST["endDate"] = "0000-00-00 00:00:00";

#	$DB->debug = TRUE;
		$record = array();
		$record["eventType"] = addslashes( $_POST["eventType"] );
		$record["name"] = addslashes( $_POST["name"] );
		$record["location"] = addslashes( $_POST["location"] );
		$record["postalAddress"] = addslashes( $_POST["postalAddress"] );
		$record["city"] = addslashes( $_POST["city"] );
		$record["startDate"] = addslashes( $_POST["startDate"] );
		$record["endDate"] = addslashes( $_POST["endDate"] );
		$record["textDate"] = addslashes( $_POST["textDate"] );
		$record["description"] = addslashes( $_POST["description"] );
		$record["requirements"] = addslashes( $_POST["requirements"] );
		$record["public"] = addslashes( $_POST["public"] );
		$record["deleted"] = addslashes( $_POST["deleted"] );

		if ( $_GET["eventId"] > 0 )
		{
			$DB->AutoExecute( "fl_events", $record, 'UPDATE', 'id = ' . (int)$_GET["eventId"] ); 
		}
		else
		{
			$record["insDate"] = date( "Y-m-d H:i:s");
			$DB->AutoExecute( "fl_events", $record, 'INSERT' ); 

			$_GET["eventId"] = $DB->Insert_ID();
		}

		if ( $_FILES["image"]["name"] )
		{
			$dir = "/var/www/rwdx/user";

			$validImageTypes = array( "image/jpg" => "jpg",
									  "image/gif" => "gif",
									  "image/png" => "png" );

			$imageInfo = getimagesize( $_FILES['image']['tmp_name'] );

#			if ( $validImageTypes[ $imageInfo["mime"] ] )
#			{
				// Create unique image-name
				$unique = "event-" . time() . "-" . (int)$_GET["eventId"];
				$imageName = $unique.substr($_FILES["image"]["name"], -4, 4);

				move_uploaded_file($_FILES['image']['tmp_name'], $dir . "/tmp" . $imageName);
				createthumb( $dir . "/tmp" . $imageName, $dir . "/" . $imageName, 160, 300 );
				unlink( $dir . "/tmp" . $imageName );
				$imageInfo = getimagesize( $dir . "/" . $imageName );

				$record = array();
				$record["imageUrl"] = $baseUrl . "/rwdx/user/" . $imageName;
				$record["serverLocation"] = $dir . "/" . $imageName;
				$DB->AutoExecute( "fl_events", $record, 'UPDATE', 'id = ' . $_GET["eventId"] );
#			}
#			else
#			{
#				$error.= "<li>Felaktigt <b>bildformat</b>. Endast bilder av typen: jpg, gif eller png kan användas.</li>\n";
#			}
		}

		$bodyOnload = "onLoad=\"window.opener.location.reload(true);window.close();\"";
	}
	elseif ( $_POST )
	{
		$message = "Du måste ange korrekt namn och stad/ort.";
	}
	else
	{
		$q = "SELECT * FROM fl_events WHERE id = " . (int)$_GET["eventId"];
		$row = $DB->GetRow( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			$_POST["eventType"] = $row["eventType"];
			$_POST["name"] = $row["name"];
			$_POST["location"] = $row["location"];
			$_POST["postalAddress"] = $row["postalAddress"];
			$_POST["city"] = $row["city"];
			$_POST["startDate"] = $row["startDate"];
			$_POST["endDate"] = $row["endDate"];
			$_POST["textDate"] = $row["textDate"];
			$_POST["description"] = $row["description"];
			$_POST["requirements"] = $row["requirements"];
			$_POST["public"] = $row["public"];
			$_POST["deleted"] = $row["deleted"];
		}
	}

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Lägg till/Redigera event</h2>
";

if ( strlen( $message ) > 0 ) $body.= "<div id=\"error\">" . $message . "</div>\n";

	$body.= "
<form method=\"post\"  enctype=\"multipart/form-data\" style=\"padding: 0px; margin: 0px\">

<p><label for=\"eventType\">Typ (Event/Klubb/Restaurang):</label> <select id=\"eventType\" name=\"eventType\">
	<option value=\"\">--</option>";
	$q = "SELECT * FROM fl_event_types ORDER BY eventType ASC";
	$row = $DB->GetAssoc( $q, FALSE, TRUE );
	if ( count( $row ) > 0 )
	{
		while ( list( $key, $value ) = each( $row ) )
		{
			unset( $selected );
			if ( $_POST["eventType"] == $row[ $key ]["eventType"] ) $selected = " selected";
			$body.= "	<option value=\"" . $row[ $key ]["eventType"] . "\"" . $selected . ">" . $row[ $key ]["eventType"] . "</option>\n";
		}
	}

	$body.= "</select></p>
<p><label for=\"name\">Namn:</label> <input type=\"text\" id=\"name\" name=\"name\" value=\"" . stripslashes( $_POST["name"] ) . "\" /></p>
<p><label for=\"location\">Plats:</label> <input type=\"text\" id=\"location\" name=\"location\" value=\"" . stripslashes( $_POST["location"] ) . "\" /></p>
<p><label for=\"postalAddress\">Postadress:</label> <input type=\"text\" id=\"postalAddress\" name=\"postalAddress\" value=\"" . stripslashes( $_POST["postalAddress"] ) . "\" /></p>
<p><label for=\"city\">Stad/Ort:</label> <select id=\"city\" name=\"city\">
	<option value=\"\">--</option>";
	$q = "SELECT * FROM fl_cities ORDER BY city ASC";
	$row = $DB->GetAssoc( $q, FALSE, TRUE );
	if ( count( $row ) > 0 )
	{
		while ( list( $key, $value ) = each( $row ) )
		{
			unset( $selected );
			if ( $_POST["city"] == $row[ $key ]["city"] ) $selected = " selected";
			$body.= "	<option value=\"" . $row[ $key ]["city"] . "\"" . $selected . ">" . $row[ $key ]["city"] . "</option>\n";
		}
	}

	$body.= "</select></p>
<p>Om eventtypen är Klubb eller Restuarang behöver du ej ange start eller slutdatum. Deta är ju förmodligen istället något som ständigt finns, ange istället Fritext datum och skriv t ex \"Lördagar mellan 19 - 02.00\". Om \"Fritext datum\" är angiven visas det istället för Startar och Slutar.</p>
<p><label for=\"startDate\">Startar:</label> <input type=\"text\" id=\"startDate\" name=\"startDate\" value=\"" . stripslashes( $_POST["startDate"] ) . "\" /><button id=\"triggerStart\">...</button></p>
<p><label for=\"endDate\">Slutar:</label> <input type=\"text\" id=\"endDate\" name=\"endDate\" value=\"" . stripslashes( $_POST["endDate"] ) . "\" /><button id=\"triggerEnd\">...</button></p>
<p><label for=\"textDate\">Fritext datum:</label> <input type=\"text\" id=\"textDate\" name=\"textDate\" value=\"" . stripslashes( $_POST["textDate"] ) . "\" /></p>
<p><label for=\"image\">Bild:</label> <input id=\"image\" type=\"file\" name=\"image\" /></p>
<p><label for=\"description\">Beskrivning:</label> <textarea id=\"description\" name=\"description\" style=\"display: inline\">" . stripslashes( $_POST["description"] ) . "</textarea></p>
<p><label for=\"requirements\">Entré/krav:</label> <input type=\"text\" id=\"requirements\" name=\"requirements\" value=\"" . stripslashes( $_POST["requirements"] ) . "\" /></p>
<p><label for=\"public\">Publik:</label>
<select size=\"2\" id=\"public\" name=\"public\">";

	unset( $selected );
	$selected = ( $_POST["public"] == "YES" || (int)$_GET["eventId"] < 1 ) ? " selected":"";
	$body.= "	<option value=\"YES\"" . $selected . ">Ja</option>";
	$selected = ( $_POST["public"] == "NO" && (int)$_GET["eventId"] > 0 ) ? " selected":"";
	$body.= "	<option value=\"NO\"" . $selected . ">Nej</option>";

	$body.= "</select></p>
<p><label for=\"deleted\">Borttagen:</label>
<select size=\"2\" id=\"deleted\" name=\"deleted\">";

	unset( $selected );
	$selected = ( $_POST["deleted"] == "YES" && (int)$_GET["eventId"] > 0 ) ? " selected":"";
	$body.= "	<option value=\"YES\"" . $selected . ">Ja</option>";
	$selected = ( $_POST["deleted"] == "NO" || (int)$_GET["eventId"] < 1 ) ? " selected":"";
	$body.= "	<option value=\"NO\"" . $selected . ">Nej</option>";

	$body.= "</select></p></p>

<p class=\"submit\"><input type=\"submit\" value=\"Spara ändringar\" /></p>
";
/*
    <script type=\"text/javascript\">//<![CDATA[
      Zapatec.Calendar.setup({
        firstDay          : 1,
        showOthers        : true,
        showsTime         : true,
        range             : [2008.07, 2012.12],
        electric          : false,
        inputField        : \"startDate\",
        button            : \"triggerStart\",
        ifFormat          : \"%Y-%m-%d %H:%I:%S\",
        daFormat          : \"%Y/%m/%d\",
        timeInterval          : 30
      });
    //]]>
//<![CDATA[
      Zapatec.Calendar.setup({
        firstDay          : 1,
        showOthers        : true,
        showsTime         : true,
        range             : [2008.07, 2012.12],
        electric          : false,
        inputField        : \"endDate\",
        button            : \"triggerEnd\",
        ifFormat          : \"%Y-%m-%d %H:%I:%S\",
        daFormat          : \"%Y/%m/%d\",
        timeInterval          : 30
      });
    //]]>
    </script>
*/
$body .= "

	</div>
</div>
	";

}

?>