<?php
session_start();
$page = "hotel";
$roomsFile='data/rooms.json';
$newsFile='data/news.json';
$reservationJsonFile = 'data/reservations.json';
$reservationdata= file_exists($reservationJsonFile) ? json_decode(file_get_contents($reservationJsonFile), true) : array();
$roomsData=file_exists($roomsFile) ? json_decode(file_get_contents($roomsFile), true) : array();
$newsData=file_exists($newsFile) ? json_decode(file_get_contents($newsFile), true) : array();
$emailexist = false;
$changeInformation=false;
$validPages = ["hotel", "impressum", "F_and_Q", "new_reservation", "reserved_rooms", "signup", "signin", "userInformation","news","addphoto"];
foreach($validPages as $p){
    if(isset($_GET[$p])){
        if(isset($_SESSION["logged"])&&$_SESSION["logged"]==true){
            if($p == "addphoto"){
                if($_SESSION["email"]=="admin@gmail.com"){
                    $page = $p;
                    break;
                }
                else{
                    $page = "hotel"; 
                }
            }
            else{
                $page = $p;
                break;
            }
        }
        else{
            if($p == "hotel" || $p == "impressum" ||  $p =="F_and_Q" ||  $p =="signup" ||  $p =="signin" || $p == "news"){
                $page = $p;
            }
            else{
                $page = "signin";
            }
            break;
        }
    }
}

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}    
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
    if(empty($_POST["vorname"])||empty($_POST["nachname"])||empty($_POST["username"])||empty($_POST["email"])||empty($_POST["passwort"])||empty($_POST["confirmpasswort"])||$_POST["confirmpasswort"]!==$_POST["passwort"]){
        $page = "signup";
    }
    else{
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
        }
        else{
            $page = "signup";
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
            $page ="hotel";
            break;
        }
        else{
            $signInFalse=true;
        }
    }
}
if(isset($_POST["newReservation"])){
    if(isset($_POST["zimmer"])&&isset($_POST["anreiseDatum"])&&isset($_POST["abreiseDatum"])&&$_POST["abreiseDatum"]>$_POST["anreiseDatum"]){
        $fruehstueck = empty($_POST["fruehstueck"])?"no":"yes";
        $parkplatz = empty($_POST["parkplatz"])?"no":"yes";
        $haustier = empty($_POST["haustier"])?"no":"yes";
        $reservation = array(
            "reservationEmail" => $_SESSION["email"],
            "zimmer" => $_POST["zimmer"],
            "anreiseDatum" => $_POST["anreiseDatum"],
            "abreiseDatum" => $_POST["abreiseDatum"],
            "fruehstueck" => $fruehstueck,
            "parkplatz" => $parkplatz,
            "haustier" => $haustier,
        );
        $reservationdata[]=$reservation;
        $jsonString = json_encode($reservationdata, JSON_PRETTY_PRINT);
        file_put_contents($reservationJsonFile, $jsonString);
        $roomsData[$_POST["zimmer"]]="reserved";
        $newJsonString = json_encode($roomsData,JSON_PRETTY_PRINT);
        file_put_contents($roomsFile, $newJsonString);
        };
}
?>