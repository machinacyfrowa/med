<?php

require_once('./config.php');

$router->get('/', function() {
    echo "Strona główna";
});

$router->get('/appointments', function() {
    global $db;
    global $smarty;
    $q = $db->prepare("SELECT id FROM staff");
    if($q && $q->execute()) {
        $result = $q->get_result();
        $staffList = Array();
        while($row = $result->fetch_assoc()) {
            $staff = new Staff();
            $staff->create($row["id"]);
            array_push($staffList, $staff);
            //var_dump($staff->getAppointmentsArray());
        }
    
        $smarty->assign("staffList", $staffList);
        $smarty->display("index.tpl");
    } else {
        //ta część wykona się jeśli kwerenda nie wykona się
        //prawidłowo - np. spowoduje błąd
        die("Błąd pobierania lekarzy z bazy danych");
    }
});


$router->run();



?>