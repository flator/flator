<?php
/*# ----------------------------------------------------------------------------
 
 Version:      1.1.1
 Author:       pouyan maleki

 Script Function:
	           show the information page about party events, for users who are not registred!
 Licenced  to: Bebetteronline.com
 Date:  	   2012-02-10
# ----------------------------------------------------------------------------*/
$metaTitle = "M&ouml;tesplats och dating f&ouml;r lesbiska - Flator.se.";
$metaDescription="Flator.se försöker så långt det går samla alla bilder från roliga event över hela Sverige. Bli medlem och se om du finns med på någon bild!";

$body = "<div id=\"center\"><div style=\"padding-top: 12px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br> 
<br><br><br></div>";

$body .= "
<img src=\"".$baseUrl."/img/fest.jpg\" border=\"0\" ><br><br>";

$body .= "
<div style=\"padding-top: 4px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br><span style=\"font-weight:bold; font-size:16px;\">Festbilder</span><br><br>Varit på något av alla de event du hittar i vår eventkalender? Kanske har du också fastnad på bild?
Som medlem så kan du titta på många bilder från många av de eventen som arrangeras runt om i Sverige.
Spana in våra festbilder genom att bli medlem reda idag!
<br><br></div>

<div style=\"padding-top: 4px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\">
<br><span style=\"font-weight:bold;\">Bli medlem</span>
<br> Skapa konto här! <a href=\"".$baseUrl."/register.html\">Registering</a><br>
<br><span style=\"font-weight:bold;\">Kontakt</span>
<br>Sajten ägs av <a href=\"http://www.tigerlilly.se\">TigerLilly Interactive AB</a><br>
<a href=\"mailto:info@flator.se\">info@flator.se</a>, <a href=\"mailto:info@tigerlilly.se\">info@tigerlilly.se</a>  
 
</div>
</div><div id=\"right\">";

$body.= "<div style=\"padding-top: 12px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br><br> 
<br><br></div>";
$body.=rightMenu('index');

//Meddelande för ej tillgänglig site
//$body .= "<p><b>Siten är nere för underhåll<br />Beräknas vara tillbaka imorgon 09:00</b></p>"; 
$body.= "</div>";
?>