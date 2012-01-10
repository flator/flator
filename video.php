<?
if ($_POST) {
/***************Load FFMPEG *********************************/



$extension = "ffmpeg";

$extension_soname = $extension . "." . PHP_SHLIB_SUFFIX;

$extension_fullname = PHP_EXTENSION_DIR . "/" . $extension_soname;





// load extension

if (!extension_loaded($extension)) {

dl($extension_soname) or die("Can't load extension $extension_fullname\n");

}



/***********************************************************/



/*****************Get the path to Extention ****************/



$array_path = explode("/",$_SERVER['SCRIPT_FILENAME']);

$dynamic_path = "";

for ($i=0;$i<sizeof($array_path)-1;$i++)

if($array_path[$i]!="")

$dynamic_path =$dynamic_path."/".$array_path[$i];

/**********************************************************/



/******************set folders*****************************/

$flvpath = "flvfiles/";

$moviepath = "movies/" ;

#chmod($moviepath,0777);

#chmod($flvpath,0777);

/*********************************************************/


/******************Upload and convert video *****************************/



if(isset($_FILES["x_URL"]))

{

$fileName = $_FILES["x_URL"]["name"];

$fileNameParts = explode( ".", $fileName );

$fileExtension = end( $fileNameParts );

$fileExtension = strtolower( $fileExtension );

if($fileExtension=="avi" || $fileExtension=="wmv" || $fileExtension=="mpeg"
|| $fileExtension=="mpg" || $fileExtension=="mov" )

{

if ( move_uploaded_file($_FILES["x_URL"]["tmp_name"],$moviepath.$_FILES["x_URL"]["name"])) {



if( $fileExtension == "wmv" ) {


$output = runExternal( "ffmpeg -i ".$dynamic_path."/".$moviepath."".$fileName." -sameq -acodec libmp3lame -ar 22050 -ab 32 -f flv -s 320x240 ".$dynamic_path."/".$flvpath."".$fileNameParts[0].".flv", $code );
echo $output;
}

if( $fileExtension == "avi" || $fileExtension=="mpg" ||
$fileExtension=="mpeg" || $fileExtension=="mov" ) {
$execCommand = "ffmpeg -i ".$dynamic_path."/".$moviepath."".$fileName." -sameq -acodec libmp3lame -ar 22050 -ab 32 -f flv -s 320x240 ".$dynamic_path."/".$flvpath."".$fileNameParts[0].".flv";
echo $execCommand;
$output = runExternal( $execCommand, $code );
echo $output;


}

/******************create thumbnail***************/
$execCommand = "ffmpeg -y -i ".$dynamic_path."/".$moviepath."".$fileName." -vframes 1 -ss 00:00:03 -an -vcodec png -f rawvideo -s 110x90 ".$dynamic_path."/".$flvpath."".$fileNameParts[0].".png";
echo $execCommand;
$output = runExternal( $execCommand, $code );
echo $output;



}

else

{

die("The file was not uploaded");

}

}



else

{

die("Please upload file only with avi, wmv, mov or mpg extension!");

}

}

else

{

die("File not found");

}
}



function runExternal( $cmd, $code ) {

$descriptorspec = array(
0 => array("pipe", "r"), // stdin is a pipe that the child willread from
1 => array("pipe", "w"), // stdout is a pipe that the child willwrite to
2 => array("pipe", "w") // stderr is a file to write to
);

$pipes= array();
$process = proc_open($cmd, $descriptorspec, $pipes);

$output= "";

if (!is_resource($process)) return false;

#close child's input imidiately
fclose($pipes[0]);

stream_set_blocking($pipes[1],false);
stream_set_blocking($pipes[2],false);

$todo= array($pipes[1],$pipes[2]);

while( true ) {
$read= array();
if( !feof($pipes[1]) ) $read[]= $pipes[1];
if( !feof($pipes[2]) ) $read[]= $pipes[2];

if (!$read) break;

$ready= stream_select($read, $write=NULL, $ex= NULL, 2);

if ($ready === false) {
break; #should never happen - something died
}

foreach ($read as $r) {
$s= fread($r,1024);
$output.= $s;
}
}

fclose($pipes[1]);
fclose($pipes[2]);

$code= proc_close($process);

return $output;
}


?><form name="frm" action="video.php" method="post" enctype="multipart/form-data" >

<input name="x_URL" type="file" class="form1" size="26">

<input type="submit" name="submit" value="upload"
>

</form>