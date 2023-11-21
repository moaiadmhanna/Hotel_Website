<?php
    session_start();
    $page = "hotel";
    $jsonFile = 'data/signdata.json';
    $data = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : array();
    $emailexist = false;
    $changeInformation=false;
    $validPages = ["hotel", "impressum", "F_and_Q", "new_reservation", "reserved_rooms", "signup", "signin", "userInformation"];
    foreach($validPages as $p){
        if(isset($_GET[$p])){
            $page = $p;
            break;
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
        foreach($data as $key =>$user){
            if($user["email"]==$newEmail){
                $emailexist = true;
                break;
            }
            if($user["email"]==$_SESSION["email"]){
                $data[$key]["vorname"] = $_POST["vorname"];
                $data[$key]["nachname"] = $_POST["nachname"];
                $data[$key]["username"] = $_POST["username"];
                $data[$key]["email"] = $_POST["email"];
                $data[$key]["password"] = password_hash($_POST["password"].$data[$key]["salt"],PASSWORD_DEFAULT);

                $_SESSION["vorname"] = $data[$key]["vorname"];
                $_SESSION["nachname"] = $data[$key]["nachname"];
                $_SESSION["username"] = $data[$key]["username"];
                $_SESSION["email"] = $data[$key]["email"];
                break;
            }
        }
        $newJsonString = json_encode($data,JSON_PRETTY_PRINT);
        file_put_contents($jsonFile, $newJsonString);
        $changeInformation=false;
        $page="userInformation";
    }
    if(isset($_POST["signup"])){
        if(empty($_POST["vorname"])||empty($_POST["nachname"])||empty($_POST["username"])||empty($_POST["email"])||empty($_POST["password"])||empty($_POST["confirmpassword"])||$_POST["confirmpassword"]!==$_POST["password"]){
            $page = "signup";
        }
        else{
            $rawPassword = $_POST['password'];
            $salt = bin2hex(random_bytes(16));
            $hashedPassword = password_hash($rawPassword . $salt, PASSWORD_DEFAULT);
            $newArrayToAdd = array(
                "vorname" => $_POST["vorname"],
                "nachname" => $_POST["nachname"],
                "username" => $_POST["username"],
                "email" => $_POST["email"],
                "password" => $hashedPassword,
                "salt" => $salt,
            );
            $newEmail = $_POST["email"];
            foreach($data as $user){
                if($user["email"]==$newEmail){
                    $emailexist = true;
                    break;
                }
            }
            if(!$emailexist){
                $data[] = $newArrayToAdd;
                $jsonString = json_encode($data, JSON_PRETTY_PRINT);
                file_put_contents($jsonFile, $jsonString);
            }
            else{
                $page = "signup";
            }
        }
    }

    if(isset($_POST["login"])){
        $page = "signin";
        foreach($data as $user){
            if($user["email"]==$_POST["email"] && password_verify($_POST["password"].$user["salt"],$user["password"])){
                $_SESSION["vorname"]=$user["vorname"];
                $_SESSION["nachname"]=$user["nachname"];
                $_SESSION["username"]=$user["username"];
                $_SESSION["email"]=$user["email"];
                $_SESSION["logged"]=true;
                $page ="hotel";
                break;
            }
            else{
                $signInFalse=true;
            }
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