<?php

//echo $_SERVER["DOCUMENT_ROOT"];
if ($_SERVER["DOCUMENT_ROOT"] == "/var/www/dev.flator.se"){
define("LOCALHOST", "localhost");
define("ROOT", "root");
define("PASS", "sx53gmQ9");
define("TABELS", "flator_dev");
echo "rätt databas";
}else{
define("LOCALHOST", "localhost");
define("ROOT", "root");
define("PASS", "sx53gmQ9");
define("TABELS", "flator");
}
?>