<?php
if ( $_SESSION["demo"] == TRUE ) {
$metaTitle .= " - Demonstrationskonto";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?=$metaTitle?></title>
	<meta name="description" content="<?=$metaDescription?>">
	<meta name="keywords" content="<?=$metaKeywords?>">
<meta http-equiv="Content-Type" content="text/html;charset=windows-1252" >
<meta name="google-site-verification" content="YmHHylhN4iyouxyIL6D1JNPpLR8aTHSm0hEHxahlFgI" />
<?php
if ( $newCss == TRUE )
{
?>
	<link href="<?=$baseUrl?>/styleWhyBuddha.css" rel="stylesheet" type="text/css">
<?php
}
else
{
?>
	<link href="<?=$baseUrl?>/style.css" rel="stylesheet" type="text/css">
<?php
}
?>
<script language="javascript" type="text/javascript">
function encode_utf8( s )
{
  return unescape( encodeURIComponent( s ) );
}

function decode_utf8( s )
{
  return decodeURIComponent( escape( s ) );
}
function showImage(layer_ref, imageUrl) {
		document.getElementById(layer_ref).style.display='';
		document.getElementById('mediumProfileImage').src=imageUrl;
}
function closeImage(layer_ref) {
		document.getElementById(layer_ref).style.display='none';
}

function showImage2(layer_ref, imageUrl, imgId) {
		document.getElementById(layer_ref).style.display='';
		document.getElementById(imgId).src=imageUrl;
}
function closeImage2(layer_ref) {
		document.getElementById(layer_ref).style.display='none';
}

function toggleComments(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "Visa alla kommentarer";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "Dölj kommentarer";
	}
} 
function toggleWriteComments(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = 'Kommentera <img src="<?=$baseUrl?>/img/symbols/gif_purple/lamna_kommentar.gif" name="kommentera_img" style="vertical-align:middle;" border="0">';
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = 'Dölj kommentarsruta <img src="<?=$baseUrl?>/img/symbols/gif_purple/lamna_kommentar.gif" name="kommentera_img" style="vertical-align:middle;" border="0">';
	}
}

</script>
<?php
if ( $false != TRUE )
{
?>
<script language="javascript" type="text/javascript">

function showPopup(layer_ref) {
		document.getElementById(layer_ref).style.display='';
}
function closePopup(layer_ref) {
		document.getElementById(layer_ref).style.display='none';
}
</script>
<?php
}
if ( $jsZapatec == TRUE && $alwaysFalse == TRUE )
{

?>
<!-- Loading Theme file(s) -->
    <link rel="stylesheet" href="http://www.zapatec.com/website/main/../ajax/zpcal/themes/maroon.css">

<!-- Loading Calendar JavaScript files -->
    <script type="text/javascript" src="http://www.zapatec.com/website/main/../ajax/zpcal/../utils/zapatec.js"></script>
    <script type="text/javascript" src="http://www.zapatec.com/website/main/../ajax/zpcal/src/calendar.js"></script>
<!-- Loading language definition file -->
    <script type="text/javascript" src="http://www.zapatec.com/website/main/../ajax/zpcal/lang/calendar-en.js"></script>

<?php
}
if ( $tinyMceFull == TRUE )
{
?>
<script language="javascript" type="text/javascript" src="<?=$baseUrl?>/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,pagebreak",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	relative_urls : false,
	// Example content CSS (should be your site CSS)
	content_css : "css/content.css",

	// Replace values for the template plugin
	template_replace_values : {
		username : "Some User",
		staffid : "991234"
	}
});

</script>
<?php
}
elseif ( $tinyMce == TRUE )
{
?>
<script language="javascript" type="text/javascript" src="<?=$baseUrl?>/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "simple",
	// Example content CSS (should be your site CSS)
	content_css : "css/content.css",

});

</script>
<?php
}
?>

<script type="text/javascript">
<?php
if ( $loadPopup == TRUE )
{
?>
var newwindow;
function openPopup(url, name, width, height)
{
	newwindow=window.open(url,name,'height='+height+',width='+width+',resizable=yes,scrollbars=yes');
	if (window.focus) {newwindow.focus()}
}
<?php
}

if ( $loadAjax == TRUE )
{
?>
function checkAjax(){
  var xmlHttp;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      try
        {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
      catch (e)
        {
        alert("Your browser does not support AJAX!");
        return false;
        }
      }
    }
	return xmlHttp;
}

function getContent(url)
{
xmlHttp = checkAjax()
	if (xmlHttp) {
		var tDate = new Date();
		reloadVar = tDate.getSeconds() + ""+ tDate.getMinutes();

	 	url="/_xhttp_"+url+"&reloadVar="+reloadVar

	 	xmlHttp.open("GET",url,true);
	 	xmlHttp.onreadystatechange=rsChange
	 	xmlHttp.send(null)
	}
}

function showLoad(target){
	var x = document.getElementById(target);
	x.innerHTML = '<div align="center"><img style="padding:10px;" src="<?=$baseUrl?>/img/load.gif"><\/div>';
}

function rsChange() {	

 if(xmlHttp.readyState==4)  {
	 var tmpArr = xmlHttp.responseText.split("[-END-]")
//	window.alert(tmpArr[0] +" "+ tmpArr[1]);
	 if(tmpArr[0])document.getElementById(tmpArr[0]).innerHTML = tmpArr[1]
 }
}

function onEnter(e, url, thisObj) {
	var key = (window.event) ? event.keyCode : e.which;
	if (window.event)
		key = event.keyCode
	else
		key = e.which
	if (key == 13) 
	{
		//getContent(url);
		thisObj.blur();
	}
	else
	{
		return !(window.event && key == 13);
	}
}

<?php
}
?>
<?php
if ( $loadSelect == TRUE )
{
?>

function getSelectValue(radioObj) {
	var selectedArray;
//  var selObj = document.getElementById(radioObj);

//return radioObj.options.length;
  var i;
  var count = 0;
  for (i=0; i<radioObj.options.length; i++) {
    if (radioObj.options[i].selected ) {
      selectedArray = selectedArray + ',' + radioObj.options[i].value;
    }
  }
  return selectedArray;
}

<?php
}

if ($jsForum == TRUE) {
?>
	function addurl(fld) {
var currVal = fld.value;
var url = prompt('Ange adress:','http:\/\/');
if (! url) { return; }
var txt = prompt('Ange namn på länken:','Länktext');
if (! txt || (txt == 'Länktext')) { txt = url; }
fld.value = currVal + '\n' + '[url=' + url + ']' + txt + '[/url]';
}
<?php
}
if ( $jsReload == TRUE )
{
?>
function refreshimage(docObj) {
	var iDate = new Date();
	reloadVar = iDate.getSeconds() + ""+ iDate.getMinutes();
	document.getElementById(docObj).src = document.getElementById(docObj).src + "#" + reloadVar;
}
<?php
}
if ( $jsCheckbox == TRUE ) {
?>
function checkboxValues(checkbox)
{
	var checkedArray = 'message';
  var i;
  var count = 0;
  for (i=0; i<checkbox.length; i++) {
    if (checkbox[i].checked ) {
		if ( parseInt(checkbox[i].value) > 0 )
		{
      		checkedArray = checkedArray + ',' + checkbox[i].value;
		}
    }
  }
//  alert(checkedArray);
  return checkedArray;
}
<?php
}
if ( $jsConfirmSubmit == TRUE )
{
?>

function confirmSubmit(message, form) {
	input_box=confirm(message);
	if (input_box==true) {
		document.form.submit();
	} else {
		return false;
	}
}
<?php
}
if ( $jsCheckAll == TRUE )
{
?>
function checkAll(field)
{
	for (i = 0; i < field.length; i++)
		field[i].checked = true ;
}
<?php
}
?>
function changeValueTemp(iElement)
{
	if(iElement.value==iElement.defaultValue)
		iElement.value='';
	else if(iElement.value=='')
		iElement.value=iElement.defaultValue;
}

</script>
<script src="<?=$baseUrl?>/js/mootools.js"></script>
	<? if ($adminMenu != TRUE && $jsZapatec != TRUE && $tinyMceFull != TRUE) { ?>
    <script type="text/javascript" src="<?=$baseUrl?>/js/jquery-1.6.4.min.js"></script>
    <script type="text/javascript" src="<?=$baseUrl?>/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="<?=$baseUrl?>/js/chat.js"></script>
	<link type="text/css" rel="stylesheet" media="all" href="<?=$baseUrl?>/css/chat.css" />
	<link type="text/css" rel="stylesheet" media="all" href="<?=$baseUrl?>/css/screen.css" />
	<!--[if lte IE 7]>
	<link type="text/css" rel="stylesheet" media="all" href="<?=$baseUrl?>/css/screen_ie.css" />
	<![endif]-->
	<? } ?>
    <link  type="text/css" rel="stylesheet" href="<?=$baseUrl?>/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script src="<?=$baseUrl?>/js/squeezebox.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="<?=$baseUrl?>/squeezebox/squeezebox.css">


<?php

if ( $jsMultiUpload == TRUE ) {
?>
<link rel="stylesheet" type="text/css" media="screen" href="<?=$baseUrl?>/css/Stickman.MultiUpload.css">
<script src="<?=$baseUrl?>/js/Stickman.MultiUpload.js"></script>

<script type="text/javascript">
	window.addEvent('domready', function(){
		// Use defaults: no limit, use default element name suffix, don't remove path from file name
		new MultiUpload( $( 'addPhotoForm2' ).getElementById("bild"), null, null, true );
		new MultiUpload( $( 'addAlbumForm' ).getElementById("bildAlbum"), null, null, true );
		// Max 3 files, use '[{id}]' as element name suffix, remove path from file name, remove extra elemen
		
	});
</script>
<? }?>


<script type="text/javascript">
window.addEvent('domready', function() {

	/**
	 * That CSS selector will find all <a> elements with the
	 * attribute rel="boxed"
	 *
	 * The second argument sets additional options.
	 */
<? if ( $displaySurvey ) { ?>
	SqueezeBox.initialize();

	 SqueezeBox.setOptions({size: {x: 300, y: 330}}).setContent('adopt', $('surveyBox'));
	 
	 <? } 


if ( $displayInvitations ) { ?>
	SqueezeBox.initialize();

	 SqueezeBox.setOptions({size: {x: 300, y: 330}}).setContent('adopt', $('inviteBox'));
	 
	 <? } 

	 


 if ($userProfile["pride09"] == "ejSvarat") { ?>
		SqueezeBox.assign($$('a[rel=boxed]'), {
			size: {x: 300, y: 330},
			ajaxOptions: {
				method: 'get' // we use GET for requesting plain HTML
			}
		});

 <? } ?>
});
</script>





<script src="<?=$baseUrl?>/js/livesearch.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/js/tagsearch.js" type="text/javascript"></script>
<?
if ( $adminMenu != TRUE )
{
    if( $page == "frontpage.html" )
    {
        /* Visas för dom på frontpage.html som inte är inloggade */
        if ( (int)$_SESSION["rights"] < 2 )
        {
            ?>
				<script type="text/javascript">
				
				  var _gaq = _gaq || [];
				  _gaq.push(['_setAccount', 'UA-4244978-1']);
				  _gaq.push(['_setCustomVar', 2, 'Member', 'No', 1]);
				  _gaq.push(['_trackPageview']);
				
				  (function() {
				    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				  })();
				
				</script>         
            <?php
        }
        
        /* Visas för alla inloggade clienter på frontpage.html */
        else
        {
            ?>
                <script type="text/javascript">
                
                  var _gaq = _gaq || [];
                  _gaq.push(['_setAccount', 'UA-4244978-1']);
                  _gaq.push(['_setCustomVar', 1, 'Member', 'Yes', 1]);
                  _gaq.push(['_trackPageview']);
                
                  (function() {
                    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                  })();
                
                </script>    
			<?php
        }
    }
    else
    {
        /* Den gammla koden som visas på alla sidor förutom på Frontpage sidan, oas om man är inloggad eller ej */
        ?>
		<script type="text/javascript">
		
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-4244978-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		
		</script>
        <?php
    }
}
?>
</head>

<body<?php echo ( strlen( $bodyOnload ) > 0 ) ? " " . $bodyOnload:""; ?>>
<? if ($adminMenu != TRUE && $adminFooter != TRUE) { ?>
<div id="main_container">
<? } ?>
<div id="topline">&nbsp;</div>
<?php
if ( $noLogo == FALSE )
{
?>
<h1 id="logo">
<?php
	if ( (int)$_SESSION["rights"] < 2 )
	{
?>
	<a href="<?=$baseUrl?>/" title="Flator.se, lesbisk dating, träffa lesbiska"><span>Flator.se, lesbisk dating, träffa lesbiska</span></a>
<?php
	}
	else
	{
?>
	<a href="<?=$baseUrl?>/" title="Flator.se, lesbisk dating, träffa lesbiska"><span>Flator.se, lesbisk dating, träffa lesbiska</span></a>
<?php	
	}
?>
</h1>
<?php
}
?>
<div id="main">
<?php
$menuUrl = $baseUrl . $_SERVER["REQUEST_URI"];
if ( $adminMenu == TRUE )
{
?>
<div id="leftMenu">
	<div class="contentdiv">

<div id="menucase">
	<ul class="vert-one">
		<li><a href="<?=$baseUrl?>/admin.html"<?php echo ( $baseUrl . "/admin.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Hem</a></li>
		<li><a href="<?=$baseUrl?>/admin_approve.html"<?php echo ( $baseUrl . "/admin_approve.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Godkänn användare</a></li>
		<li><a href="<?=$baseUrl?>/admin_users.html"<?php echo ( $baseUrl . "/admin_users.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Användare</a></li>
		<li><a href="<?=$baseUrl?>/admin_invite.html"<?php echo ( $baseUrl . "/admin_invite.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Inbjudningar</a></li>
		<li><a href="<?=$baseUrl?>/admin_suggestions.html"<?php echo ( $baseUrl . "/admin_suggestions.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Förslag</a></li>
		<li><a href="<?=$baseUrl?>/admin_templates.html"<?php echo ( $baseUrl . "/admin_templates.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Mallväljaren</a></li>
		<li><a href="<?=$baseUrl?>/admin_newsletter.html"<?php echo ( $baseUrl . "/admin_newsletter.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Nyhetsbrev</a></li>
		<li><a href="<?=$baseUrl?>/admin_events.html"<?php echo ( $baseUrl . "/admin_events.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Events</a></li>
		<li><a href="<?=$baseUrl?>/admin_shouts.html"<?php echo ( $baseUrl . "/admin_shouts.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Nyheter</a></li>
		<li><a href="<?=$baseUrl?>/admin_polls.html"<?php echo ( $baseUrl . "/admin_polls.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Omröstningar</a></li>

		<li><a href="<?=$baseUrl?>/admin_questions.html"<?php echo ( $baseUrl . "/admin_questions.html" == $menuUrl ) ? " class=\"current\"":""; ?> style="text-decoration: line-through;">Personliga frågor</a></li>
		<li><a href="<?=$baseUrl?>/admin_layouts.html"<?php echo ( $baseUrl . "/admin_layouts.html" == $menuUrl ) ? " class=\"current\"":""; ?> style="text-decoration: line-through;">Layouter</a></li>
		<li><a href="<?=$baseUrl?>/admin_recommends.html"<?php echo ( $baseUrl . "/admin_recommends.html" == $menuUrl ) ? " class=\"current\"":""; ?> style="text-decoration: line-through;">Rekommenderar</a></li>
		<li><a href="<?=$baseUrl?>/admin_advertising.html"<?php echo ( $baseUrl . "/admin_advertising.html" == $menuUrl ) ? " class=\"current\"":""; ?> style="text-decoration: line-through;">Annonsering</a></li>
		<li><a href="<?=$baseUrl?>/logout.html">Logga ut</a></li>
	</ul>
</div>

<?php
	if ( strlen( $bodyLeft ) > 0 ) echo $bodyLeft;
?>

	</div>
</div>
<?php
}
	


if ( $memberMenu == TRUE )
{
?><div id="topRight">
	<ul class="hor-top">

		<li><a href="<?=$baseUrl?>/my_account.html"<?php echo ( $baseUrl . "/my_account.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Konto & Inställningar</a></li>
		<li>|</li>
		<li><a href="<?=$baseUrl?>/contact.html"<?php echo ( $baseUrl . "/contact.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Kontakt</a></li>
		<li>|</li>
		<li><a href="<?=$baseUrl?>/logout.html"<?php echo ( $baseUrl . "/logout.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Logga ut</a></li>
	</ul>
</div>
<div id="topMenu">

<table border="0" cellpadding="0" cellspacing="0" style="font-size: 12px; width: 100%;">
 <tr>
	<td align="left" valign="middle" style="width: 60%;">
	<form method="GET" action="<?=$baseUrl?>/search.html" style="margin: 0px; padding: 0px" AUTOCOMPLETE="OFF">
	<ul class="hor-one">
		<li<?php echo ( $menuMyPages == TRUE ) ? " class=\"current\"":""; ?>><span<?php echo ( $menuMyPages == TRUE ) ? " class=\"current\"":""; ?>><a href="<?=$baseUrl?>/presentation.html"<?php echo ( $menuMyPages == TRUE ) ? " class=\"current\"":""; ?>>Min sida</a></span></li>
		<li<?php echo ( $menuEvents == TRUE ) ? " class=\"current\"":""; ?>><span<?php echo ( $menuEvents == TRUE ) ? " class=\"current\"":""; ?>><a href="<?=$baseUrl?>/events.html"<?php echo ( $menuEvents == TRUE ) ? " class=\"current\"":""; ?>>Event</a></span></li>
		<li<?php echo ( $menuForum == TRUE ) ? " class=\"current\"":""; ?>><span<?php echo ( $menuForum == TRUE ) ? " class=\"current\"":""; ?>><a href="<?=$baseUrl?>/forum.html"<?php echo ( $menuForum == TRUE ) ? " class=\"current\"":""; ?>>Forum</a></span></li>




		
		<!--<li<?php echo ( $menuVideoChat == TRUE ) ? " class=\"current\"":""; ?>><span<?php echo ( $menuVideoChat == TRUE ) ? " class=\"current\"":""; ?>><a href="<?=$baseUrl?>/videochat.html"<?php echo ( $menuVideoChat == TRUE ) ? " class=\"current\"":""; ?>>Videochat</a></span></li>-->

<?php
if ( strlen( $menuUser ) > 0 )
{
?>
		<li class="current">&nbsp;&nbsp;<a href="<?=$baseUrl?>/user/<?=$_GET["username"]?>.html" class="current"><?=stripslashes($menuUser)?></a></li>
<?php
}
?>
	</ul>
	</td>

	<td align="right" valign="middle" style="width: 40%;"><ul id="topnav">

	<li style="font-weight: normal; margin-top: 5px; margin-right: 10px">
<!--	<a href="advanced_search.html" style="font-weight: normal; padding-top: 15px">Avancerat</a>&nbsp;&nbsp;
		<select name="searchType">
			<option value="people">Flator</option>
			<option value="media">Bilder/video</option>
			<option value="groups">Grupper</option>
		</select>-->

<a href="#noexist" onClick="showPopup('popupAdvSearch');"  style="font-weight: normal; font-size:11px;">Sök på ålder och stad</a>


	</li>
<?php
if ($_SESSION["rights"] > 1) {
		?>
<li id="search"><input type="text" class="txtSearch" name="SearchQuery"  value="S&ouml;k flata (se alla = enter)" onfocus="changeValueTemp(this);" onblur="changeValueTemp(this);" onkeyup="showResult(this.value)" style="width: 120px">
<input type="submit" name="Search" value="" class="btnSearch" AUTOCOMPLETE="OFF"></li></ul>
<div id="livesearch" style="position:absolute; background-color:#fff; width:288px;top:85px;text-align:left;font-size:1px; z-index:50;"></div>
</form>
	</td>

<? } else { ?>
<li id="search"><input type="text" class="txtSearch" name="SearchQuery"  value="S&ouml;k efter en flata" onfocus="changeValueTemp(this);" onblur="changeValueTemp(this);" style="width: 127px">
<input type="submit" name="Search" value="" class="btnSearch"></li></ul>
	</form><div style="float:right; font-family: verdana; font-size: 11px; color: #a09c96; font-weight: normal; margin-right:25px;margin-top:5px;">enter utan text = Listar alla</div>
	</td>
<? } ?>

 </tr>
</table>
<?php
	if ( $menuMyPages == TRUE )
	{
?>
	<ul class="hor-two">
		<li><a href="<?=$baseUrl?>/presentation.html"<?php echo ( $menuPresentation == TRUE ) ? " class=\"current\"":""; ?>><?=$userProfile["username"]?>s sida</a></li>
		<li><a href="<?=$baseUrl?>/inbox.html"<?php echo ( $menuMessages == TRUE ) ? " class=\"current\"":""; ?>>Meddelanden</a></li>
		<li><a href="<?=$baseUrl?>/friends.html"<?php echo ( $menuFriends == TRUE ) ? " class=\"current\"":""; ?>>Vänner</a></li>
		<li><a href="<?=$baseUrl?>/media.html"<?php echo ( $menuMedia == TRUE ) ? " class=\"current\"":""; ?>>Bilder</a></li>

		<li><a href="<?=$baseUrl?>/blog.html"<?php echo ( $menuBlog == TRUE ) ? " class=\"current\"":""; ?>>Blogg</a></li>

		<li><a href="<?=$baseUrl?>/visitors.html"<?php echo ( $menuVisitors == TRUE ) ? " class=\"current\"":""; ?>>Besökare</a></li>
<!--		<li><a href="<?=$baseUrl?>/groups.html"<?php echo ( $menuGroups == TRUE ) ? " class=\"current\"":""; ?>>Grupper</a></li>-->
	</ul>
<?php
	}
	elseif ( $menuEvents == TRUE )
	{
?>
	<ul class="hor-two">
		<li><a href="<?=$baseUrl?>/events.html"<?php echo ( $baseUrl . "/events.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Events</a></li>
		<li><a href="<?=$baseUrl?>/restaurants.html"<?php echo ( $baseUrl . "/restaurants.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Klubb/restaurang</a></li>
		<li><a href="<?=$baseUrl?>/my_events.html"<?php echo ( $baseUrl . "/my_events.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Mina events</a></li>
		<li><a href="<?=$baseUrl?>/friends_events.html"<?php echo ( $baseUrl . "/friends_events.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Vänners events</a></li>
	</ul>
<?php
	}
elseif ( $menuClubMedia == TRUE )
	{
?>
	<ul class="hor-two">
		<li><a href="<?=$baseUrl?>/club_media.html"<?php echo ( $baseUrl . "/club_media.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Klubbalbum</a></li>
		<li><a href="<?=$baseUrl?>/private_media.html"<?php echo ( $baseUrl . "/private_media.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Privata album</a></li>
	</ul>
<?php
	}
	elseif ( $menuPartyMedia == TRUE )
	{
?>
	<ul class="hor-two">
		<li><a href="<?=$baseUrl?>/inbox.html"<?php echo ( $baseUrl . "/inbox.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Meddelanden</a></li>
		<li><a href="<?=$baseUrl?>/presentation.html"<?php echo ( $baseUrl . "/presentation.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Presentation</a></li>
		<li><a href="<?=$baseUrl?>/friends.html"<?php echo ( $baseUrl . "/friends.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Vänner</a></li>
		<li><a href="<?=$baseUrl?>/media.html"<?php echo ( $baseUrl . "/media.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Bilder</a></li>
		<li><a href="<?=$baseUrl?>/blog.html"<?php echo ( $baseUrl . "/blog.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Blogg</a></li>
		<li><a href="<?=$baseUrl?>/visitors.html"<?php echo ( $baseUrl . "/visitors.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Besökare</a></li>
		<li><a href="<?=$baseUrl?>/groups.html"<?php echo ( $baseUrl . "/groups.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Grupper</a></li>
	</ul>
<?php
	}
	elseif ( $menuUser == TRUE )
	{
?>
	<ul class="hor-two">
		<li><a href="<?=$baseUrl?>/user/<?=$_GET["username"]?>.html"<?php echo ( $menuUserPresentation == TRUE ) ? " class=\"current\"":""; ?>><?=ucfirst($_GET["username"])?>s sida</a></li>
		<li><a href="<?=$baseUrl?>/friends/<?=$_GET["username"]?>.html"<?php echo ( $menuUserFriends == TRUE ) ? " class=\"current\"":""; ?>><?=ucfirst($_GET["username"])?>s vänner</a></li>
<?
$q = "SELECT * FROM fl_images WHERE imageType = 'albumPhoto' AND userId = ".(int)$userPres["id"];
		$images = $DB->GetAssoc( $q, FALSE, TRUE );
		if (count($images) > 0) {
			?>
		<li><a href="<?=$baseUrl?>/media/<?=$_GET["username"]?>.html"<?php echo ( $menuUserMedia == TRUE ) ? " class=\"current\"":""; ?>><?=ucfirst($_GET["username"])?>s bilder</a></li>
		<? } 
$images = array();

$q = "SELECT * FROM fl_blog WHERE userId = ".(int)$userPres["id"];
		$blogposts = $DB->GetAssoc( $q, FALSE, TRUE );
		if (count($blogposts) > 0) {
			?>
		<li><a href="<?=$baseUrl?>/blogs/<?=$_GET["username"]?>.html"<?php echo ( $menuUserBlog == TRUE ) ? " class=\"current\"":""; ?>><?=ucfirst($_GET["username"])?>s blogg</a></li>
<? } 
$blogposts = array();?>
<!--		
		<li><a href="<?=$baseUrl?>/groups/<?=$_GET["username"]?>.html"<?php echo ( $menuUserGroups == TRUE ) ? " class=\"current\"":""; ?>>Grupper</a></li>-->
	</ul>
<?php
	}
	if ( $menuUserFriends == TRUE )
	{
?>
	<ul class="hor-three">
		<li><a href="<?=$baseUrl?>/friends/<?=$_GET["username"]?>.html"<?php echo ( $menuUserAllFriends == TRUE ) ? " class=\"current\"":""; ?>>Alla</a></li>
		<li><a href="<?=$baseUrl?>/friends_online/<?=$_GET["username"]?>.html"<?php echo ( $menuUserOnlineFriends == TRUE ) ? " class=\"current\"":""; ?>>Online</a></li>
<!--		<li><a href="<?=$baseUrl?>/friends_updated/<?=$_GET["username"]?>.html"<?php echo ( $menuUserUpdatedFriends ) ? " class=\"current\"":""; ?>>Uppdaterat nyligen</a></li>-->
		<li><a href="<?=$baseUrl?>/friends_common/<?=$_GET["username"]?>.html"<?php echo ( $menuUserCommonFriends ) ? " class=\"current\"":""; ?>>Gemensamma</a></li>
	</ul>
</div>
<?php
	}
	if ( $menuFriends == TRUE )
	{
?>
	<ul class="hor-three">
		<li><a href="<?=$baseUrl?>/friends.html"<?php echo ( $menuAllFriends == TRUE ) ? " class=\"current\"":""; ?>>Alla</a></li>
		<li><a href="<?=$baseUrl?>/friends_online.html"<?php echo ( $menuOnlineFriends == TRUE ) ? " class=\"current\"":""; ?>>Online</a></li>
<!--		<li><a href="<?=$baseUrl?>/friends_updated.html"<?php echo ( $menuUpdatedFriends ) ? " class=\"current\"":""; ?>>Uppdaterat nyligen</a></li>-->
	</ul>
</div>
<?php
	}
	if (( $menuMedia == TRUE ) && ($editMedia == TRUE)) 
	{
?>
	<ul class="hor-three">

	<? if ( $menuViewAlbum == TRUE )
		{
		?>
		<li><a href="<?=$baseUrl?>/media.html">Alla album</a></li>
		<li><a href="<?=$baseUrl?>/media/album/<?=stripslashes( $currentAlbum["id"] )?>.html" class="current"><?=stripslashes( $currentAlbum["name"] )?></a></li>
<?php
		} else {
?>  
		<li><a href="<?=$baseUrl?>/media.html"<?php echo ( $menuMedia == TRUE ) ? " class=\"current\"":""; ?>>Alla album</a></li>


<?
		}
?>
	</ul>
</div>
<?php
	} elseif ( $menuMedia == TRUE ) {
?>
	<ul class="hor-three">

	<? if ( $menuViewAlbum == TRUE )
		{
		?>
		<li><a href="<?=$baseUrl?>/media/<?=stripslashes( $userPres["username"] )?>.html"><?=$menuUser?>s album</a></li>
		<li><a href="<?=$baseUrl?>/media/album/<?=stripslashes( $currentPhoto["albumId"] )?>.html" class="current"><?=stripslashes( $currentAlbum["name"] )?></a></li>
<?php
		} else {
?>  
		<li><a href="<?=$baseUrl?>/media/<?=stripslashes( $userPres["username"] )?>.html"<?php echo ( $menuMedia == TRUE ) ? " class=\"current\"":""; ?>><?=$menuUser?>s album</a></li>


<?
		}
?>
	</ul>
</div>
<?php
	}
if ( $menuForum == TRUE ) {
?>
	<ul class="hor-two-forum">
	<?
if ( strlen($_GET["forumCat"]) > 0 && strlen($_GET["thread"]) > 0 )
		{
		?>
		<li>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$baseUrl?>/forum.html">Forum</a></li>
		<li>&nbsp;&nbsp;<img src="<?=$baseUrl?>/img/symbols/forum/pil_forum.gif" width="8px" height="9px" border="0" style="">&nbsp;&nbsp;<a href="<?=$baseUrl?>/forum/<?=$_GET["forumCat"]?>.html"><?=$forumCatSlug[$_GET["forumCat"]]["name"]?></a></li>
		<li>&nbsp;&nbsp;<img src="<?=$baseUrl?>/img/symbols/forum/pil_forum.gif" width="8px" height="9px" border="0" style="">&nbsp;&nbsp;<a href="<?=$baseUrl?>/forum/<?=$_GET["forumCat"]?>/<?=$_GET["thread"]?>.html" class="current"><?=$threadSubject?></a></li>
<?php
		} elseif ( strlen($_GET["forumCat"]) > 0 )
		{
		?>
		<li>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$baseUrl?>/forum.html">Forum</a></li>
		<li>&nbsp;&nbsp;<img src="<?=$baseUrl?>/img/symbols/forum/pil_forum.gif" width="8px" height="9px" border="0" style="">&nbsp;&nbsp;<a href="<?=$baseUrl?>/forum/<?=$_GET["forumCat"]?>.html" class="current"><?=$forumCatSlug[$_GET["forumCat"]]["name"]?></a></li>
<?php
		} else {
?>  
		<li>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$baseUrl?>/forum.html" class="current">Forum</a></li>

<?
		}
?>
	</ul>
</div>
<?php
	}

if ( $menuAccount == TRUE ) {
?>

</div>
<?php
	}

if ( $menuToplists == TRUE ) {
?>

</div>
<?php
	}

if (( $menuClubMedia == TRUE ) && ($false == TRUE)) {
?>
	<ul class="hor-three">

	<? if ( $menuViewAlbum == TRUE )
		{
		?>
		<li><a href="<?=$baseUrl?>/media/<?=stripslashes( $userPres["username"] )?>.html">Alla album</a></li>
		<li><a href="<?=$baseUrl?>/media/album/<?=stripslashes( $currentPhoto["albumId"] )?>.html" class="current"><?=stripslashes( $currentAlbum["name"] )?></a></li>
<?php
		} else {
?>  
		<li><a href="<?=$baseUrl?>/media/<?=stripslashes( $userPres["username"] )?>.html"<?php echo ( $menuClubMedia == TRUE ) ? " class=\"current\"":""; ?>>Alla album</a></li>


<?
		}
?>
	</ul>
</div>
<?php
	}

	if ( $menuMessages == TRUE )
	{
?>
	<ul class="hor-three">
		<li><a href="<?=$baseUrl?>/inbox.html"<?php echo ( $menuInbox == TRUE ) ? " class=\"current\"":""; ?>>Meddelanden (<?=number_format((int)$unReadMessages, 0, ",", " ")?>)</a></li>
		<li><a href="<?=$baseUrl?>/new_message.html"<?php echo ( $menuNewMessage ) ? " class=\"current\"":""; ?>>Skapa nytt meddelande</a></li>
<?php
		if ( $menuReadMessage == TRUE )
		{
?>
		<li><a href="<?=$baseUrl?>/konv/<?=stripslashes( $_GET["username"] )?>.html" class="current">Konversation med <?=stripslashes( $_GET["username"] )?></a></li>
<?php
		}
?>
	</ul>
</div>
<?php
	}
	else
	{
?>
<!--<p style="padding-bottom: 20px">&nbsp;</p>-->
<?php	
	}

	if ( $menuPresentation == TRUE || $menuUserPresentation == TRUE || $menuEvents == TRUE)
	{
?>
<p style="display: block; margin: 0px; margin-bottom: 8px">&nbsp;</p>
<?php
	}

	if ( $menuVisitors == TRUE )
	{
?>
<p style="display: block; margin: 0px; margin-bottom: 12px">&nbsp;</p>
<?php
	}

	if ( $menuFrontpage == TRUE )
	{
?>
<p style="display: block; margin: 0px; margin-bottom: 0px">&nbsp;</p>
<?php
	}
	if ( $menuSearch == TRUE )
	{
?>
<p style="display: block; margin: 0px; margin-bottom: 0px">&nbsp;</p>
<?php
	}

	if ( $menuPadding == TRUE )
	{
?>
<p style="padding-bottom: 10px">&nbsp;</p>
<?php
	}
?>
<div id="leftMenu">
<ul class="ver-left">


<?php if ( $newNotes == TRUE )
{
?>
	<li><a href="<?=$baseUrl?>/notes.html"<?php echo ( $baseUrl . "/notes.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Nya notes</a></li>
<?php
}

if ( $_SESSION["demo"] == TRUE ) {
echo "<li>Du är inloggad<br>i <strong>demoläge</strong>.<br>Med detta konto<br>kan du \"se men <br>inte röra\".</li>";
}

?>
<!--	<li><a href="<?=$baseUrl?>/chat.html"<?php echo ( $baseUrl . "/events.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Chat / Videochat</a></li>-->
</ul>
</div>
<?php
}
elseif ( $publicMenu == TRUE )
{
?>
<!--<div id="topRight">
	<ul class="hor-top">
		<li><a href="<?=$baseUrl?>/contact.html"<?php echo ( $baseUrl . "/contact.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Kontakt</a></li>
		<li>|</li>
		<li><a href="<?=$baseUrl?>/register.html"<?php echo ( $baseUrl . "/register.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Bli Medlem</a></li>
		<li>|</li>
		<li><a href="<?=$baseUrl?>/frontpage.html"<?php echo ( $loginForm == TRUE ) ? " class=\"current\"":""; ?>>Logga in</a></li>
	</ul>
</div>-->
<p style="padding-bottom: 40px">&nbsp;</p>
<?php
}
?>

<?=$body?>
<div id="footer" style="clear:both;width:100%; border-top: 1px dotted #c8c8c8;">
<?
if ( $memberMenu == TRUE )
{
?>
	<ul class="hor-top">
		<li><a href="<?=$baseUrl?>/my_account.html"<?php echo ( $baseUrl . "/my_account.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Konto & Inställningar</a></li>
		<li>|</li>
		<li><a href="<?=$baseUrl?>/contact.html"<?php echo ( $baseUrl . "/contact.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Kontakt</a></li>
		<li>|</li>
		<li><a href="<?=$baseUrl?>/logout.html"<?php echo ( $baseUrl . "/logout.html" == $menuUrl ) ? " class=\"current\"":""; ?>>Logga ut</a></li>
	</ul>

<? } ?></div>

</div>
</div>

<div id="popupAdvSearch" class="searchPopup" style="display: none;">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Avancerad sökning</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupAdvSearch');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>

<form method="get" enctype="multipart/form-data" style="" name="advSearchForm" action="<?=$baseUrl?>/search.html">
<input type="hidden" name="type" value="advSearch">
<div style="float: left; width: 230px; margin-left: 30px;">Namn eller del av namn:</div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input type="text" name="SearchQuery" style="width: 197px; border: 0px" value=""></div>&nbsp;&nbsp;
<span style="float:right; font-family: verdana; font-size: 11px; color: #a09c96; font-weight: normal; margin-right:65px;margin-top:0px;">enter utan text = Listar alla</span><div style="float:none;"></div><br><br>

<div style="float: left; width: 230px; margin-left: 30px;">Från stad:</div>

	<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
	<select name="city_id" id="city_id" style="width: 197px; border: 0px; ">
<?
			echo "<option value=\"0\" selected>Hela Sverige</option>\n";
		while ( list( $key, $value ) = each( $cities ) )
		{
			
			echo "<option value=\"".$cities[ $key ]["id"]."\">".$cities[ $key ]["city"]."</option>\n";
    }

?>
</select></div><div style="float:none;"></div><br><br>

<div style="float: left; width: 230px; margin-left: 30px;">Ålder:</div>

	<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
	<select name="lowAge" id="lowAge" style="width: 40px; border: 0px">
<?$i = 10;
		while ( $i < 71 )
		{
			
        	$selected = ($i == 15) ? " selected":"";
			echo "<option value=\"".$i."\"".$selected.">".$i."</option>\n";
			$i++;
    }

?>
</select></div><div style="display: inline; float: left; border:none; margin-left:5px;margin-right:5px;"> till </div><div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;"><select name="highAge" id="highAge" style="width: 40px; border: 0px;">
<?$i = 10;
		while ( $i < 71 )
		{
			$selected = ($i == 65) ? " selected":"";
			echo "<option value=\"".$i."\"".$selected.">".$i."</option>\n";
			$i++;
    }

?>
</select></div><div style="float:none;"></div><br>
<? if ($false == TRUE ) { ?>
<div style="float: left; width: 230px; margin-left: 30px;">Innehåll på presentation:</div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input type="text" name="description" style="width: 197px; border: 0px" value=""></div>
<? }?>
<span onMouseOver="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onMouseOut="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onClick="document.advSearchForm.submit();" style=" margin-left: 30px;"><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="addFriendSubmit" style="vertical-align:middle;" border="0">Sök</a></nobr><br><br></span>
</form>
<?
	$q = "SELECT * FROM fl_searches where userId = " . (int)$_SESSION["userId"] . " group by searchDesc order by id desc limit 5";
	$latestSearches = $DB->CacheGetAssoc( 2*60, $q, FALSE, TRUE );
				if ( count( $latestSearches ) > 0 )
				{

					?>
						
	<div style="float: left; display: block; border-bottom: 1px dotted #c8c8c8; margin-left:20px; padding-bottom:5px;width:90%;margin-bottom:5px;"><h3>Senaste fem sökningarna</h3></div>
<div style="float: left;  margin-left:20px; padding-bottom:5px;">
					<?
					while ( list( $key, $value ) = each( $latestSearches ) )
					{
echo '<a href="'.$latestSearches[$key]["searchUrl"].'">'.$latestSearches[$key]["searchDesc"].'</a><br>';
					}
					?>
</div>

					<? }
						
?>


</div>

<div id="popupMediumImage" class="popupImage" style="display: none"><div style="margin: 0px"><div style="float: left; display: block"><a href="#" onclick="closeImage('popupMediumImage');"><img src="<?=$baseUrl?>/img/symbols/gif_avatars/person_avantar_stor.gif" id="mediumProfileImage" border="0" style="margin: 3px"></a></div></div></div>

<?php
	if ( $divPopup == TRUE )
	{
?>
<div id="popupAddFriend" class="popup" style="display: none">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Lägg till som vän</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupAddFriend');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>

<p style="margin: 4px; margin-left: 20px; margin-right: 20px;">Välj typ av relation och klicka sedan spara. En förfrågan kommer då skickas till <b><?=$_GET["username"]?></b> om att du vill bli vän.</p>

<form method="post" style="margin: 4px; margin-left: 20px; margin-right: 20px; padding-bottom: 20px" name="friendForm">
<input type="hidden" name="type" value="addFriend">
<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<select name="relationship" style="width: 250px; border: 0px">
	<option value="">--</option>
	<option value="friend">Vän</option>
	<option value="girlfriend">Flickvän</option>
	<option value="secretFriend">Hemlig flört</option>
</select></div>&nbsp;&nbsp;
<span onMouseOver="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onMouseOut="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onClick="document.friendForm.submit();"><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="addFriendSubmit" style="vertical-align:middle;" border="0">Skicka</a></nobr></span>
</form>
</div>



<div id="popupSendFlirt" class="popup" style="display: none; top: 400px; left: 300px; z-index: 100; background-color: #ffffff; width: 350px">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Skicka flört</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupSendFlirt');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>

<p style="margin: 4px; margin-left: 20px; margin-right: 20px;">Välj vilken typ av flört du vill skicka till <b><?=$_GET["username"]?></b>:</p>

<form method="post" style="margin: 4px; margin-left: 20px; margin-right: 20px; padding-bottom: 20px" name="flirtForm">
<input type="hidden" name="type" value="sendFlirt">
<div style="display: inline; float: left; border:0px;">
<input type="radio" name="flirt" value="sexbomb" selected></div><div style="display: inline; float: left; border:0px;margin-left:20px;"><img src="<?=$baseUrl?>/img/symbols/gif_purple/regler.gif" style="vertical-align:middle;" border="0">&nbsp;&nbsp;&nbsp;Du är en sexbomb!</div>
<div style="clear:both;"></div>
<div style="display: inline; float: left; border:0px;">
<input type="radio" name="flirt" value="kastaankare" selected></div><div style="display: inline; float: left; border:0px; margin-left:20px;"><img src="<?=$baseUrl?>/img/symbols/gif_purple/mig.gif" style="vertical-align:middle;" border="0">&nbsp;&nbsp;&nbsp;Får jag kasta ankare hos dig?</div>
<div style="clear:both;"></div>
<div style="display: inline; float: left; border:0px;">
<input type="radio" name="flirt" value="klass" selected></div><div style="display: inline; float: left; border:0px; margin-left:20px;"><img src="<?=$baseUrl?>/img/symbols/gif_purple/topplista_film.gif" style="vertical-align:middle;" border="0">&nbsp;&nbsp;&nbsp;Dig är det klass på!</div>
<div style="clear:both;"></div>
<div style="display: inline; float: left; border:0px;">
<input type="radio" name="flirt" value="drink" selected></div><div style="display: inline; float: left; border:0px; margin-left:20px;"><img src="<?=$baseUrl?>/img/symbols/gif_purple/typ_av_event.gif" style="vertical-align:middle;" border="0">&nbsp;&nbsp;&nbsp;Dig skulle jag kunna ta en drink med!</div>
<div style="clear:both;"></div>
<div style="display: inline; float: left; border:0px;">
<input type="radio" name="flirt" value="message" selected></div><div style="display: inline; float: left; border:0px; margin-left:20px;"><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka_flort.gif" style="vertical-align:middle;" border="0">&nbsp;&nbsp;&nbsp;<input type="text" name="message" value="Ange ett eget flört-mess!" style="width:170px;" onfocus="changeValueTemp(this);" onblur="changeValueTemp(this);"></div>
<div style="clear:both;"></div><br><br>
<span onMouseOver="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onMouseOut="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onClick="document.flirtForm.submit();"><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="addFriendSubmit" style="vertical-align:middle;" border="0">Skicka flört</a></nobr></span>
</form>
</div>


<div id="popupNewEvent" class="popup" style="display: none">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Skapa nytt event / Redigera event</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupNewEvent');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>

<form method="post" enctype="multipart/form-data" style="margin: 4px; margin-left: 30px; margin-right: 30px; padding-bottom: 20px" name="newEventForm">

<p><label for="eventType">Typ av event:</label> <select id="eventType" name="eventType">
	<option value="">--</option>
<?php
	$q = "SELECT * FROM fl_event_types ORDER BY eventType ASC";
	$row = $DB->CacheGetAssoc( 20*60, $q, FALSE, TRUE );
	if ( count( $row ) > 0 )
	{
		while ( list( $key, $value ) = each( $row ) )
		{
			unset( $selected );
			if ( $_POST["eventType"] == $row[ $key ]["eventType"] ) $selected = " selected";
			echo "	<option value=\"" . $row[ $key ]["eventType"] . "\"" . $selected . ">" . $row[ $key ]["eventType"] . "</option>\n";
		}
	}
?>
</select></p>
<p><label for="name">Namn:</label> <input type="text" id="name" name="name" value="<?=stripslashes( $_POST["name"] )?>"></p>
<p><label for="location">Plats:</label> <input type="text" id="location" name="location" value="<?=stripslashes( $_POST["location"] )?>"></p>
<p><label for="postalAddress">Postadress:</label> <input type="text" id="postalAddress" name="postalAddress" value="<?=stripslashes( $_POST["postalAddress"] )?>"></p>
<p><label for="city">Stad/Ort:</label> <select id="city" name="city">
	<option value="">--</option>
<?php
	$q = "SELECT * FROM fl_cities ORDER BY city ASC";
	$rowCity = $DB->GetAssoc( $q, FALSE, TRUE );
	if ( count( $rowCity ) > 0 )
	{
		while ( list( $key, $value ) = each( $rowCity ) )
		{
			unset( $selected );
			if ( $_POST["city"] == $rowCity[ $key ]["city"] ) $selected = " selected";
			echo "	<option value=\"" . $rowCity[ $key ]["city"] . "\"" . $selected . ">" . $rowCity[ $key ]["city"] . "</option>\n";
		}
	}
?>

</select></p>
<p>Om eventtypen är Klubb eller Restuarang behöver du ej ange start eller slutdatum.</p>
<p><label for="startDate">Startar:</label> <select name="startYear">
<option value="">--</option>
<?php
	$startYear = "2008";
	while ( $startYear <= (date("Y")+1) )
	{
		echo "<option value=\"" . $startYear . "\">" . $startYear . "</option>";
		$startYear++;
	}

?></select>-<select name="startMonth">
<option value="">--</option>
<?php
	$i = 1;
	while ( $i <= 12 )
	{
		if ( $i < 10 ) $i = "0" . $i;
		echo "<option value=\"" . $i . "\">" . $i . "</option>";
		$i++;
	}
?></select>-<select name="startDay">
<option value="">--</option>
<?php
	$i = 1;
	while ( $i <= 31 )
	{
		if ( $i < 10 ) $i = "0" . $i;
		echo "<option value=\"" . $i . "\">" . $i . "</option>";
		$i++;
	}
?></select> <select name="startHour">
<option value="">--</option>
<?php
	$i = 0;
	while ( $i <= 23 )
	{
		if ( $i < 10 ) $i = "0" . $i;
		echo "<option value=\"" . $i . "\">" . $i . "</option>";
		$i++;
	}
?></select>:<select name="startMinute">
<option value="">--</option>
<?php
	$i = 0;
	while ( $i <= 59 )
	{
		if ( $i < 10 ) $i = "0" . $i;
		echo "<option value=\"" . $i . "\">" . $i . "</option>";
		$i = $i + 15;
	}
?></select></p>
<p><label for="endDate">Slutar:</label> <select name="endYear">
<option value="">--</option>
<?php
	$endYear = "2008";
	while ( $endYear <= (date("Y")+1) )
	{
		echo "<option value=\"" . $endYear . "\">" . $endYear . "</option>";
		$endYear++;
	}

?></select>-<select name="endMonth">
<option value="">--</option>
<?php
	$i = 1;
	while ( $i <= 12 )
	{
		if ( $i < 10 ) $i = "0" . $i;
		echo "<option value=\"" . $i . "\">" . $i . "</option>";
		$i++;
	}
?></select>-<select name="endDay">
<option value="">--</option>
<?php
	$i = 1;
	while ( $i <= 31 )
	{
		if ( $i < 10 ) $i = "0" . $i;
		echo "<option value=\"" . $i . "\">" . $i . "</option>";
		$i++;
	}
?></select> <select name="endHour">
<option value="">--</option>
<?php
	$i = 0;
	while ( $i <= 23 )
	{
		if ( $i < 10 ) $i = "0" . $i;
		echo "<option value=\"" . $i . "\">" . $i . "</option>";
		$i++;
	}
?></select>:<select name="endMinute">
<option value="">--</option>
<?php
	$i = 0;
	while ( $i <= 59 )
	{
		if ( $i < 10 ) $i = "0" . $i;
		echo "<option value=\"" . $i . "\">" . $i . "</option>";
		$i = $i + 15;
	}
?></select></p></p>
<p><label for="image">Bild:</label> <input id="image" type="file" name="image"></p>
<p><label for="description">Beskrivning:</label> <textarea id="description" name="description" rows=6 style="width: 250px; display: inline"><?=stripslashes( $_POST["description"] )?></textarea></p>
<p><label for="requirements">Entré/krav:</label> <input type="text" id="requirements" name="requirements" value="<?=stripslashes( $_POST["requirements"] )?>"></p>

<p><label for="image">Vill du ha ditt event publikt för alla medlemmar?</label> <input type="radio" name="public" value="YES"> Ja <input type="radio" name="public" checked value="NO"> Nej

<p class="submit"><input type="submit" value="Spara event"></p>
</form>

</form>
</div>
</div>

<div id="popupAddAlbum" class="popup" style="display: none; width:500px;">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Skapa nytt album</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupAddAlbum');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>

<form method="post" enctype="multipart/form-data" style="   padding-bottom: 20px" name="addAlbumForm" id="addAlbumForm">
<input type="hidden" name="type" value="addAlbum">
<input type="hidden" name="type2" value="uploadPhoto">
<div style="float: left; width: 230px;margin-left:30px;">Ange ett namn åt ditt nya album:</div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70; " valign="top" align="left">
<input type="text" name="album" style="margin-left:0px;width: 197px; border: 0px"></div>&nbsp;&nbsp;
<div style="clear:both;"></div><br>
<div style="float: left; width: 230px;margin-left:30px;">Plats för foto / film:</div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input type="text" name="location" style="width: 197px; border: 0px"></div>
<div style="float:none;"></div><br><br>

<div style="float: left; width: 230px;margin-left:30px;">Beskrivning av album:</div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input type="text" name="description" style="width: 197px; border: 0px"></div>
<div style="float:none;"></div><br><br>
<div style="float: left; width: 230px; margin-left: 30px;">Visa endast för vänner?</div>


<div style="display: inline; float: left; border:solid 0px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
			<?
	echo "<input type=\"radio\" name=\"friends_only\" value=\"YES\"";
 
			echo "> Ja
						<input type=\"radio\" name=\"friends_only\" value=\"NO\"";
			echo " checked"; 
			echo "> Nej</div>";
			?>
<br><br>

<div style="float: left; width: 230px;margin-left:30px;">Välj bilder / film:</div>


<div style="display: inline; float: left; border:solid 0px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input name="bild[]" id="bildAlbum" type="file" style="display:inline;width: 197px; border:solid 1px #aa567a;"><br clear="all"/><br/>
</div>


<div style="clear:both;"></div>
<span onMouseOver="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onMouseOut="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'" style="float:right;margin-right:40px;"><nobr><a href="#noexist" onClick="document.addAlbumForm.submit();"><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="addFriendSubmit" style="vertical-align:middle;" border="0">Skapa album</a></nobr></span>
</form>

</form>
</div>
</div>





<div id="popupWriteForum" class="popup" style="display: none">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Skapa ny forumtråd</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupWriteForum');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeForumThreadPopup" border="0" onMouseOver="document.closeForumThreadPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeForumThreadPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>

<form method="post" enctype="multipart/form-data" style="padding-bottom: 20px" name="writeForumForm">
<input type="hidden" name="type" value="writeForumThread">
<div style="float: left; width: 130px;margin-left: 30px;">Rubrik:</div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input type="text" name="headline" style="width: 197px; border: 0px"></div>&nbsp;&nbsp;
<div style="float:none;"></div><br>


<div style="float: left; width: 130px;margin-left: 30px;">Inlägg:</div>

<div style="display: inline; float: left; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">


<span onMouseOver="document.fetStil.src='<?=$baseUrl?>/img/symbols/forum/tf_bold_active.gif'" onMouseOut="document.fetStil.src='<?=$baseUrl?>/img/symbols/forum/tf_bold.gif'"><a href="#noexist" onClick="document.forms['writeForumForm']. elements['text'].value=document.forms['writeForumForm']. elements['text'].value+'[b][/b]'" style="font-weight: normal"><img src="<?=$baseUrl?>/img/symbols/forum/tf_bold.gif" border="0" style="vertical-align:middle;" name="fetStil"></a></span>
<span onMouseOver="document.kursivStil.src='<?=$baseUrl?>/img/symbols/forum/tf_italic_active.gif'" onMouseOut="document.kursivStil.src='<?=$baseUrl?>/img/symbols/forum/tf_italic.gif'"><a href="#noexist" onClick="document.forms['writeForumForm']. elements['text'].value=document.forms['writeForumForm']. elements['text'].value+'[i][/i]'" style="font-weight: normal"><img src="<?=$baseUrl?>/img/symbols/forum/tf_italic.gif" border="0" style="vertical-align:middle;" name="kursivStil"></a></span>
<span onMouseOver="document.underStruken.src='<?=$baseUrl?>/img/symbols/forum/tf_underline_active.gif'" onMouseOut="document.underStruken.src='<?=$baseUrl?>/img/symbols/forum/tf_underline.gif'"><a href="#noexist" onClick="document.forms['writeForumForm']. elements['text'].value=document.forms['writeForumForm']. elements['text'].value+'[u][/u]'" style="font-weight: normal"><img src="<?=$baseUrl?>/img/symbols/forum/tf_underline.gif" border="0" style="vertical-align:middle;" name="underStruken"></a></span>
<span onMouseOver="document.skapaLank.src='<?=$baseUrl?>/img/symbols/forum/tf_link_active.gif'" onMouseOut="document.skapaLank.src='<?=$baseUrl?>/img/symbols/forum/tf_link.gif'"><a href="#noexist" onClick="addurl(document.forms['writeForumForm'].elements['text']);" style="font-weight: normal"><img src="<?=$baseUrl?>/img/symbols/forum/tf_link.gif" border="0" style="vertical-align:middle;" name="skapaLank"></a></span><br>

	<textarea name="text" style="width: 397px; height: 250px; border:solid 1px #aa567a; z-index:100; "></textarea>
	</div>



<div style="float:none;"></div><br>
		

<div style="float: left; width: 190px;margin-left: 30px;">
<span onMouseOver="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onMouseOut="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onClick="document.writeForumForm.submit();" ><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="newForumThread" style="vertical-align:middle;" border="0">Publicera tråd</a></nobr></span><br><br></div>
</form>
</div>






<div id="popupWriteBlog" class="popup" style="display: none">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Skriv nytt blogginlägg</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupWriteBlog');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>

<form method="post" enctype="multipart/form-data" style="padding-bottom: 20px" name="writeBlogForm">
<input type="hidden" name="type" value="writeBlog">
<div style="float: left; width: 130px;margin-left: 30px;">Rubrik:</div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input type="text" name="subject" style="width: 197px; border: 0px"></div>&nbsp;&nbsp;
<div style="float:none;"></div><br>


<div style="float: left; width: 130px;margin-left: 30px;">Inlägg:</div>

<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
	<textarea name="content" style="width: 397px; height: 300px; border:0px; "></textarea>
	</div>
<div style="float:none;"></div><br>
		

<div style="float: left; width: 190px;margin-left: 30px;">
<span onMouseOver="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onMouseOut="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onClick="document.writeBlogForm.submit();" ><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="addFriendSubmit" style="vertical-align:middle;" border="0">Publicera blogginlägg</a></nobr></span><br><br></div>
</form>
</div>











<?
if ( count($albums) > 0 ) { 
reset($albums);
while ( list( $key, $value ) = each( $albums ) ) { ?>
		

<div id="popupEditAlbum<?=$albums[ $key ]["id"]?>" class="popup" style="display: none">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Redigera album</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupEditAlbum<?=$albums[ $key ]["id"]?>');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>

<form method="post" enctype="multipart/form-data"  name="editAlbumForm<?=$albums[ $key ]["id"]?>">
<input type="hidden" name="type" value="editAlbum">
<input type="hidden" name="albumId" value="<?=$albums[ $key ]["id"]?>">
<div style="float: left; width: 230px; margin-left: 30px;">Namn på album:</div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input type="text" name="album" style="width: 197px; border: 0px" value="<?=$albums[ $key ]["name"]?>"></div>&nbsp;&nbsp;
<div style="float:none;"></div><br>
<div style="float: left; width: 230px; margin-left: 30px;">Plats där fotografierna är tagna:</div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input type="text" name="location" style="width: 197px; border: 0px" value="<?=$albums[ $key ]["location"]?>"></div>
<div style="float:none;"></div><br><br>

<div style="float: left; width: 230px; margin-left: 30px;">Beskrivning av album:</div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input type="text" name="description" style="width: 197px; border: 0px" value="<?=$albums[ $key ]["description"]?>"></div>
<br><br>
<div style="float: left; width: 230px; margin-left: 30px;">Visa endast för vänner?</div>


<div style="display: inline; float: left; border:solid 0px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
			<?
	echo "<input type=\"radio\" name=\"friends_only\" value=\"YES\"";
			  echo ($albums[ $key ]["friends_only"] == "YES") ? " checked":""; 
			echo "> Ja
						<input type=\"radio\" name=\"friends_only\" value=\"NO\"";
			echo ($albums[ $key ]["friends_only"] == "NO") ? " checked":""; 
			echo "> Nej</div>";
			?>
<br><br>
<span onMouseOver="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onMouseOut="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onClick="document.editAlbumForm<?=$albums[ $key ]["id"]?>.submit();" style=" margin-left: 30px;"><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="addFriendSubmit" style="vertical-align:middle;" border="0">Spara ändringar</a></nobr></span><br><br><br>
<div style=" margin-left: 30px;">
Observera att eventuella ändringar försvinner om du inte sparar innan du <br>laddar upp bilder / film till ditt album.</div><br>
<span onMouseOver="document.ladda_upp_bild.src='<?=$baseUrl?>/img/symbols/gif_red/ladda_upp_bild.gif'" onMouseOut="document.ladda_upp_bild.src='<?=$baseUrl?>/img/symbols/gif_purple/ladda_upp_bild.gif'"><a href="#noexist" onClick="showPopup('popupUploadPhoto2');" style="font-weight: normal; margin-left: 30px;"><img src="<?=$baseUrl?>/img/symbols/gif_purple/ladda_upp_bild.gif" border="0" style="vertical-align:middle;" name="ladda_upp_bild">&nbsp;&nbsp;Ladda upp bild / film</a></span><br><br>

</form>
</div>
</div>
<?} } ?>






<?

if ( $currentPhoto["id"] > 0 ) { ?>
		

<div id="popupEditPhoto" class="popup" style="display: none; z-index: 10;">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Redigera fotografi</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupEditPhoto');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>

<form method="post" enctype="multipart/form-data" style="" name="editPhotoForm">
<input type="hidden" name="type" value="editPhoto">
<input type="hidden" name="photoId" value="<?=$currentPhoto["id"]?>">
<div style="float: left; width: 230px; margin-left: 30px;">Namn på fotografi:</div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input type="text" name="name" style="width: 197px; border: 0px" value="<?=$currentPhoto["name"]?>"></div>&nbsp;&nbsp;
<div style="float:none;"></div><br>

<span onMouseOver="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onMouseOut="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onClick="document.editPhotoForm.submit();" style=" margin-left: 30px;"><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="addFriendSubmit" style="vertical-align:middle;" border="0">Spara fotografi</a></nobr><br><br></span>
</form>

</form>
</div>
</div>
<?}  ?>

		










<div id="popupConnectPhotos" class="popup" style="display: none">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Hur gör man för att koppla bilder / film till blogginlägg?</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupConnectPhotos');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>


<div style="float: left; width: 500px; margin-left: 30px; margin-right: 30px; margin-bottom:30px;">Det är väldigt enkelt, det går till så att du letar upp de bilder eller filmer som antingen du eller en annan flata har laddat upp och väljer sedan i högerkolumnen att koppla denna bild / film till ett av dina blogginlägg, då får du sedan välja vilket av dina blogginlägg som du vill koppla till. <br><br>Om du har ett fotografi eller en film på datorn som du tycker passar till ditt blogginlägg får du först ladda upp detta till ett eget album innan du kan koppla det till ett blogginlägg.<br><br>
<a href="#" onclick="closePopup('popupConnectPhotos');">Stäng</a>
</div>
</div>












<div id="popupUploadPhoto2" class="popup" style="display: none; width:400px;">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Ladda upp bilder & film</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupUploadPhoto2');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>
<? reset($albums);

	
		if ($currentAlbum["id"] != "") { ?>

<form method="post" enctype="multipart/form-data" style="padding-bottom: 20px" action="<?=$baseUrl?>/media/album/<?=$currentAlbum["id"]?>.html" id="addPhotoForm2" name="addPhotoForm2">
<?} elseif (count($albums) < 2 && count($albums) > 0) {

 while ( list( $key, $value ) = each( $albums ) )
		{ ?>
<form method="post" enctype="multipart/form-data" style="padding-bottom: 20px" action="<?=$baseUrl?>/media/album/<?=$albums[ $key ]["id"]?>.html" id="addPhotoForm2" name="addPhotoForm2">

<? }
} else {?>
<form method="post" enctype="multipart/form-data" style="padding-bottom: 20px" action="<?=$baseUrl?>/media.html" id="addPhotoForm2" name="addPhotoForm2">

<? } ?>
<input type="hidden" name="type" value="uploadPhoto2">

<?	reset($albums);
if (count($albums)<2) {
	if ($currentAlbum["id"] != "") {?>

<input type="hidden" name="album" value="<?=$currentAlbum["id"]?>">
<?} else {?>

<? while ( list( $key, $value ) = each( $albums ) )
		{ ?>
		<input type="hidden" name="album" value="<?=$albums[ $key ]["id"]?>">

<? }?>
<?}?>
<? } else {?>
<div style="float: left; width: 110px; margin-left: 30px; margin-right: 30px;">Välj album:</div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">



<select name="album">
<? while ( list( $key, $value ) = each( $albums ) )
		{ ?>
<option value="<?=$albums[ $key ]["id"]?>"><?=$albums[ $key ]["name"]?></option>
<? }?>
</select>

</div>
<div style="float:none;"></div><br><br>
<?}?>
<div style="float: left; width: 110px; margin-left: 30px; margin-right: 30px;">Välj bilder / film:</div>


<div style="display: inline; float: left;  filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input name="bild[]" id="bild" type="file" style="display:inline;width: 197px; border:solid 1px #aa567a;"><br clear="all"/><br/>
</div>

<div style="float:none;"></div><br>
<div style="float: right; width: 150px; font-weight:bold; margin-left: 30px;margin-right:30px;"><span onMouseOver="document.submitUpload.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onMouseOut="document.submitUpload.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onClick="document.addPhotoForm2.submit();">Ladda upp bilder / film <img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="submitUpload" style="vertical-align:middle;" border="0"></a></nobr></span>
<br><br>
</form><br>


</div>
</div>






<?
		$q = "SELECT fl_blog.* FROM fl_blog WHERE fl_blog.userId = " . (int)$userProfile["id"] . " ORDER BY fl_blog.id DESC";
		$blogEntries = $DB->CacheGetAssoc( 1*60, $q, FALSE, TRUE );
	?>
<div id="popupAddToBlog" class="popup" style="display: none">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Koppla fotografi till blogginlägg</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupAddToBlog');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>
<? if ( count( $blogEntries ) > 0 )
	{ ?>
<form method="post" enctype="multipart/form-data" style=" padding-bottom: 20px" name="addToBlogForm">
<input type="hidden" name="type" value="addToBlog">
<input type="hidden" name="photoId" value="<?=$currentPhoto["id"]?>">
<div style="float:none;"></div><br><br>

<div style="float: left; width: 230px; margin-left: 30px; margin-right: 30px;">Välj blogginlägg att koppla bilden till: <b>*</b></div>


<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">



<select name="blogPost">
<? while ( list( $key, $value ) = each( $blogEntries ) )
		{ ?>
<option value="<?=$blogEntries[ $key ]["id"]?>"><?=stripslashes($blogEntries[ $key ]["subject"])?></option>
<? }?>
</select>

</div>
<div style="float:none;"></div><br><br>

<div style="float: left; width: 230px; font-weight:bold; margin-left: 30px; margin-right: 30px;">*: Måste anges</div>
<span onMouseOver="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onMouseOut="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onClick="document.addToBlogForm.submit();"><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="addFriendSubmit" style="vertical-align:middle;" border="0">Koppla bild</a></nobr></span>
<br><br>
</form><br>


<? } else {?>
<div style="margin: 4px; margin-left: 30px; margin-right: 30px;">Först måste du ha skrivit minst ett <a href="<?=$baseUrl?>/blog.html">blogginlägg</a>!</div>
<?}?>
</div>
</div>




<div id="popupAddToChallenge" class="popup" style="display: none">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">
<?
		$q = "SELECT fl_challenges.* FROM fl_challenges WHERE active =  'YES' and type = 'photoChallenge' ORDER BY fl_challenges.id DESC LIMIT 1";
		$challenge = $DB->CacheGetAssoc( 30*60, $q, FALSE, TRUE );

if ( count( $challenge ) > 0 )
	{ 
	while ( list( $key, $value ) = each( $challenge ) )
		{ 

		$q = "SELECT fl_challenge_participants.* FROM fl_challenge_participants WHERE challengeId =  '".$challenge[ $key ]["id"]."' and mediaId = '".(int)$currentPhoto["id"]."' LIMIT 1";
		$challengeParticips = $DB->GetAssoc( $q, FALSE, TRUE );
		if (count($challengeParticips) > 0) {
		$already = TRUE;
		} else {
		$already = FALSE;
		}

		$avatar = "<img src=\"".$baseUrl."/user-photos/" . urlencode(str_replace("/srv/www/htdocs/rwdx/photos/", "", $currentPhoto["serverLocation"])) . "/medium-challenge/\" border=\"0\" width=\"150\" height=\"\" />";
	?>
	<div style="float: left; display: block"><h3>Anmälan till bildtävling</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupAddToChallenge');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>

<form method="post" enctype="multipart/form-data" style=" padding-bottom: 20px" name="addToChallengeForm">
<input type="hidden" name="type" value="addToChallenge">
<input type="hidden" name="mediaId" value="<?=$currentPhoto["id"]?>">
<input type="hidden" name="challengeId" value="<?=$challenge[ $key ]["id"]?>">




<div style="float: left;  width: 450px;margin-left: 30px; margin-right: 10px; ">


<b><?=stripslashes($challenge[ $key ]["title"])?></b>

<p><?=stripslashes($challenge[ $key ]["description"])?></p>

</div>
<div style="clear:both;"></div>
<div style="float: left;  width: 150px;margin-left: 30px; margin-right: 10px; ">
<?=$avatar?>
</div>
<div style="float: left;  width: 280px;margin-left: 10px; margin-right: 10px; ">

Du kan anmäla obegränsat med bilder till denna tävling.<br><br>
<? if ($already != TRUE) { ?><span onMouseOver="document.addChallengeSubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onMouseOut="document.addChallengeSubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onClick="document.addToChallengeForm.submit();"><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="addChallengeSubmit" style="vertical-align:middle;" border="0">Anmäl bild till tävling</a></nobr></span>
<? } else { ?>
<b>Denna bild är redan anmäld till tävlingen</b><? }?>
</div>

<div style="clear:both;"></div>
<br><br>


</form>

<? }?>
<? } else {?>
<div style="margin: 4px; margin-left: 30px; margin-right: 30px;">Det finns inga aktuella tävlingar som du kan delta i!</div>
<?}?>
</div>
</div>



<div id="popupProfileImage" class="popup" style="display: none">

<div id="divHeadSpace" style="border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;">

	<div style="float: left; display: block"><h3>Ändra profilbild</h3></div>
	<div style="float: right; display: block"><a href="#" onclick="closePopup('popupProfileImage');"><img src="<?=$baseUrl?>/img/kryss_edit.gif" name="closeFriendPopup" border="0" onMouseOver="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit_red.gif'" onMouseOut="document.closeFriendPopup.src='<?=$baseUrl?>/img/kryss_edit.gif'" style="margin: 10px"></a></div>

&nbsp;</div>



<form method="post" enctype="multipart/form-data" style="margin: 4px; margin-left: 30px; margin-right: 30px; padding-bottom: 20px" name="profileImageForm">
<input type="hidden" name="type" value="profileImage">
<div style="float: left; width: 230px; padding-bottom: 20px"><?=$profileAvatar?></div>
<div style="float: left;">
<br><br>
<div style="display: inline; float: left; border:solid 1px #aa567a; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;">
<input type="file" name="image" style="width: 197px; border: 0px"></div>&nbsp;&nbsp;
<span onMouseOver="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onMouseOut="document.addFriendSubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onClick="document.profileImageForm.submit();"><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="addFriendSubmit" style="vertical-align:middle;" border="0">Ladda upp</a></nobr></span>
</form>

</form>
</div>



<?php		
	}
?>

<? if ( $displaySurvey ) { 
	
		$q = "SELECT * FROM fl_polls WHERE active = 'YES' ORDER BY insDate DESC LIMIT 1";
	$currPoll = $DB->CacheGetRow( 3*60, $q, FALSE, TRUE );
	if ((int)$currPoll["id"] > 0) {
		$q = "SELECT * FROM fl_polls_options WHERE pollId = '".(int)$currPoll["id"]."' ORDER BY ID ASC";
		$currPollOptions = $DB->CacheGetAssoc( 3*60, $q, FALSE, TRUE );
		if (count($currPollOptions) > 0) {?>
<div id="surveyBox">
<div style="background:transparent url(<?=$baseUrl?>/img/logo_flator2.gif) no-repeat scroll 0 0; background-position: right bottom;">
<h2>Omr&ouml;stning</h2>
<p><?=$currPoll["description"]?></p>
<h4><?=$currPoll["question"]?></h4><form method="POST" action="<?=$baseUrl?>/" name="surveyForm">
<input name="type" value="survey" type="hidden">
<input name="pollId" value="<?=(int)$currPoll["id"]?>" type="hidden">
<?
	$i = 0;
	while ( list( $key, $value ) = each( $currPollOptions ) )
		{
			
	?>		

<div style="border: 0px none; margin-top:<?($i == 0 ? "10" : "0")?>px;">
<input name="optionId" value="<?=(int)$currPollOptions[ $key ]["id"]?>" selected="" type="radio">&nbsp;&nbsp;<?=$currPollOptions[ $key ]["title"]?></div>
<?
	$i++;
	}
?>
<br><br>
<span onmouseover="document.surveySubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onmouseout="document.surveySubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onclick="document.surveyForm.submit();"><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="surveySubmit" style="vertical-align: middle;" border="0">Skicka svar!</a></nobr></span>
</form>
</div>
</div>
<? 
					$record = array();
					$record["insDate"] = date( "Y-m-d H:i:s" );
					$record["userId"] = (int)$userProfile["id"];
					$record["pollId"] = "1";
					$record["optionId"] = "0";
					$DB->AutoExecute( "fl_polls_answers", $record, 'INSERT');
}
	}
}








 if ( $displayInvitations ) { 
	
?>
<div id="inviteBox">
<div>
<h2>Efterlyser alla sköna tjejer!</h2>
<p>Nu är vi snart 4000 medlemmar men visst finns det flera som vill in i gemenskapen hos oss!<br />Så ta och bjud in dina vänner till flator.se redan idag!</p>
<h4>Bjud in vänner</h4><form method="POST" action="<?=$baseUrl?>" name="inviteBoxForm">
<input name="type" value="inviteBox" type="hidden">

<?
$i2 = 0;
$i = 1;
while ( $i2 < 3) {
echo "<p><label style=\"width:120px;\" for=\"inviteMail".$i."\">E-post till flata ".$i.":</label> <input type=\"text\" id=\"inviteMail".$i."\" name=\"inviteMail".$i."\" value=\"\" /></p>";
$i2++;
$i++;
}
?>
<br /><br />
<span onmouseover="document.inviteBoxSubmit.src='<?=$baseUrl?>/img/symbols/gif_red/skicka.gif'" onmouseout="document.inviteBoxSubmit.src='<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif'"><nobr><a href="#noexist" onclick="document.inviteBoxForm.submit();"><img src="<?=$baseUrl?>/img/symbols/gif_purple/skicka.gif" name="inviteBoxSubmit" style="vertical-align: middle;" border="0">Skicka inbjudningar!</a></nobr></span>
</form><br /><br /><br />
</div>
</div>
<? 


}





?>

