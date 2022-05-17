<?php
class Staff {
    private $id;
    private $firstName;
    private $lastName;
    private $db;

    function __construct()
    {
        global $db;
        $this->db = $db;
    }

    public function getFirstName() : string {
        return $this->firstName;
    }

    public function getLastName() : string {
        return $this->lastName;
    }

    public function create(int $id) {
        $this->id = $id;
        $this->load();
    }

    public function save() : bool {
        $q = $this->db->prepare("INSERT INTO staff VALUES (NULL, ?, ?)");
        $q->bind_param("ss", $this->firstName, $this->lastName);
        $result = $q->execute();
        
        $this->id = $this->db->insert_id;
        return $result;
    }
    public function load() {
        $q = $this->db->prepare("SELECT * FROM staff WHERE id = ? LIMIT 1");
        $q->bind_param("i", $this->id);
        $q->execute();
        $result = $q->get_result();
        $row = $result->fetch_assoc();
        $this->firstName = $row['firstName'];
        $this->lastName = $row['lastName'];
    }
    /*
    * funkcja zwraca tablicę zawierającą wszystkie wizyty dostępne dla tego członka personelu
    */
    public function getAppointmentsArray() : array {
        $q = $this->db->prepare("SELECT * FROM appointment WHERE staff_id = ?");
        $q->bind_param("i", $this->id);
        if($q && $q->execute()) {
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
            }
            return $appointmentList;
        }
        //zwróć pustą tablicę jeśli coś pójdzie nie tak
        return Array();
    }
}
?>