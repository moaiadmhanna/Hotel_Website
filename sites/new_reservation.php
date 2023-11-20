<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Reservation</title>
</head>
<?php
    $errors=[];
    $zimmer;
    $anreiseDatum;
    $abreiseDatum;
    if (isset($_POST["newReservation"])){
        $zimmer = isset($_POST["zimmer"])?$_POST["zimmer"]:null;
        $anreiseDatum = isset($_POST["anreiseDatum"])?$_POST["anreiseDatum"]:null;
        $abreiseDatum = isset($_POST["abreiseDatum"])?$_POST["abreiseDatum"]:null;
        $anreiseDatum = isset($_POST["anreiseDatum"])?$_POST["anreiseDatum"]:null;
        if(empty($_POST["zimmer"])){
            $errors["zimmer"]="Kein Zimmer wurde gewählt";
        }
        if(empty($_POST["anreiseDatum"])){
            $errors["anreiseDatum"]="Kein Anreisedatum wurde gewählt";
        }
        if(empty($_POST["abreiseDatum"])){
            $errors["abreiseDatum"]="Kein Abreisedatum wurde gewählt";
        }
        if($anreiseDatum>=$abreiseDatum){
            $errors["datumsfehler"]= "Das Abreisedatum muss nach dem Anreisedatum liegen.";
        }
    }
?>  
<body class="d-flex justify-content-center align-items-center">
    <form method="post">
        <div class="sign-outter">
            <div class="sign-logo">
                <a href="?hotel" class="d-flex align-items-center">
                    <img src="./styles/fotos/upper-belvedere-vienna.png" class="sign-logo-img" width="65px" alt="Logo">
                </a>
                <p class="sign-logo-p mt-4" style="font-size: 30px;">Vienna Stars Hotel</p>
            </div>
            <div class="sign-bar" style="gap:5px;">
                <h5 style="text-align:center;">Reservation</h5>
                <?php
                    if(isset($_POST["zimmer"])&&isset($_POST["anreiseDatum"])&&isset($_POST["abreiseDatum"])&&$_POST["abreiseDatum"]>$_POST["anreiseDatum"]){
                        echo "
                            <p style='color:green; text-align:center;'> Sie haben $zimmer reserviert</p>
                        ";
                    }
                ?>
                <select id="zimmer" name="zimmer">
                    <option value="" disabled selected>Bitte wählen Sie</option>
                    <?php
                        foreach($avilable_rooms as $room => $status){
                            if(empty($status)){
                                echo "<option value='$room'>".$room."</option>";
                            };
                        }
                    ?>
                </select>
                <?php
                if(isset($errors["zimmer"])){
                            echo '<div style="color:red;">'.$errors['zimmer'].'</div>';
                        }
                ?>
                <div>
                    <div class="checkindate" style="padding-bottom:5px;">
                        <label for="anreiseDatum">Anreisedatum:</label>
                        <input type="date" id="anreiseDatum" name="anreiseDatum" value="">
                        <?php
                            if(isset($errors["anreiseDatum"])){
                                echo '<div style="color:red;">'.$errors['anreiseDatum'].'</div>';
                            }
                        ?>
                    </div>
                    <div class="checkoutdate">
                        <label for="abreiseDatum">Abreisedatum:</label>
                        <input type="date" id="abreiseDatum" name="abreiseDatum" value="">
                        <?php
                            if(isset($errors["abreiseDatum"])){
                                echo '<div style="color:red;">'.$errors['abreiseDatum'].'</div>';
                            }
                        ?>
                    </div>
                    <?php
                        if(isset($errors["datumsfehler"])&&empty($errors["abreiseDatum"])&&empty($errors["anreiseDatum"])){
                            echo '<div style="color:red;">'.$errors['datumsfehler'].'</div>';
                        }
                    ?>
                </div>
                <div>
                    <label for="fruehstueck">Frühstück:</label>
                    <input type="checkbox" id="fruehstueck" name="fruehstueck">
                </div>

                <div>
                    <label for="parkplatz">Parkplatz:</label>
                    <input type="checkbox" id="parkplatz" name="parkplatz">
                </div>

                <div>
                    <label for="haustier">Haustiere:</label>
                    <input type="checkbox" id="haustier" name="haustier">
                </div>
                <button type="submit" class="btn bg-black text-white" name="newReservation">Reservieren</button>
                <?php
                    if(isset($_POST["zimmer"])&&isset($_POST["anreiseDatum"])&&isset($_POST["abreiseDatum"])&&$_POST["abreiseDatum"]>$_POST["anreiseDatum"]){
                        echo "
                            <div class='d-flex justify-content-center'>
                                <button class='btn bg-black text-white'><a href='?reserved_rooms' style='color:white;'> Zur Reservierungen</a></button>
                            </div>
                        ";
                    }
                ?>
            </div>
        </div>
    </form>
</body>
</html>