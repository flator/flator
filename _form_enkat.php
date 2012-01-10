<?php

$uid = $_SESSION[ 'userId' ] ? (int)$_SESSION[ 'userId' ] : -1;
    
if( isset( $_POST[ 'enkat' ] ))
{
    $q  = "INSERT INTO fl_enkat (uid, content, other_content, found, other_found, _time, other_time, _continue, value, functions, other, ip) VALUES ("
        . $uid
        . ",'"
        . mysql_real_escape_string( $_POST[ 'content' ] )
        . "','"
        . mysql_real_escape_string( $_POST[ 'other_content' ] )
        . "','"
        . mysql_real_escape_string( $_POST[ 'found' ] )
        . "','"
        . mysql_real_escape_string( $_POST[ 'other_found' ] )
        . "','"
        . mysql_real_escape_string( implode( ',', $_POST[ 'time' ] ))
        . "','"
        . mysql_real_escape_string( $_POST[ 'other_time' ] )
        . "','"
        . mysql_real_escape_string( $_POST[ 'continue' ] )
        . "','"
        . mysql_real_escape_string( $_POST[ 'value' ] )
        . "','"
        . mysql_real_escape_string( $_POST[ 'functions' ] )
        . "','"
        . mysql_real_escape_string( $_POST[ 'other' ] )
        . "','"
        . mysql_real_escape_string( $_SERVER[ 'REMOTE_ADDR' ] )
        . "')";
    
    $DB->Execute( $q );
}

?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        
        <meta name='robots' content='noindex,nofollow' />
        
        <title>Formulär</title>
        
        <style>
            *
            {
                margin:
                    0;
                    
                padding:
                    0;
                    
                font:
                    12px
                    arial, Arial, san-serif;
                    
                color:
                    #333;
            }
            
            ul
            {
                list-style:
                    none;
            }
            
            li
            {
                margin:
                    5px
                    0
                    5px
                    15px;
            }
            
            p
            { 
                font-weight:
                    bold;
                    
                line-height:
                    2em;
            }
            
            em
            {
                font-weight:
                    normal;
            }
            
            em,
            em *
            {
                display:
                    inline;
                    
                font-style:
                    italic;
                    
                font-size:
                    11px;
            }
            
            strong,
            strong *
            {
                display:
                    inline;
                    
                font-weight:
                    bold;
            }
            
            form
            {
                width:
                    450px;
            }
            
            input.txt
            {
                width:
                    448px;
            }
            
            textarea
            {
                width:
                    438px;
                    
                height:
                    290px;
                    
                padding:
                    5px;
            }
            
            .submit
            {
                width:
                    100px;
                    
                font-weight:
                    bold;
                    
                cursor:
                    pointer;
            }
            
            textarea,
            .submit,
            input.txt
            {
                border:
                    1px
                    solid
                    #ddd;
                    
                background:
                    #f5f5f5;
                    
                line-height:
                    2em;
            }
            
            .submit:hover
            {
                background:
                    #ddd;
                    
                border-color:
                    #bbb;
            }
            
            .description
            {
                border-bottom:
                    2px
                    dotted
                    #ddd;
            }
            
            div,
            .description p
            {
                margin-bottom:
                    20px;
            }
            
            .description p
            {
                font-weight:
                    normal;
            }
            
            h1
            {
                font-size:
                    13px;
                    
                font-weight:
                    bold;
                    
                margin-bottom:
                    5px;
            }
            
            a
            {
                text-decoration:
                    none;
                    
                font-weight:
                    bold;
                    
                color:
                    #aa567a;
            }
            
            a:hover
            {
                color:
                    #e54f35;
            }
        </style>
    </head>
    
    <body>
        <?php if( isset( $_POST[ 'enkat' ] )): ?>
            <h1>
                Tack för ditt medverkande
            </h1>
                
            <p>
                Vi uppskattar att du tog dig tid att svara på enkäten.<br />
                Du kan följa utvecklingsarbetet i forumet under kategorin <a target="_parent" href="http://www.flator.se/forum/communityn.html">Communityn - Flator.se</a>
            </p>
        <?php else: ?>
            <form  action="<?php echo $_SERVER[ 'REQUEST_URI' ]; ?>" method="post">
                <input type="hidden" name="enkat" value="foobar" />
            
                <div class="description">
                    <h1>
                        Nu tar vi nya friska tag - tillsammans bestämmer vi fortsättningen
                    </h1>
                    
                    <p>
                        Hjälp till att utveckla vårt community genom att besvara frågorna nedan, det tar inte lång tid och är oerhört värdefullt för oss alla.<br />
                        <?php if( $uid >= 0 ) : ?>
                        <em>
                            <strong>OBS!</strong> Om du redan svarat på enkäten, eller inte vill svara, så kan du skicka in formulären blank för att slippa få upp denna rutan igen.
                        </em>
                        <?php endif; ?>
                    </p>
                </div>
                
                <div>
                    <p>
                        Vad för typ av innehåll vill du se mer och läsa mer om hos flator.se?
                    </p>
                    
                    <ul>
                        <li>
                            <input type="radio" name="content" value="artiklar" /> Artiklar
                        </li>
                        
                        <li>
                            <input type="radio" name="content" value="bilder" /> Bilder
                        </li>
                        
                        <li>
                            <input type="radio" name="content" value="film" /> Film
                        </li>
                        
                        <li>
                            <input type="radio" name="content" value="other" /> Något annat
                        </li>
                    </ul>
                    
                    <p>
                        <em>
                            Om du kryssa i "Något annat" så skriv gärna vad:
                        </em>
                    </p>
                    
                    <input type="text" name="other_content" class="txt" />
                </div>
                
                <div>
                    <p>
                        Hur hittade du till flator.se?
                    </p>
                    
                    <ul>
                        <li>
                            <input type="radio" name="found" value="kompis" /> Kompis
                        </li>
                        
                        <li>
                            <input type="radio" name="found" value="sökning" /> Sökning
                        </li>
                        
                        <li>
                            <input type="radio" name="found" value="hemsida" /> Hemsida
                        </li>
                        
                        <li>
                            <input type="radio" name="found" value="blog" /> Blog
                        </li>
                        
                        <li>
                            <input type="radio" name="found" value="tidning" /> Tidning
                        </li>
                        
                        <li>
                            <input type="radio" name="found" value="other" /> På ett annat vis
                        </li>
                    </ul>
                    
                    <p>
                        <em>
                            Om du kryssa i "På ett annat vis" så berätta gärna på vilket sätt:
                        </em>
                    </p>
                    
                    <input type="text" name="other_found" class="txt" />
                </div>
                
                <div>
                    <p>
                        Varför spenderar du tid på flator.se?
                    </p>
                    
                    <ul>
                        <li>
                            <input type="checkbox" name="time[]" value="diskutera" /> Diskutera
                        </li>
                        
                        <li>
                            <input type="checkbox" name="time[]" value="chatta" /> Chatta
                        </li>
                        
                        <li>
                            <input type="checkbox" name="time[]" value="sex" /> Sex
                        </li>
                        
                        <li>
                            <input type="checkbox" name="time[]" value="flirta" /> Flirta
                        </li>
                        
                        <li>
                            <input type="checkbox" name="time[]" value="smygtitta" /> Smygtitta
                        </li>
                        
                        <li>
                            <input type="checkbox" name="time[]" value="förhållande" /> Förhållande
                        </li>
                        
                        <li>
                            <input type="checkbox" name="time[]" value="vänskap" /> Vänskap
                        </li>
                        
                        <li>
                            <input type="checkbox" name="time[]" value="other" /> Av en annan anledning
                        </li>
                    </ul>
                    
                    <p>
                        <em>
                            Om du kryssa i "Av en annan anledning" så berätta gärna av vilken anledning du spenderar tid på denna webbplatsen:
                        </em>
                    </p>
                    
                    <input type="text" name="other_time" class="txt" />
                </div>
                
                <div>
                    <p>
                        Om vi skulle tvingas ta ut en månatlig avgift för att fortsatt kunna driva flator.se, skulle du då vilja fortsätta utnyttja webbplatsen?
                    </p>
                    
                    <ul>
                        <li>
                            <input type="radio" name="continue" value="js" /> Ja
                        </li>
                        
                        <li>
                            <input type="radio" name="continue" value="nej" /> Nej
                        </li>
                        
                        <li>
                            <input type="radio" name="continue" value="dont_know" /> Vet ej
                        </li>
                    </ul>
                </div>
                
                <div>
                    <p>
                        Vad är det värt för dig att fortsätta använda flator.se?
                    </p>
                    
                    <ul>
                        <li>
                            <input type="radio" name="value" value="399" /> 399 per mån
                        </li>
                        
                        <li>
                            <input type="radio" name="value" value="299" /> 299 per mån
                        </li>
                        
                        <li>
                            <input type="radio" name="value" value="199" /> 199 per mån
                        </li>
                        
                        <li>
                            <input type="radio" name="value" value="99" /> 99 kr per mån
                        </li>
                        
                        <li>
                            <input type="radio" name="value" value="49" /> 49 kr per mån
                        </li>
                        
                        <li>
                            <input type="radio" name="value" value="0" /> 0 kr per mån
                        </li>
                    </ul>
                </div>
                
                <div>
                    <p>
                        Vad för ytterligare funktionalitet skulle du mer vilja se på flator.se?
                    </p>
                    
                    <textarea name="functions"></textarea>
                </div>
                
                <div>
                    <p>
                        Skriv gärna fler synpunkter som du har här nedan!
                    </p>
                    
                    <textarea name="other"></textarea>
                </div>
                
                <input type="submit" name="submit" class="submit" value="Skicka" />
            </form>
        <?php endif; ?>
    </body>
</html>

<?php exit; ?>