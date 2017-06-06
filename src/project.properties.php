<?php
define("PROJECT_ROOT", __DIR__ .'/');
define("PREFIX","ma03601");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once '/PHP/DependencyInjection/DI.class.php';
require_once '/PHP/Exceptions/JSONException.class.php';
$DI = DI::RegisterTypes();
//$DI->Resolve("PDO")->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$DI->Resolve("PDO")->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);