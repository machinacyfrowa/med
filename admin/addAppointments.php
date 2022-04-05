<?php
$db = new mysqli("localhost", "root", "", "med");
$q = $db->prepare("SELECT id, firstName, lastName FROM staff");
$q->execute();
$staffResult = $q->get_result();
?>
<form action="addAppointments.php">
    <label for="staffId">Wybierz lekarza:</label>
    <select name="staffId" id="staffId">
        <?php
            while($staffRow = $staffResult->fetch_assoc()) {
                $staffId = $staffRow['id'];
                $staffFirstName = $staffRow['firstName'];
                $staffLastName = $staffRow['lastName'];

                echo "<option value=\"$staffId\">$staffFirstName $staffLastName</option>";
            }
        ?>

    </select>
</form>