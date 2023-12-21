<?php
    // fügt ein neues User in der Datenbank
    function insert_user(){
        global $db;
        $sql = "INSERT INTO benutzer(anrede,username,vorname,nachname,email,passwort) VALUES (?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $anrede = $_POST["anrede"];
        $vorname = $_POST["vorname"];
        $nachname  = $_POST["nachname"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $rawpasswort = $_POST["passwort"];
        $hashedpasswort = password_hash($rawpasswort, PASSWORD_DEFAULT);
        $stmt->bind_param("ssssss",$anrede,$username,$vorname,$nachname,$email,$hashedpasswort);
        $stmt->execute();
        $stmt->close();
    };
    //holt die zimmer id vom Datenbank.
    function get_room(){
        global $db;
        $sql = "SELECT zimmerid FROM zimmer WHERE name = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s",$_POST['zimmer']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $zimmerid = $row["zimmerid"];
        $stmt->close();
        return $zimmerid;
    }
    // holt die benutzer id vom Datenbank.
    function get_user(){
        global $db;
        $sql = "SELECT benutzerid FROM benutzer WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $_SESSION['email']);
        $stmt->execute();
        $result=$stmt->get_result();
        $row = $result->fetch_assoc();
        $benutzerid = $row["benutzerid"];
        $stmt->close();
        return $benutzerid;
    };
    //rechnet den gesamten Preis 
    function calclute_price($anreiseDatum,$abreiseDatum,$fruehstueck,$parkplatz,$haustier){
        global $db;
        $sql = "SELECT * From zimmer";
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) {
            if ($row["name"] == $_POST["zimmer"]) {
                $preisProTag = $row["preis"];
                $interval = $abreiseDatum->diff($anreiseDatum);
                $gebuchteTage = $interval->format('%a');
                $gesamtPreis = ($gebuchteTage * $preisProTag)+($fruehstueck*$gebuchteTage*50)+($parkplatz*$gebuchteTage*30)+($haustier*$gebuchteTage*10);
                break;
            }
        };
        return $gesamtPreis;
    }
    //fügt die neue Reservierung in der resvierung tabelle
    function insert_reservation($anreiseDatum, $abreiseDatum,$fruehstueck,$parkplatz,$haustier,$gesamtPreis,$benutzerid,$zimmerid){
        global $db;
        $sql = "INSERT INTO reservierung(anreisedatum,abreisedatum,fruehstuck,parkplatz,haustier,gesamtpreis,benutzerid,zimmerid) VALUES(?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssdddddd",$anreiseDatum, $abreiseDatum,$fruehstueck,$parkplatz,$haustier,$gesamtPreis,$benutzerid,$zimmerid);
        $stmt->execute();
        $stmt->close();
    }
    //ändert die verfügbarkeit vom zimmer
    function change_room_availablity($zimmerid){
        global $db;
        $sql="UPDATE zimmer SET verfuegber = verfuegber-1 WHERE zimmerid=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i",$zimmerid);
        $stmt->execute();
        $_SESSION["zimmer"] = $_POST["zimmer"];
        $stmt->close();
    }
    // ändert den Status der Reservierung
    function change_status($status){
        global $db;
        $d = strtotime($_POST["datum"]);
        $reservierungsdatum = date("Y-m-d H:i:s",$d);
        $sql = "UPDATE reservierung SET status = '$status'  WHERE reservierungsdatum = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s",$reservierungsdatum);
        $stmt->execute();
        $stmt->close();
    };

?>
