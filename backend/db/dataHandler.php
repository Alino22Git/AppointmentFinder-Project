<?php
include("./models/appointment.php");
class DataHandler
{
    public function queryAppointments()
    {
        $res = $this->getData();
        return $res;
    }

    private static function getData()
    {
        include("dbaccess.php");
        // SQL-Abfrage ausführen
        $sql = "SELECT * FROM termine";
        $result = $conn->query($sql);

        // Überprüfen, ob die Abfrage erfolgreich war
        if ($result->num_rows > 0) {
            // Ergebnisse in ein Array speichern
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        // Verbindung zur Datenbank schließen
        $conn->close();
        return $data;
    }

    public function saveAppointment($data)
    {
        //error_log(var_export($data, true));
        include("dbaccess.php");
        
        // Schleife durch die Daten und füge sie in die Datenbank ein
            $titel = $data[0];
            $ort = $data[1];
            $dauer = $data[2];
            $ablaufdatum = $data[3];
            $beschreibung = $data[4];
            $sql = "INSERT INTO termine (titel, ort, dauer, ablaufdatum, beschreibung) VALUES ('$titel', '$ort', $dauer, '$ablaufdatum', '$beschreibung')";
            if (!mysqli_query($conn, $sql)) {
                echo "Fehler beim Laden der Daten: " . mysqli_error($conn);
            }
        // Verbindung zur Datenbank schließen
        $conn->close();
    }

    public function queryDetailedAppointmentsById($id)
    {
        include("dbaccess.php");
        // SQL-Abfrage ausführen
        $sql = "SELECT * FROM terminoption WHERE terminoption.id_termine = $id";
        $result = $conn->query($sql);

        // Überprüfen, ob die Abfrage erfolgreich war
        if ($result->num_rows > 0) {
            // Ergebnisse in ein Array speichern
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }else{
            $data="Keine Daten";
        }

        // Verbindung zur Datenbank schließen
        $conn->close();
        return $data;
    }
    
    public function queryKommentareById($id)
    {
        include("dbaccess.php");
        // SQL-Abfrage ausführen
        $sql = "SELECT * FROM kommentare WHERE kommentare.id_terminoption = $id";
        $result = $conn->query($sql);

        // Überprüfen, ob die Abfrage erfolgreich war
        if ($result->num_rows > 0) {
            // Ergebnisse in ein Array speichern
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }else{
            $data="Keine Daten";
        }

        // Verbindung zur Datenbank schließen
        $conn->close();
        return $data;
    }

    public function saveOptionAppointment($data)
    {
        //error_log(var_export($data, true));
        include("dbaccess.php");
        
        // Schleife durch die Daten und füge sie in die Datenbank ein
            $von = $data[0];
            $bis = $data[1];
            $vote = $data[2];
            $id_termine = $data[3];
            $sql = "INSERT INTO terminoption (von, bis, vote, id_termine) VALUES ('$von', '$bis', $vote, '$id_termine')";
            if (!mysqli_query($conn, $sql)) {
                echo "Fehler beim Laden der Daten: " . mysqli_error($conn);
            }
        // Verbindung zur Datenbank schließen
        $conn->close();
    }
    public function saveKommentar($data)
    {
        //error_log(var_export($data, true));
        include("dbaccess.php");
        
        // Schleife durch die Daten und füge sie in die Datenbank ein
            $name = $data[0];
            $kommentar = $data[1];
            $teilnahme = $data[2];
            $id_opttermine = $data[3];
            $sql = "INSERT INTO kommentare (name, kommentar, teilnahme, id_terminoption) VALUES ('$name', '$kommentar', $teilnahme, '$id_opttermine')";
            if (!mysqli_query($conn, $sql)) {
                echo "Fehler beim Laden der Daten: " . mysqli_error($conn);
            }
            if($teilnahme==1){
            $sql =  "UPDATE terminoption SET vote = vote + 1 WHERE id = $id_opttermine";
            if (!mysqli_query($conn, $sql)) {
                echo "Fehler beim Laden der Daten: " . mysqli_error($conn);
            }
        }
        // Verbindung zur Datenbank schließen
        $conn->close();
    }
}
/*$demodata = [
//new Appointment(1, "Titel", "Ort", "Dauer", Ablaufdatum, "Beschreibung"),
new Appointment(1, "Festival", "St.Pölten", 6, "10-2-2020", "Sehr cool"),
new Appointment(2, "Konzert", "Wien", 4, "3-10-2021", "Nice!"),
new Appointment(3, "Geburtstag","Im Dorf",2, "3-4-2022", "Sehr Aufregend"),
];*/