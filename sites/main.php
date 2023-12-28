<?php
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);
session_start();
include_once "functions.php";
$page = "hotel";
$emailexist = false;
$changeInformation=false;
$validPages = ["hotel", "impressum", "F_and_Q", "new_reservation","rooms", "reserved_rooms", "signup", "signin", "userInformation","news","editnews","manage_users","manage_reservations"];
foreach ($validPages as $p) {
    if (isset($_GET[$p])) {
        if($p !== "manage_users"){
            unset($_SESSION['search']);
        }
        if($p !== "manage_reservations"){
            unset($_SESSION['searchUser']);
            unset($_SESSION['searchStatus']);
        }
        if (isset($_SESSION["logged"]) && $_SESSION["logged"]==true) {
            if (in_array($p,["editnews","manage_users","manage_reservations"])){
                if($_SESSION["email"] == "admin@gmail.com"){
                    $page = $p;
                }
                else{
                    header("Location: ?hotel");
                    exit();
                }
                break;
            }
            else if($p == "new_reservation"){
                $page = $p;
                $_SESSION["zimmer"] = $_GET[$p];
            }
            else{
                $page = $p;
            }
            break;
        } else {
            if (in_array($p, ["hotel", "impressum", "F_and_Q", "signup", "signin", "news"])) {
                $page = $p;
            } else {
                header("Location: ?signin");
                exit();
            }
            break;
        }
    }
}

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: ?hotel");
    exit();
} 
if(isset($_POST["signup"])){
    if(!empty($_POST["vorname"])&&!empty($_POST["nachname"])&&!empty($_POST["username"])&&!empty($_POST["email"])&&!empty($_POST["passwort"])&&!empty($_POST["confirmpasswort"])&&$_POST["confirmpasswort"]==$_POST["passwort"]){
        email_exist();
    }
}

if(isset($_POST["login"])){
    if(!login()){
        $signInFalse=true;
    }
}
if(isset($_POST["newReservation"])){
    if(isset($_POST["zimmer"])&&isset($_POST["anreiseDatum"])&&isset($_POST["abreiseDatum"])&&$_POST["abreiseDatum"]>$_POST["anreiseDatum"]){
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        // um die Benutzerid vom Datenbank holen:
        $benutzerid = get_user($_SESSION['email']);

        //um die Zimmerid vom Datenbank zu holen:
        $zimmerid = get_room($_POST["zimmer"]);

        // jetzt wird alle eingaben vom benutzer in der tabelle Reservierung hinzufügt:
        $anreiseDatum = new DateTime($_POST["anreiseDatum"]);
        $abreiseDatum = new DateTime($_POST["abreiseDatum"]);
        $fruehstueck = isset($_POST["fruehstueck"])&&$_POST["fruehstueck"] == "on" ? 1:0;
        $parkplatz = isset($_POST["parkplatz"])&&$_POST["parkplatz"] == "on" ? 1:0;
        $haustier = isset($_POST["haustier"])&&$_POST["haustier"] == "on" ? 1:0;
        $gesamtPreis = calclute_price($anreiseDatum,$abreiseDatum,$fruehstueck,$parkplatz,$haustier);

        // die an und ab reise datum müssen in string umgewandelt werden
        $anreiseDatum = $anreiseDatum->format("Y-m-d");
        $abreiseDatum = $abreiseDatum->format("Y-m-d");

        insert_reservation($anreiseDatum, $abreiseDatum,$fruehstueck,$parkplatz,$haustier,$gesamtPreis,$benutzerid,$zimmerid);
        // um die verfüguberkeit des zimmers zu verringern
        change_room_availablity($zimmerid,-1);
        $_SESSION["zimmer"] = $_POST["zimmer"];
    }
};
?>
