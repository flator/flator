<?
$invite_user=$_GET["invite_user"];
header('Cache-Control: no-cache');
header('Pragma: no-cache');
?>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>flator</title>
<script language="javascript"> AC_FL_RunContent = 0; </script>
<script language="javascript"> DetectFlashVer = 0; </script>
<script src="AC_RunActiveContent.js" language="javascript"></script>
<script language="JavaScript" type="text/javascript">
<!--
// -----------------------------------------------------------------------------
// Globals
// Major version of Flash required
var requiredMajorVersion = 9;
// Minor version of Flash required
var requiredMinorVersion = 0;
// Revision of Flash required
var requiredRevision = 0;
// -----------------------------------------------------------------------------
// -->
</script>
</head>
<body bgcolor="#ffffff">
<!--url's used in the movie-->
<!--text used in the movie-->
<!--
<p align="center"><font face="Lucida Sans" size="12" color="#999999" letterSpacing="0.000000" kerning="1">If you are not logged in you can fill your login details here</font></p>
<p align="center"></p>
-->
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) {  // if we've detected an acceptable version
		// embed the flash movie
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
			'width', '100%',
			'height', '100%',
			'src', 'flator?invite_user=<?=$invite_user?>',
			'quality', 'autohigh',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'noscale',
			'wmode', 'window',
			'devicefont', 'false',
			'id', 'flator',
			'bgcolor', '#ffffff',
			'name', 'flator',
			'menu', 'true',
			'allowScriptAccess','sameDomain',
			'allowFullScreen','false',
			'movie', 'flator?invite_user=<?=$invite_user?>',
			'salign', 'lt'
			); //end AC code
	} else {  // flash is too old or we can't detect the plugin
		var alternateContent = 'Alternate HTML content should be placed here.'
			+ 'This content requires the Adobe Flash Player.'
			+ '<a href=http://www.macromedia.com/go/getflash/>Get Flash</a>';
		document.write(alternateContent);  // insert non-flash content
	}
}
// -->
</script>
<noscript>
	// Provide alternate content for browsers that do not support scripting
	// or for those that have scripting disabled.
  	Alternate HTML content should be placed here. This content requires the Adobe Flash Player.
  	<a href="http://www.macromedia.com/go/getflash/">Get Flash</a>
</noscript>
</body>
</html>
