<?php
if ( $templateType == "invite" )
{
	if ( (int)$_GET["templateId"] > 0 )
	{
		$metaTitle = "Flator.se > Redigera mall";
		$title = "Redigera mall";
	}
	else
	{
		$metaTitle = "Flator.se > Inbjudningsmall";
		$title = "Inbjudningsmall";
	}
	$loginUrl = $baseUrl . "/admin_invite_template.html";
}
elseif ( $templateType == "newsletter" )
{
	if ( (int)$_GET["templateId"] > 0 )
	{
		$metaTitle = "Flator.se > Redigera mall";
		$title = "Redigera mall";
	}
	else
	{
		$metaTitle = "Flator.se > Nyhetsbrev";
		$title = "Nyhetsbrev";
	}
	$loginUrl = $baseUrl . "/admin_newsletter_template.html";
}
else
{
	$metaTitle = "Flator.se > Mallar";
	$loginUrl = $baseUrl . "/admin_template.html";
	if ( $_GET["type"] == "confirmEmail" )
	{
		$title = "Mall för att bekräfta e-postadress";
		$templateType = "email";
	}
	elseif ( $_GET["type"] == "welcomeEmail" )
	{
		$title = "Mall för välkomstmail";
		$templateType = "email";
	}
	elseif ( $_GET["type"] == "resetPassword" )
	{
		$title = "Mall för att återställa lösenord";
		$templateType = "email";
	}
	elseif ( $_GET["type"] == "newPassword" )
	{
		$title = "Mall för mail med bekräftelse av nytt lösenord";
		$templateType = "email";
	}
	else
	{
		$title = "Mallar";
		$templateType = "email";
	}
}

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$noLogo = TRUE;
	$adminMenu = FALSE;
	include( "login.php" );
}
else
{
	if ( strlen( $_POST["message"] ) > 0 )
	{
		if ( strlen( $_POST["templateName"] ) < 1 )
		{
			$_POST["templateName"] = date( "Y-m-d H:i:s" );
		}

		if ( eregi("src=\"utv/", $_POST["message"] ) )
		{
			$_POST["message"] = eregi_replace("src=\"utv/", "src=\"http://www.flator.se/utv/", $_POST["message"] );
		}
		if ( eregi("a href=\"", $_POST["message"] ) && !eregi("a href=\"http", $_POST["message"] ) )
		{
			$_POST["message"] = eregi_replace("a href=\"", "ahref=\"http://www.flator.se/", $_POST["message"] );
		}

		if ( (int)$_GET["templateId"] > 0 && $_POST["submit"] != "Spara som ny mall" )
		{
			$record["insDate"] = date("Y-m-d H:i:s");
			$record["userId"] = $_SESSION["userId"];
			$record["subject"] = $_POST["subject"];
			$record["name"] = $_POST["templateName"];
			$record["content"] = $_POST["message"];
			$record["templateType"] = $templateType;
			$DB->AutoExecute( "fl_templates", $record, 'UPDATE', 'id = ' . (int)$_GET["templateId"] ); 

			$bodyOnload = "onLoad=\"window.close();\"";
		}
		else
		{
			$record["insDate"] = date("Y-m-d H:i:s");
			$record["userId"] = $_SESSION["userId"];
			$record["subject"] = $_POST["subject"];
			$record["name"] = $_POST["templateName"];
			$record["content"] = $_POST["message"];
			$record["templateType"] = $templateType;
			$record["active"] = "YES";
			$DB->AutoExecute( "fl_templates", $record, 'INSERT' ); 
			$templateId = $DB->Insert_ID();

			if ( $templateType == "invite" )
			{
				$bodyOnload = "onLoad=\"window.opener.location.href='" . $baseUrl . "/admin_" . $templateType . ".html?templateId=" . $templateId . "';window.close();\"";
			}
			elseif ( $templateType == "newsletter" )
			{
				$bodyOnload = "onLoad=\"window.opener.location.href='" . $baseUrl . "/admin_" . $templateType . ".html?templateId=" . $templateId . "';window.close();\"";
			}
			else
			{
				$bodyOnload = "onLoad=\"window.opener.location.href='" . $baseUrl . "/admin_templates.html?type=" . $_GET["type"] . "&templateId=" . $templateId . "';window.close();\"";
			}
		}
	}

	if ( (int)$_GET["templateId"] > 0 )
	{
		$q = "SELECT * FROM fl_templates WHERE id = " . (int)$_GET["templateId"];
		$row = $DB->GetRow( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			$_POST["message"] = $row["content"];
			$_POST["templateName"] = $row["name"];
			$_POST["subject"] = $row["subject"];
		}
	}

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>" . $title . "</h2>
	";

	$body.= "

<form method=\"post\" style=\"padding: 0px; margin: 0px\">

<p><label for=\"subject\">&Auml;mnesrad:</label> <input type=\"text\" id=\"subject\" name=\"subject\" value=\"" . stripslashes( $_POST["subject"] ) . "\" /></p>

<textarea name=\"message\" style=\"clear: both\">" . $_POST["message"] . "</textarea>";

	if ( $templateType == "invite" )
	{
		$body.= "<div id=\"boxNote\">Viktigt att koden: <b>{invitationCode}</b> finns med i mallen. Vid utskick ersätts det med personens unika kod.</div>";
	}
	elseif ( $templateType == "email" )
	{
		$body.= "<div id=\"boxNote\">Placera följande koder i mallen för att ersätta de med användarnamn osv.<br />Användarnamn: <b>{username}</b>.";
		if ( $_GET["type"] == "welcomeEmail" )
		{
			$body.= "<br />Lösenord: <b>{password}</b>";
		}
		elseif ( $_GET["type"] == "confirmEmail" )
		{
			$body.= "<br />Verifikationskod för e-post: <b>{verificationCode}</b>";
		}
		elseif ( $_GET["type"] == "resetPassword" )
		{
			$body.= "<br />Länk för att återställa lösenord : <b>{resetPwdURL}</b>";
		}
		elseif ( $_GET["type"] == "newPassword" )
		{
			$body.= "<br />Lösenord: <b>{password}</b>";
		}
		$body.= "</div>";
	}

	$body.= "<p><label for=\"templateName\">Mallnamn:</label> <input type=\"text\" id=\"templateName\" name=\"templateName\" value=\"" . stripslashes( $_POST["templateName"] ) . "\" /></p>

<p class=\"submit\"><input type=\"submit\" value=\"Spara mall\" /></p>
	";

	if ( (int)$_GET["templateId"] > 0 )
	{
		$body.= "<p class=\"submit\"><input type=\"submit\" name=\"submit\" value=\"Spara som ny mall\" /></p>";
	}

	$body.= "
</form>

</div>

	</div>
	";

}
?>