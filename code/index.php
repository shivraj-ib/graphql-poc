<?php 
// Autoload files using the Composer autoloader.
require_once '../vendor/autoload.php';

USE IB\getApi;

//TEST CODE
$entry = new getApi();
echo($entry->test());
