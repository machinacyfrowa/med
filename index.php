<?php

require_once('./config.php');

//stary sposób - raczej nie robić
/*
$q = "SELECT * FROM staff";
$result = $db->query($q);
*/
//pobierz wszystkich pracowników
$q = $db->prepare("SELECT * FROM staff");
if($q && $q->execute()) {
    //ta część wywoła się jeśli kwerenda wykona się
    //prawidłowo
    $result = $q->get_result();
    $staffList = array();
    while($staff = $result->fetch_assoc()) {
        //każde wywołanie to jeden wiersz gdzie w 
        //$staff będą inne dane
        $staffId = $staff['id'];
        $firstName = $staff['firstName'];
        $lastName = $staff['lastName'];
        //echo "Lekarz $firstName $lastName<br>";
        
        //przygotuj nową kwerendę - pobierz wizyty dla lekarza
        $q = $db->prepare("SELECT * FROM appointment WHERE staff_id = ?");
        //podstaw zmienną do kwerendy
        $q->bind_param("i", $staffId);
        if($q && $q->execute()) {
            //jeśli kwerenda wykona się prawidłowo
            //pobierz dane
            $appointments = $q->get_result();
            $appointmentList = array();
            while($appointment = $appointments->fetch_assoc()) {
                //zapisz id i date z bazy do lokalnych zmiennych
                $appointmentId = $appointment['id'];
                $appointmentDate = $appointment['date'];
                //zamień date z bazy na timestamp 
                $appointmentTimestamp = strtotime($appointmentDate);
                $appointment = array("id"   =>    $appointmentId,
                                     "date" =>    $appointmentDate);
                array_push($appointmentList, $appointment);
                //wyświetl guzik
                //echo "<a href=\"patientLogin.php?id=$appointmentId\" style=\"margin:10px; display:block\">";
                //wyświetl termin w formacie dzień.miesiąc godzina:minuta)
                //echo date("j.m H:i", $appointmentTimestamp);
                //zamknij guzik
                //echo "</a>";
            }
            $staffMember = array(   "firstName"     => $firstName,
                                    "lastName"      => $lastName,
                                    "appointmentList" => $appointmentList);
            array_push($staffList, $staffMember);
            //echo "<br>";
        } else {
            //jeśli nie wykona się prawidłowo
            die("Błąd pobierania wizyt z bazy danych");
        }
    }
    $smarty->assign("staffList", $staffList);
    $smarty->display("index.tpl");
} else {
    //ta część wykona się jeśli kwerenda nie wykona się
    //prawidłowo - np. spowoduje błąd
    die("Błąd pobierania lekarzy z bazy danych");
}

?>