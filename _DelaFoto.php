<?php
$metaTitle = "M&ouml;tesplats och dating f&ouml;r lesbiska - Flator.se.";
$metaDescription="En bild s�ger mer �n 1000 ord och det st�mmer �ven p� Flator.se. H�r finns m�jligheten att dela bilder och filmklipp f�r alla att titta p�.";

$body = "<div id=\"center\"><div style=\"padding-top: 12px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br> 
<br><br><br></div>";

$body .= "
<img src=\"".$baseUrl."/img/bilder.jpg\" border=\"0\" ><br><br>";

$body .= "
<div style=\"padding-top: 4px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br><span style=\"font-weight:bold; font-size:16px;\">Videochat</span><br><br>Varit p� underbar semester och har kameran full med bilder?
En bild s�ger mer �n 1000 ord och det st�mmer �ven p� Flator.se. H�r finns m�jligheten att dela bilder och filmklipp f�r alla att titta p�.
Bli medlem nu och ladda upp dina b�sta bilder redan idag! 
<br><br></div>

<div style=\"padding-top: 4px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\">
<br><span style=\"font-weight:bold;\">Bli medlem</span>
<br> Skapa konto h�r! <a href=\"".$baseUrl."/register.html\">Registering</a><br>
<br><span style=\"font-weight:bold;\">Kontakt</span>
<br>Sajten �gs av <a href=\"http://www.tigerlilly.se\">TigerLilly Interactive AB</a><br>
<a href=\"mailto:info@flator.se\">info@flator.se</a>, <a href=\"mailto:info@tigerlilly.se\">info@tigerlilly.se</a>  
 
</div>
</div><div id=\"right\">";

$body.= "<div style=\"padding-top: 12px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br><br> 
<br><br></div>";
$body.=rightMenu('index');

//Meddelande f�r ej tillg�nglig site
//$body .= "<p><b>Siten �r nere f�r underh�ll<br />Ber�knas vara tillbaka imorgon 09:00</b></p>"; 
$body.= "</div>";
?>