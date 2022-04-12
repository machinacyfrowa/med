<?php
require_once("config.php");

//TODO: naprawić - co zrobimy jeśli logujemy się bez wyboru wizyty

if(isset($_REQUEST['id'])) {
    //jesteśmy wtrybie zxapisywania się na wizytę
    //otrzymane z index php po kliknięciu terminu wizyty
    $smarty->assign("appointmentId", $_REQUEST['id']);
}


$smarty->display("patientLogin.tpl")
?>

