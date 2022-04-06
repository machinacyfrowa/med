<?php
//połączenie do bazy danych
$db = new mysqli("localhost", "root", "", "med");
//załaduj moduły zainstalowne z composera
require_once("./vendor/autoload.php");
//załaduj smarty
$smarty = new Smarty();
//konfiguracja smarty
$smarty->setTemplateDir('./templates');
$smarty->setCompileDir('./templates_c');
$smarty->setCacheDir('./cache');
$smarty->setConfigDir('./configs');



?>