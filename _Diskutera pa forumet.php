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
$metaDescription="En av de stora beh�llningarna med att vara medlem p� Flator.se �r v�ra sprudlande forum. Bli medlem idag och b�rja diskutera.";

$body = "<div id=\"center\"><div style=\"padding-top: 12px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br> 
<br><br><br></div>";

$body .= "
<img src=\"".$baseUrl."/img/forum.jpg\" border=\"0\" ><br><br>";

$body .= "
<div style=\"padding-top: 4px; border-top: 1px dotted #c8c8c8;padding-bottom:4px;\"><br><span style=\"font-weight:bold; font-size:16px;\">Diskutera p� forumet</span><br><br>En av de stora beh�llningarna med att vara medlem p� Flator.se �r v�ra sprudlande forum. H�r har du m�jligheten att diskutera h�gt som l�gt utan att n�gon d�mer eller ifr�gas�tter.
I v�rt forum kan du bland annat diskutera, adoption, arbete och studier, b�cker, film, foto, k�rlek och samh�lle. M�nga fler omr�den v�ntar f�r dig som blir medlem.
Vad v�ntar du d�? Ge dig in i debatten!
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