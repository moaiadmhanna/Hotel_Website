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
    };
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
    // ändert den Status der Reservierung
    function change_status($status){
        global $db;
         $d = strtotime($_POST["datum"]);
        $reservierungsdatum = date("Y-m-d H:i:s",$d);
        $sql = "UPDATE reservierung SET status = $status  WHERE reservierungsdatum = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s",$reservierungsdatum);
        $stmt->execute();
        $stmt->close();
    };

?>
