<?php
require_once('./model/Patient.class.php');
require_once('./model/Staff.class.php');
require('./vendor/autoload.php');

$db = new mysqli("localhost", "root", "", "med");
$smarty = new Smarty();
$router = new Bramus\Router\Router();

$smarty->setTemplateDir('./smarty/templates');
$smarty->setCompileDir('./smarty/templates_c');
$smarty->setCacheDir('./smarty/cache');
$smarty->setConfigDir('./smarty/configs');

?>