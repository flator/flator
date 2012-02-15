<?php

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/admin_shouts.html";
	include( "login.php" );
}
else
{
	if ( strlen( $_POST["subject"] ) > 0 && strlen( $_POST["text"] ) > 0 )
	{
		

#	$DB->debug = TRUE;
		$record = array();
		
		$record["subject"] = addslashes( $_POST["subject"] );
		$record["subject2"] = addslashes( $_POST["subject2"] );
		$record["text"] = addslashes( $_POST["text"] );
		$record["link"] = addslashes( $_POST["link"] );
		$record["active"] = addslashes( $_POST["active"] );

		if ( $_GET["shoutId"] > 0 )
		{
			$DB->AutoExecute( "fl_shouts", $record, 'UPDATE', 'id = ' . (int)$_GET["shoutId"] ); 
		}
		else
		{
			$record["insDate"] = date( "Y-m-d H:i:s");
			$DB->AutoExecute( "fl_shouts", $record, 'INSERT' ); 
			
			 
			
			$_GET["shoutId"] = $DB->Insert_ID();

			$record = array();
			$record["seenLatestCrewMsg"] = 'NO';
			$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id > 0' );
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
				$unique = "event-" . time() . "-" . (int)$_GET["shoutId"];
				$imageName = $unique.substr($_FILES["image"]["name"], -4, 4);

				move_uploaded_file($_FILES['image']['tmp_name'], $dir . "/tmp" . $imageName);
				createthumb( $dir . "/tmp" . $imageName, $dir . "/" . $imageName, 160, 300 );
				unlink( $dir . "/tmp" . $imageName );
				$imageInfo = getimagesize( $dir . "/" . $imageName );

				$record = array();
				$record["imagePath"] = "/rwdx/user/" . $imageName;
				
				$DB->AutoExecute( "fl_shouts", $record, 'UPDATE', 'id = ' . $_GET["shoutId"] );
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
		$message = "Du måste ange en första rubrik samt text.";
	}
	else
	{
		$q = "SELECT * FROM fl_shouts WHERE id = " . (int)$_GET["shoutId"];
		$row = $DB->GetRow( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			$_POST["imagePath"] = $row["imagePath"];
			$_POST["subject"] = $row["subject"];
			$_POST["subject2"] = $row["subject2"];
			$_POST["text"] = $row["text"];
			$_POST["link"] = $row["link"];
			$_POST["active"] = $row["active"];
		}
	}

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Lägg till/Redigera nyhet</h2>
";

if ( strlen( $message ) > 0 ) $body.= "<div id=\"error\">" . $message . "</div>\n";

	$body.= "
<form method=\"post\"  enctype=\"multipart/form-data\" style=\"padding: 0px; margin: 0px\">


<p><label for=\"subject\">Rubrik 1:</label> <input type=\"text\" id=\"subject\" name=\"subject\" value=\"" . stripslashes( $_POST["subject"] ) . "\" /></p>
<p><label for=\"subject2\">Rubrik 2:</label> <input type=\"text\" id=\"subject2\" name=\"subject2\" value=\"" . stripslashes( $_POST["subject2"] ) . "\" /></p>
<p><label for=\"link\">URL för länk:</label> <input type=\"text\" id=\"link\" name=\"link\" value=\"" . stripslashes( $_POST["link"] ) . "\" /></p>
<p><label for=\"image2\">Nuvarande bild:</label> <img src=\"".$baseUrl.$_POST["imagePath"]."\" border=\"0\"></p>
<p><label for=\"image\">Bild:</label> <input id=\"image\" type=\"file\" name=\"image\" /></p>
<p><label for=\"text\">Text:</label> <textarea id=\"text\" name=\"text\" style=\"display: inline\">" . stripslashes( $_POST["text"] ) . "</textarea></p>
<p><label for=\"public\">Aktiv:</label>
<select size=\"2\" id=\"active\" name=\"active\">";

	unset( $selected );
	$selected = ( $_POST["active"] == "YES" || (int)$_GET["shoutId"] < 1 ) ? " selected":"";
	$body.= "	<option value=\"YES\"" . $selected . ">Ja</option>";
	$selected = ( $_POST["active"] == "NO" && (int)$_GET["shoutId"] > 0 ) ? " selected":"";
	$body.= "	<option value=\"NO\"" . $selected . ">Nej</option>";

	$body.= "</select></p></p>

<p class=\"submit\"><input type=\"submit\" value=\"Spara ändringar\" /></p>


	</div>
</div>
	";

}

?>