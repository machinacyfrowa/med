<?php

$db = new mysqli("localhost", "root", "", "med");

//stary sposób - raczej nie robić
/*
$q = "SELECT * FROM staff";
$result = $db->query($q);
*/

$q = $db->prepare("SELECT * FROM staff");
if($q->execute()) {
    //ta część wywoła się jeśli kwerenda wykona się
    //prawidłowo
    $result = $q->get_result();
    while($row = $result->fetch_assoc()) {
        //każde wywołanie to jeden wiersz gdzie w 
        //$row będą inne dane
        $id = $row['id'];
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        echo "Lekarz $firstName $lastName<br>";
    }
} else {
    //ta część wykona się jeśli kwerenda nie wykona się
    //prawidłowo - np. spowoduje błąd
    die("Błąd pobierania z bazy danych");
}

?>