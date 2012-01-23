<?php

if ($_SERVER["DOCUMENT_ROOT"] == "/var/www/dev.flator.se"){
define("LOCALHOST", "localhost");
define("ROOT", "root");
define("PASS", "sx53gmQ9");
define("TABELS", "flator_dev");

}else{
define("LOCALHOST", "localhost");
define("ROOT", "root");
define("PASS", "sx53gmQ9");
define("TABELS", "flator");
}
?>