<?php
    // holt die benutzer id vom Datenbank.
    function get_user(){
        $sql = "SELECT benutzerid FROM benutzer WHERE email = ?";
        global $db;
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $_SESSION['email']);
        $stmt->execute();
        $result=$stmt->get_result();
        $row = $result->fetch_assoc();
        $benutzerid = $row["benutzerid"];
        $stmt->close();
        return $benutzerid;
    };
    function change_status($status){
         $d = strtotime($_POST["datum"]);
        $reservierungsdatum = date("Y-m-d H:i:s",$d);
        $sql = "UPDATE reservierung SET status = $status  WHERE reservierungsdatum = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s",$reservierungsdatum);
        $stmt->execute();
        $stmt->close();
    };

?>
