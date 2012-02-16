<?php
/*# ----------------------------------------------------------------------------
 
 Version:      1.1.1
 Author:       pouyan maleki

 Script Function:
	           show the information page about forums, for users who are not registred!
 Licenced  to: Bebetteronline.com
 Date:  	   2012-02-10
# ----------------------------------------------------------------------------*/
$metaTitle = "M&ouml;tesplats och dating f&ouml;r lesbiska - Flator.se.";
$metaDescription="En av de stora behållningarna med att vara medlem på Flator.se är våra sprudlande forum. Bli medlem idag och börja diskutera.";

$body = "<div id=\"center\"><div style=\"padding-top: 12px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br> 
<br><br><br></div>";

$body .= "
<img src=\"".$baseUrl."/img/forum.jpg\" border=\"0\" ><br><br>";

$body .= "
<div style=\"padding-top: 4px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br><span style=\"font-weight:bold; font-size:16px;\">Diskutera på forumet</span><br><br>En av de stora behållningarna med att vara medlem på Flator.se är våra sprudlande forum. Här har du möjligheten att diskutera högt som lågt utan att någon dömer eller ifrågasätter.
I vårt forum kan du bland annat diskutera, adoption, arbete och studier, böcker, film, foto, kärlek och samhälle. Många fler områden väntar för dig som blir medlem.
Vad väntar du då? Ge dig in i debatten!
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