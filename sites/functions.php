<?php
    // checkt ob die email adresse in Datenbank vorhanden ist bevor ein neues User hinzufügen
    function email_exist(){
        global $emailexist;
        global $db;
        $sql= "SELECT email FROM benutzer where email = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s",$_POST["email"]);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            $emailexist = true;
        }
        else{
            insert_user();
        }
    }
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
    //für die anmeldung vom benutzer
    function login(){
        global $db;
        $sql= "SELECT * FROM benutzer where email = ?";
        $stmt = $db->prepare($sql);
        $email = $_POST["email"];
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            if($row !== null && password_verify($_POST["passwort"],$row["passwort"]) && $row["status"]=="Aktiv"){
                $_SESSION["vorname"]=$row["vorname"];
                $_SESSION["nachname"]=$row["nachname"];
                $_SESSION["username"]=$row["username"];
                $_SESSION["email"]=$row["email"];
                $_SESSION["erstelldatum"]=$row["erstelldatum"];
                $_SESSION["logged"]=true;
                header("Location: ?hotel");
                exit();
            }
        }
    }
    //holt die zimmer id vom Datenbank.
    function get_room($zimmer){
        global $db;
        $sql = "SELECT zimmerid FROM zimmer WHERE name = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s",$zimmer);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $zimmerid = $row["zimmerid"];
        $stmt->close();
        return $zimmerid;
    }
    // holt die benutzer id vom Datenbank.
    function get_user($email){
        global $db;
        $sql = "SELECT benutzerid FROM benutzer WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $email);
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
    //fügt die neue Reservierung in der resvierung tabelle in Datenbank
    function insert_reservation($anreiseDatum, $abreiseDatum,$fruehstueck,$parkplatz,$haustier,$gesamtPreis,$benutzerid,$zimmerid){
        global $db;
        $sql = "INSERT INTO reservierung(anreisedatum,abreisedatum,fruehstuck,parkplatz,haustier,gesamtpreis,benutzerid,zimmerid) VALUES(?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssdddddd",$anreiseDatum, $abreiseDatum,$fruehstueck,$parkplatz,$haustier,$gesamtPreis,$benutzerid,$zimmerid);
        $stmt->execute();
        $stmt->close();
    }
    //ändert die verfügbarkeit vom zimmer
    function change_room_availablity($zimmerid,$zahl){
        global $db;
        $sql="UPDATE zimmer SET verfuegber = verfuegber+$zahl WHERE zimmerid=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i",$zimmerid);
        $stmt->execute();
        $stmt->close();
    }
    // ändert den Status der Reservierung
    function change_status($status,$useremail){
        global $db;
        $d = strtotime($_POST["datum"]);
        $reservierungsdatum = date("Y-m-d H:i:s",$d);
        $sql = "UPDATE reservierung SET status = '$status'  WHERE reservierungsdatum = ?
                AND benutzerid = (SELECT benutzerid from benutzer where email = ?)
                ";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ss",$reservierungsdatum,$useremail);
        $stmt->execute();
        $stmt->close();
    };
    // fuktionen für Admin
    function get_users($search){
        global $db;
        $sql = "SELECT * FROM benutzer where email LIKE CONCAT('%', ?, '%') AND NOT email = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ss",$search,$_SESSION['email']);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result;
    }
    function change_user_status($status){
        global $db;
        $sql = "UPDATE benutzer set status = '$status' WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s",$_POST['email']);
        $stmt->execute();
        $stmt->close();
    }
    function get_reservations($user,$status){
        global $db;
        $sql = "SELECT benutzer.email,anreisedatum,abreisedatum,fruehstuck,parkplatz,haustier,gesamtpreis,reservierung.status,date(reservierungsdatum),reservierungsdatum,zimmer.name 
                FROM reservierung JOIN benutzer
                USING(benutzerid)
                JOIN zimmer
                USING(zimmerid)
                WHERE benutzer.email LIKE CONCAT('%', ?, '%') AND reservierung.status LIKE CONCAT('%', ?, '%')";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ss",$user,$status);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result;
    }

?>
