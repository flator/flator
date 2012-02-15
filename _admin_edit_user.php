<?php
$metaTitle = "Flator.se > Redigera anv�ndare";

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/admin_edit_user.html";
	include( "login.php" );
}
else
{
	if ( strlen( $_POST["username"] ) > 0 && eregi( "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST["email"] ) && (int)$_POST["rights"] > 0 && (int)$_GET["userId"] > 0 )
	{
		if ( strlen( $_POST["password"] ) > 0 )
		{
			$tmpPass = sha1( $_POST["password"] );
			$record["password"] = $tmpPass;
		}
	
		$record["username"] = $_POST["username"]; 
		$record["rights"] = $_POST["rights"];
		$record["email"] = $_POST["email"];
		$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . (int)$_GET["userId"] ); 

		$bodyOnload = "onLoad=\"window.opener.location.reload(true);window.close();\"";
	}
	elseif ( $_POST )
	{
		$message = "Du m�ste ange anv�ndarnamn, e-postadress och niv�.";
	}
	else
	{
		$q = "SELECT * FROM fl_users WHERE id = " . (int)$_GET["userId"];
		$row = $DB->GetRow( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			$_POST["username"] = $row["username"];
			$_POST["email"] = $row["email"];
			$_POST["rights"] = $row["rights"];
		}
	}

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Redigera anv�ndare</h2>
";

if ( strlen( $message ) > 0 ) $body.= "<div id=\"error\">" . $message . "</div>\n";

	$body.= "
<form method=\"post\" style=\"padding: 0px; margin: 0px\">

<p><label for=\"username\">Anv�ndarnamn:</label> <input type=\"text\" id=\"username\" name=\"username\" value=\"" . stripslashes( $_POST["username"] ) . "\" /></p>
<p><label for=\"password\">L�senord:</label> <input type=\"text\" id=\"password\" name=\"password\" value=\"" . stripslashes( $_POST["password"] ) . "\" /> L�mna tomt f�r att inte �ndra</p>
<p><label for=\"email\">E-post:</label> <input type=\"text\" id=\"email\" name=\"email\" value=\"" . stripslashes( $_POST["email"] ) . "\" /></p>
<p><label for=\"rights\">Niv�:</label> <select id=\"rights\" name=\"rights\" />
";

if ( $_POST["rights"] == "0" ) { $body.= "<option value=\"0\" selected>Ingen �tkomst</option>"; } else { $body.= "<option value=\"0\">Ingen �tkomst</option>"; }
if ( $_POST["rights"] == "1" ) { $body.= "<option value=\"1\" selected>Nyhetsbrev</option>"; } else { $body.= "<option value=\"1\">Nyhetsbrev</option>"; }
if ( $_POST["rights"] == "2" ) { $body.= "<option value=\"2\" selected>Obekr�ftad</option>"; } else { $body.= "<option value=\"2\">Obekr�ftad</option>"; }
if ( $_POST["rights"] == "3" ) { $body.= "<option value=\"3\" selected>Medlem</option>"; } else { $body.= "<option value=\"3\">Medlem</option>"; }
if ( $_POST["rights"] == "4" ) { $body.= "<option value=\"4\" selected>Moderator</option>"; } else { $body.= "<option value=\"4\">Moderator</option>"; }
if ( $_POST["rights"] == "5" ) { $body.= "<option value=\"5\" selected>Fr�ga flatan</option>"; } else { $body.= "<option value=\"5\">Fr�ga flatan</option>"; }
if ( $_POST["rights"] == "6" ) { $body.= "<option value=\"6\" selected>Administrat�r</option>"; } else { $body.= "<option value=\"6\">Administrat�r</option>"; }

	$body.= "	
</select></p>
<p class=\"submit\"><input type=\"submit\" value=\"Spara �ndringar\" /></p>

	</div>
</div>
	";

}

?>