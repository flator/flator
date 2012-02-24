<?php
include('adodb5/adodb.inc.php');
include( "static.php" );
echo "start";
$DB = NewADOConnection('mysql');
if ( DEBUG_MODE == TRUE )
{
	#$DB->debug = TRUE;
}
$DB->Connect(LOCALHOST, ROOT, PASS, TABELS);  //static database
//$q = "SELECT * FROM fl_users ORDER BY username ASC";
$q = "SELECT * FROM fl_users ORDER BY username >0";

$searchResult = $DB->GetAssoc( $q, FALSE, TRUE );

while ( list( $key, $value ) = each( $searchResult ) )  //
		{
		ECHO "while";
		//var_dump($key);
			//$age = 0;
			//echo $key[1];          //

				$searchResult[ $key ]["personalCodeNumber"] = str_replace( "-", "", $searchResult[ $key ]["personalCodeNumber"] );
				$searchResult[ $key ]["personalCodeNumber"] = str_replace( "+", "", $searchResult[ $key ]["personalCodeNumber"] );
				
					$birthDay = (int)substr( $searchResult[ $key ]["personalCodeNumber"], 6, 2 );
					$birthMonth = strtolower( (int)substr( $searchResult[ $key ]["personalCodeNumber"], 4, 2 )  );
					$birthYear = substr( $searchResult[ $key ]["personalCodeNumber"], 0, 4 );
				
				   $YearDiff = date("Y") - $BirthYear;
                   $MonthDiff = date("m");
                   $DayDiff = date("d");
				   
		        //if($MonthDiff==$BirthMonth && $DayDiff==$BirthDay ){
		        mysql_query("UPDATE fl_users SET currAge =50 WHERE id =6");
                 
		}
?>