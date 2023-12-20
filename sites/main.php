<?php
//TODO make the function.php and convert this page to  only functions
session_start();
include_once "functions.php";
$page = "hotel";
$emailexist = false;
$changeInformation=false;
$validPages = ["hotel", "impressum", "F_and_Q", "new_reservation","rooms", "reserved_rooms", "signup", "signin", "userInformation","news","addnews"];
foreach ($validPages as $p) {
    if (isset($_GET[$p])) {
        if (isset($_SESSION["logged"]) && $_SESSION["logged"]==true) {
            if ($p == "addphoto" && $_SESSION["email"] == "admin@gmail.com") {
                $page = $p;
                break;
            }
            else if($p == "new_reservation"){
                $_SESSION["zimmer"] = $_GET[$p];
            }
        } else {
            if (in_array($p, ["hotel", "impressum", "F_and_Q", "signup", "signin", "news"])) {
                $page = $p;
            } else {
                header("Location: ?signin");
            }
            break;
        }

        $page = $p;
        break;
    }
}

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: ?hotel");
    exit();
} 
//TODO changeinformation should change   
if(isset($_GET["changeInformation"])){
    $changeInformation=true;
    $page="userInformation";
}
if(isset($_POST["changeInformation"])){
    $newEmail = $_POST["email"];
    foreach($signdata as $key =>$user){
        if($user["email"]==$newEmail&&$user["email"]!== $_SESSION["email"]){
            $emailexist = true;
            break;
        }
        if($user["email"]==$_SESSION["email"]){
            $signdata[$key]["vorname"] = $_POST["vorname"];
            $signdata[$key]["nachname"] = $_POST["nachname"];
            $signdata[$key]["username"] = $_POST["username"];
            $signdata[$key]["email"] = $_POST["email"];
            $signdata[$key]["password"] = password_hash($_POST["password"].$signdata[$key]["salt"],PASSWORD_DEFAULT);

            $_SESSION["vorname"] = $signdata[$key]["vorname"];
            $_SESSION["nachname"] = $signdata[$key]["nachname"];
            $_SESSION["username"] = $signdata[$key]["username"];
            $_SESSION["email"] = $signdata[$key]["email"];
            break;
        }
    }
    $newJsonString = json_encode($signdata,JSON_PRETTY_PRINT);
    file_put_contents($signinJsonFile, $newJsonString);
    $changeInformation=false;
    $page="userInformation";
}
if(isset($_POST["signup"])){
    if(!empty($_POST["vorname"])&&!empty($_POST["nachname"])&&!empty($_POST["username"])&&!empty($_POST["email"])&&!empty($_POST["passwort"])&&!empty($_POST["confirmpasswort"])&&$_POST["confirmpasswort"]==$_POST["passwort"]){
        $sql= "SELECT email FROM benutzer";
        $resualt = $db->query($sql);
        while($row = $resualt->fetch_assoc()){
            if($_POST["email"] == $row["email"]){
                $emailexist = true;
                break;
            }
        }
        if(!$emailexist){
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
            header("q");
            
        }
    }
}

if(isset($_POST["login"])){
    $sql= "SELECT * FROM benutzer";
    $resualt = $db->query($sql);
    while($row = $resualt->fetch_assoc()){
        if($_POST["email"] == $row["email"] && password_verify($_POST["passwort"],$row["passwort"])){
            $_SESSION["vorname"]=$row["vorname"];
            $_SESSION["nachname"]=$row["nachname"];
            $_SESSION["username"]=$row["username"];
            $_SESSION["email"]=$row["email"];
            $_SESSION["logged"]=true;
            header("Location: ?hotel");
            break;
        }
        else{
            $signInFalse=true;
        }
    }
}
if(isset($_POST["newReservation"])){
    if(isset($_POST["zimmer"])&&isset($_POST["anreiseDatum"])&&isset($_POST["abreiseDatum"])&&$_POST["abreiseDatum"]>$_POST["anreiseDatum"]){
        // um die Benutzerid vom Datenbank holen:
        $benutzerid = get_user();

        //um die Zimmerid vom Datenbank zu holen:
        $sql = "SELECT zimmerid FROM zimmer WHERE name = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s",$_POST['zimmer']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $zimmerid = $row["zimmerid"];
        $stmt->close();

        // jetzt wird alle eingaben vom benutzer in der tabelle Reservierung hinzufügt:
        $anreiseDatum = new DateTime($_POST["anreiseDatum"]);
        $abreiseDatum = new DateTime($_POST["abreiseDatum"]);
        $fruehstueck = isset($_POST["fruehstueck"])&&$_POST["fruehstueck"] == "on" ? 1:0;
        $parkplatz = isset($_POST["parkplatz"])&&$_POST["parkplatz"] == "on" ? 1:0;
        $haustier = isset($_POST["haustier"])&&$_POST["haustier"] == "on" ? 1:0;
        $gesamtPreis =0;
        // hier werden die Preise berechnet und in eine Variable gespeichert:
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
        //jetzt werden alle daten in datenbank gespeichert
        // die an und ab reise datum müssen in string umgewandelt werden
        $anreiseDatum = $anreiseDatum->format("Y-m-d");
        $abreiseDatum = $abreiseDatum->format("Y-m-d");
        $sql = "INSERT INTO reservierung(anreisedatum,abreisedatum,fruehstuck,parkplatz,haustier,gesamtpreis,benutzerid,zimmerid) VALUES(?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssdddddd",$anreiseDatum, $abreiseDatum,$fruehstueck,$parkplatz,$haustier,$gesamtPreis,$benutzerid,$zimmerid);
        $stmt->execute();
        $stmt->close();

        // um die verfüguberkeit des zimmers zu verringern
        $sql="UPDATE zimmer SET verfuegber = verfuegber-1 WHERE zimmerid=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i",$zimmerid);
        $stmt->execute();
        $_SESSION["zimmer"] = $_POST["zimmer"];
    }
};
?>