<?php
ini_set('display_errors','On');
error_reporting( 8 );
session_start();
if (!isset($_SESSION['hello'])) $_SESSION['hello']=1;
else $_SESSION['hello']++;
die("Visited {$_SESSION['hello']} times.");
?>