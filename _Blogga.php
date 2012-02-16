<?php
/*# ----------------------------------------------------------------------------
 
 Version:      1.1.1
 Author:       pouyan maleki

 Script Function:
	           show the information page about blogging, for users who are not registred!
 Licenced  to: Bebetteronline.com
 Date:  	   2012-02-10
# ----------------------------------------------------------------------------*/
$metaTitle = "M&ouml;tesplats och dating f&ouml;r lesbiska - Flator.se.";
$metaDescription="Hos Flator.se har du din egna blogg som du kan skriva om vad du vill i. Bäst av allt, det är bara andra lesbiska som kommer läsa. Bli medlem idag!";

$body = "<div id=\"center\"><div style=\"padding-top: 12px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br> 
<br><br><br></div>";

$body .= "
<img src=\"".$baseUrl."/img/blogg.jpg\" border=\"0\" ><br><br>";

$body .= "
<div style=\"padding-top: 4px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br><span style=\"font-weight:bold; font-size:16px;\">Blogga</span><br><br>En viktig funktion du har tillgång till som medlem är möjligheten att blogga. 
Du har möjligheten att ventilera åsikter och händelser i din vardag inför stängda dörrar och inför en publik som inte på något sätt är dömande eller ifrågasättande.
Som dagbok eller bara som en ventil då och då, det bestämmer du själv!
Bli medlem och skriv ditt första blogginlägg redan idag!
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