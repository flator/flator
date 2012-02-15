<?php
$metaTitle = "M&ouml;tesplats och dating f&ouml;r lesbiska - Flator.se.";
$metaDescription="En bild säger mer än 1000 ord och det stämmer även på Flator.se. Här finns möjligheten att dela bilder och filmklipp för alla att titta på.";

$body = "<div id=\"center\"><div style=\"padding-top: 12px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br> 
<br><br><br></div>";

$body .= "
<img src=\"".$baseUrl."/img/bilder.jpg\" border=\"0\" ><br><br>";

$body .= "
<div style=\"padding-top: 4px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br><span style=\"font-weight:bold; font-size:16px;\">Videochat</span><br><br>Varit på underbar semester och har kameran full med bilder?
En bild säger mer än 1000 ord och det stämmer även på Flator.se. Här finns möjligheten att dela bilder och filmklipp för alla att titta på.
Bli medlem nu och ladda upp dina bästa bilder redan idag! 
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