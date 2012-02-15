<?php
$metaTitle = "Flator.se - Mina sidor - Bilder/Filmer - Ta bort fotoalbum";

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/media.html";
	include( "login_new.php" );
}
else
{
	if ( strlen( $_GET["albumIds"] ) > 0 && $_SESSION["demo"] != TRUE )
	{
		$_GET["albumIds"] = str_replace( "message,", "", $_GET["albumIds"] );
		$friendsArr = explode( ",", $_GET["albumIds"] );

		foreach ($friendsArr as $key => $value) {


		$q = "SELECT * FROM fl_images WHERE albumId = " . (int)$value . " AND imageType = 'albumPhoto' ORDER BY id ASC";
		$images = $DB->GetAssoc( $q, FALSE, TRUE );

		if ( count( $images ) > 0 )
			{
				while ( list( $key2, $value2 ) = each( $images ) )
				{
					
					unlink($images[ $key2 ]["serverLocation"]);
					$q = "DELETE FROM fl_images where ID = ".(int)$images[ $key2 ]["id"]." limit 1";
					$DB->_Execute( $q ); 

				}
			}
			$q = "DELETE FROM fl_albums where ID = ".(int)$value." limit 1";

			$DB->_Execute( $q ); 


		}

	}
	header( "Location: http://www.flator.se/media.html" );
}
?>