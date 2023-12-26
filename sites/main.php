<?php
//TODO make the function.php and convert this page to  only functions
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);
session_start();
include_once "functions.php";
$page = "hotel";
$emailexist = false;
$changeInformation=false;
$validPages = ["hotel", "impressum", "F_and_Q", "new_reservation","rooms", "reserved_rooms", "signup", "signin", "userInformation","news","addnews","manage_users","manage_reservations"];
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
            if (in_array($p,["addnews","manage_users","manage_reservations"])){
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
        $benutzerid = get_user();

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
