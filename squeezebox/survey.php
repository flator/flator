<?php
include('../adodb5/adodb.inc.php');
include('../functions.php');
$DB = NewADOConnection('mysql');

$DB->Connect("localhost", "flator", "bkmFTD96s", "flator");

?>


<?

		$q = "SELECT * FROM fl_polls WHERE active = 'YES' ORDER BY insDate DESC LIMIT 1";
	$currPoll = $DB->GetRow( $q, FALSE, TRUE );
	if ((int)$currPoll["id"] > 0) {
		$q = "SELECT * FROM fl_polls_options WHERE pollId = '".(int)$currPoll["id"]."' ORDER BY ID ASC";
		$currPollOptions = $DB->GetAssoc( $q, FALSE, TRUE );
		if (count($currPollOptions) > 0) {?>
<div style="background:transparent url(http://www.flator.se/img/logo_flator2.gif) no-repeat scroll 0 0; background-position: right bottom;">
<h2>Omr&ouml;stning</h2>
<p><?=htmlentities($currPoll["description"])?></p>
<h4><?=htmlentities($currPoll["question"])?></h4><form method="POST" action="http://www.flator.se/" name="surveyForm">
<input name="type" value="survey" type="hidden">
<input name="pollId" value="<?=(int)$currPoll["id"]?>" type="hidden">
<?
	$i = 0;
	while ( list( $key, $value ) = each( $currPollOptions ) )
		{
			
	?>		

<div style="border: 0px none; margin-top:<?($i == 0 ? "10" : "0")?>px;">
<input name="optionId" value="<?=(int)$currPollOptions[ $key ]["id"]?>" selected="" type="radio">&nbsp;&nbsp;<?=htmlentities($currPollOptions[ $key ]["title"])?></div>
<?
	$i++;
	}
?>
<br><br>
<span onmouseover="document.surveySubmit.src='http://www.flator.se/img/symbols/gif_red/skicka.gif'" onmouseout="document.surveySubmit.src='http://www.flator.se/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onclick="document.surveyForm.submit();"><img src="http://www.flator.se/img/symbols/gif_purple/skicka.gif" name="surveySubmit" style="vertical-align: middle;" border="0">Skicka svar!</a></nobr></span>
</form>
</div>

<? 

}
	}
	?>