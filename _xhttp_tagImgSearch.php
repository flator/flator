<?=$_GET["target"]?>[-END-]
<?php
include( "config.php" );
?>
<font style="font-size:5px;line-height:5px;">&nbsp;<br></font>
<input type="text" class="txtSearch" name="SearchQuery"  value="B&ouml;rja skriv namn p&aring; medlem eller personens namn" onfocus="changeValueTemp(this);" onblur="changeValueTemp(this);" onkeyup="showResult_tag(this.value, <?=(int)$_GET["photoId"]?>, <?=(int)$_GET["alt"]?>)" onkeypress="return onEnter(event, 'tagImg.php?target=tagImg&photoId=<?=(int)$_GET["photoId"]?>&alt=<?=(int)$_GET["alt"]?>&setUserStr='+this.value);" style="width: 250px" AUTOCOMPLETE="OFF">

<div id="tagsearch" style="background-color:#fff;text-align:left; margin-top:5px;">&nbsp;</div>
<?
?>