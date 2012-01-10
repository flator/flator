<?php
$metaTitle = "Flator.se > Nyhetsbrev";
$numPerPage = 30;

$rights = array( 0 => "Ingen &aring;tkomst",
				 1 => "Nyhetsbrev",
				 2 => "Obekr&auml;ftad",
				 3 => "Medlem",
				 4 => "Moderator",
				 5 => "Fr&aring;ga flatan",
				 6 => "Administrat&ouml;r" );

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$noLogo = TRUE;
	$adminMenu = FALSE;
	$loginUrl = $baseUrl . "/admin_newsletter.html";
	include( "login.php" );
}
else
{

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Nyhetsbrev</h2>
	";

	$body.= "
<p>Välj först ett tidigare nyhetsbrev eller klicka på det vita dokumentet för att skapa ett nytt nyhetsbrev. Välj sedan mottagare och skicka iväg.</p>
	";

	$body.= "
<p><div id=\"leftTutorial\">1.</div>
<div id=\"rightTutorial\"><div id=\"selectTemplate\">";

	if ( (int)$_GET["templateId"] > 0 )
	{
		$row = array();
		$q = "SELECT * FROM fl_templates WHERE templateType = 'newsletter' AND id = " . (int)$_GET["templateId"] . " AND active = 'YES'";
		if ( $row = $DB->GetRow( $q ) )
		{
			$body.= "<a href=\"#\" onClick=\"getContent('select_template.php?target=selectTemplate&type=newsletter&action=select&templateId=" . (int)$_GET["templateId"] . "');\">" . $row["name"] . " - " . $row["insDate"] . "</a> <a href=\"" . $baseUrl . "/admin_newsletter_template.html?templateId=" . $row["id"] . "\" onClick=\"openPopup(this.href,'admin_newsletter_template" . $row["id"] . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera mall\"></a> <a href=\"" . $baseUrl . "/admin_newsletter_template.html?templateId=" . $row["id"] . "\" OnClick=\"if(confirm('Ta bort " . $row["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort mall\"></a> <a href=\"" . $baseUrl . "/admin_newsletter_template.html\" onClick=\"openPopup(this.href,'admin_newsletter_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
		}
		else
		{
			$body.= templateLink( "newsletter" );
		}
	}
	else
	{
		$body.= templateLink( "newsletter" );
	}
	
	$body.= "</div></div></p>";

	if ( (int)$_GET["templateId"] > 0 )
	{
		$body.= "<form method=\"post\" style=\"margin: 0px; padding: 0px\">
<input type=\"hidden\" name=\"templateId\" value=\"" . $_GET["templateId"] . "\" />
<p><div id=\"leftTutorial\">2.</div>
<div id=\"rightTutorial\"><p>Välj mottagare</p>";

		$q = "SELECT * FROM fl_users ORDER BY rights, email ASC";
		$row = $DB->GetAssoc( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			if ( count( $row ) < 20 )
			{
				$body.= "<br /><select name=\"userIds\" multiple size=\"" . count( $row ) . "\" onKeyPress=\"return !(window.event && window.event.keyCode == 13);\">";
			}
			else
			{
				$body.= "<br /><select name=\"userIds\" multiple size=\"20\" onKeyPress=\"return !(window.event && window.event.keyCode == 13);\">";
			}

			while ( list( $key, $value ) = each( $row ) )
			{
				$body.= "	<option value=\"" . $row[ $key ]["id"] . "\">" . $row[ $key ]["email"] . " (" . $rights[ $row[ $key ]["rights"] ] . ")</option>\n";
			}
		}

        
		$body.= "</select>
<p><i>Efter e-postadressen står vilken typ av medlemsskap de har</i></p>

</div></p>
<p><div id=\"leftTutorial\">3.</div><div id=\"rightTutorial\">";

        $body.= '
        
        <script>
            var listener = function(input)
            {
                (function($)
                {
                    $(document).ready(function() {
                        $.fancybox(
                            "<div style=\"line-height:2em;padding-top:20px;font-size:2em;position:absolute;top:0;bottom:0;left:0;right:0;background:#333;color:#fff;text-align:center;\"><span id=\"fancy-inside-success\">0</span> skickade av <span id=\"fancy-inside-of\">?</span><br /><span id=\"fancy-inside-error\">0</span> fel har uppstått</div>",
                            {
                                "autoDimensions"  : false,
                                "width"           : 500,
                                "height"          : 140,
                                "transitionIn"    : "fade",
                                "transitionOut"   : "fade",
                                "overlayOpacity"  : 0.8,
                                "overlayColor"    : "#000"
                            }
                        );
                    });
                })(jQuery);
                
                (function($,input)
                {
                    var aSelected = [];
                    
                    $("form select[name=userIds] :selected").each(
                        function(i, selected)
                        {
                            aSelected.push($(selected).val());
                        });
                        
                    for( var i = 0; i < aSelected.length; )
                    {
                        for( var sSelected = "", n = 0; n < 10 && i < aSelected.length; i++, n++ )
                            sSelected += "," + aSelected[ i ];
                        
                        var tDate       = new Date(),
                            reloadVar   = tDate.getSeconds().toString() + tDate.getMinutes().toString(),
                            url         = "/_xhttp_send_emails.php?target=emailProgress&type=newsletter&templateId=" + input.form.templateId.value + "&userIds=" + sSelected.substring(1,sSelected.length) + "&reloadVar=" + reloadVar;
                        
                        var sendIt = function(url, n)
                        {
                            $.get(
                                url,
                                function(data)
                                {
                                    $("#fancy-inside-success").html(parseInt($("#fancy-inside-success").html()) + n);
                                }
                            ).error(
                                function()
                                {
                                    $("#fancy-inside-error").html(parseInt($("#fancy-inside-error").html()) + n);
                                }
                            );
                        }
                        
                        new sendIt(url, n);
                    }
                    
                    $("#fancy-inside-of").html(i);
                    
                })(jQuery,input);
            }
        </script>
        
        <input type="button" value="Skicka" onClick="listener(this)" />';
        
        $body.= "</div></p></form>

<div id=\"emailProgress\"></div>";

	}

	$body.= "
	</div>
</div>";

}
?>