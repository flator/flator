<?php
/*
include('adodb5/adodb.inc.php');
include('functions.php');
$DB = NewADOConnection('mysql');
if ( DEBUG_MODE == TRUE )
{
	$DB->debug = TRUE;
}
$DB->Connect("localhost", "flator", "bkmFTD96s", "flator");




$q = "SELECT * FROM fl_users ORDER BY id ASC";
$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );
if (count($searchResult > 1)) {
while ( list( $keyPC, $valuePC ) = each( $searchResult ) )
		{
			if ($searchResult[ $keyPC ]["pride09"] == "garMed") {
				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["userId"] = $searchResult[ $keyPC ]["id"];
				$record["pollId"] = "1";
				$record["optionId"] = "1";
				$DB->AutoExecute( "fl_polls_answers", $record, 'INSERT');

			} elseif ($searchResult[ $keyPC ]["pride09"] == "nej") {
				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["userId"] = $searchResult[ $keyPC ]["id"];
				$record["pollId"] = "1";
				$record["optionId"] = "2";
				$DB->AutoExecute( "fl_polls_answers", $record, 'INSERT');

			} elseif ($searchResult[ $keyPC ]["pride09"] == "hopparRunt") {
				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["userId"] = $searchResult[ $keyPC ]["id"];
				$record["pollId"] = "1";
				$record["optionId"] = "3";
				$DB->AutoExecute( "fl_polls_answers", $record, 'INSERT');

			} elseif ($searchResult[ $keyPC ]["pride09"] == "besokerInte") {
				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["userId"] = $searchResult[ $keyPC ]["id"];
				$record["pollId"] = "1";
				$record["optionId"] = "4";
				$DB->AutoExecute( "fl_polls_answers", $record, 'INSERT');

			} elseif ($searchResult[ $keyPC ]["pride09"] == "ejSvarat") {
				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["userId"] = $searchResult[ $keyPC ]["id"];
				$record["pollId"] = "1";
				$record["optionId"] = "0";
				$DB->AutoExecute( "fl_polls_answers", $record, 'INSERT');

			} elseif ($searchResult[ $keyPC ]["pride09"] == "ejFragad") {

			} else { echo "Err..."; }


		}
}
*/
?>