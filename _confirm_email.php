<?php
$metaTitle = "Flator.se - Bekräfta e-postadress";

$q = "SELECT * FROM fl_users WHERE verificationCode = '" . addslashes( $_GET["verificationCode"] ) . "'";
$row = $DB->GetRow( $q, FALSE, TRUE );
if ( count( $row ) > 0 )
{
		if ($_GET["type"] == "change" && $row["newEmail"] != "") {
			$record = array();
			$record["email"] = addslashes($row["newEmail"]);
			//$record["newEmail"] = "";
			$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = '.(int)$row["id"] );
			$record = array();
			$record["newEmail"] = ""; 
			$record["verificationCode"] = ""; 
			if ($row["rights"] < 3) {
			$record["rights"] = 3;
			}
			$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = '.(int)$row["id"] );

		

		} else {

			if ($row["rights"] < 3) {
			$record = array();
			$record["rights"] = 3;
			$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = '.(int)$row["id"] );

			}
			$record = array();
			$record["verificationCode"] = ""; 
			$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = '.(int)$row["id"] );

		}


		$body = "<h2>V&auml;lkommen!</h2><div id=\"thankyou\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">Din e-post är nu bekräftad, <a href=\"http://www.flator.se/\">välkommen in till Flator.se</a>.</ul></div>";
} else {
		$body = "<h2>V&auml;lkommen!</h2><div id=\"thankyou\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">Begärda ändringar är nu utförda, <a href=\"http://www.flator.se/\">välkommen in till Flator.se</a>.</ul></div>";
}