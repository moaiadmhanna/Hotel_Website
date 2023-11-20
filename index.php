<?php
    session_start();
    $page = "hotel.php";
    $validPages = ["hotel", "impressum", "F_and_Q", "new_reservation", "reserved_rooms", "signup", "signin", "userInformation", "logout"];
    foreach($validPages as $p){
        if(isset($_GET[$p])){
            $page = $p;
            break;
        }
    }
    
    if ($page === "logout") {
        session_destroy();
        header("Location: index.php");
        exit();
    }    
    if(isset($_GET["changeInformation"])){
        $changeInformation=true;
        $page="userInformation";
    }

    if(isset($_POST["changeInformation"])){
        $_SESSION["vorname"]=$_POST["vorname"];
        $_SESSION["nachname"]=$_POST["nachname"];
        $_SESSION["username"]=$_POST["username"];
        $_SESSION["email"]=$_POST["email"];
        $_SESSION["password"]=$_POST["password"];
        $changeInformation=false;
        $page="userInformation";
    }
    if(isset($_POST["signup"])){
        if(empty($_POST["vorname"])||empty($_POST["nachname"])||empty($_POST["username"])||empty($_POST["email"])||empty($_POST["password"])||empty($_POST["confirmpassword"])||$_POST["confirmpassword"]!==$_POST["password"]){
            $page = "signup";
        }
        else{
            $_SESSION["vorname"]=$_POST["vorname"];
            $_SESSION["nachname"]=$_POST["nachname"];
            $_SESSION["username"]=$_POST["username"];
            $_SESSION["email"]=$_POST["email"];
            $_SESSION["password"] = $_POST["password"];
            $page = "hotel";
        }
    }

    if(isset($_POST["login"])){
        if(isset($_SESSION["email"])&&isset($_SESSION["password"])){
            if($_POST["email"]== $_SESSION["email"] && $_POST["password"] == $_SESSION["password"]){
                $_SESSION["logged"] = true;
                $_SESSION["reservationNumber"]=1;
                $page = "hotel";
            }
        }
        else{
            $signInFalse=true;
        }
    }
    $avilable_rooms=array(
        "Zimmer 1" => null,
        "Zimmer 2" => null,
        "Zimmer 3" => null,
    );
    if(isset($_POST["newReservation"])){
        if(isset($_POST["zimmer"])&&isset($_POST["anreiseDatum"])&&isset($_POST["abreiseDatum"])&&$_POST["abreiseDatum"]>$_POST["anreiseDatum"]){
            $fruehstueck = empty($_POST["fruehstueck"])?"no":"yes";
            $parkplatz = empty($_POST["parkplatz"])?"no":"yes";
            $haustier = empty($_POST["haustier"])?"no":"yes";
            $reservation = array(
                "zimmer" => $_POST["zimmer"],
                "anreiseDatum" => $_POST["anreiseDatum"],
                "abreiseDatum" => $_POST["abreiseDatum"],
                "fruehstueck" => $fruehstueck,
                "parkplatz" => $parkplatz,
                "haustier" => $haustier,

            );
            $_SESSION["reservation" . $_SESSION["reservationNumber"]]=$reservation;
            $_SESSION["reservationNumber"]++;
        };
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page ?></title>
    <link rel ="stylesheet" href="styles/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
    include_once "sites/".$page.".php";
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>