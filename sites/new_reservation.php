<?php
//TODO  fix the session["zimmer"] issue;
//TODO add the price for the features
    $heutigeDatum = date('Y-m-d');
    $minDatum = date('Y-m-d', time() + 86400);
    $errors=[];
    $zimmer;
    $anreiseDatum;
    $abreiseDatum;
    if (isset($_POST["newReservation"])){
        $zimmer = isset($_POST["zimmer"])?$_POST["zimmer"]:null;
        $anreiseDatum = isset($_POST["anreiseDatum"])?new DateTime($_POST["anreiseDatum"]):null;
        $abreiseDatum = isset($_POST["abreiseDatum"])?new DateTime($_POST["abreiseDatum"]):null;
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
<div class="d-flex justify-content-center align-items-center h-100">
    <form method="post">
        <div class="sign-outter">
            <div class="sign-logo">
                <a href="?hotel" class="d-flex align-items-center">
                    <img src="styles/fotos/Else/upper-belvedere-vienna.png" class="sign-logo-img" width="65px" alt="Logo">
                </a>
                <p class="sign-logo-p mt-4" style="font-size: 30px;">Vienna Stars Hotel</p>
            </div>
            <div class="sign-bar" style="gap:5px;">
                <h5 style="text-align:center;">Reservation</h5>
                
                <?php
                    
                    if(isset($_POST["zimmer"])&&isset($_POST["anreiseDatum"])&&isset($_POST["abreiseDatum"])&&$_POST["abreiseDatum"]>$_POST["anreiseDatum"]){
                        echo "
                            <p style='color:green; text-align:center; margin-bottom:0px;'> Sie haben $zimmer reserviert</p> 
                        ";
                        echo "
                        <div class='d-flex justify-content-center'>
                            <a href='?reserved_rooms' class='new_reservation_a' style='font-size:15px;'> Zur Reservierungen</a>
                        </div>
                    ";
                    }
                ?>
                <select id="zimmer" name="zimmer">
                    <option value="">Bitte wählen Sie</option>
                    <?php
                        $sql = "SELECT * From zimmer";
                        $result = $db->query($sql);
                        while($row = $result->fetch_assoc()){
                            if($row["verfuegber"]>0){
                                echo "<option value=".$row["name"];
                                if($row["name"]==$_SESSION["zimmer"]){
                                    echo" selected";
                                }
                                echo ">".$row["name"]."</option>";
                            }
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
                        <input type="date" id="anreiseDatum" name="anreiseDatum" min="<?php echo $heutigeDatum; ?>" value="">
                        <?php
                            if(isset($errors["anreiseDatum"])){
                                echo '<div style="color:red;">'.$errors['anreiseDatum'].'</div>';
                            }
                        ?>
                    </div>
                    <div class="checkoutdate">
                        <label for="abreiseDatum">Abreisedatum:</label>
                        <input type="date" id="abreiseDatum" name="abreiseDatum" min="<?php echo $minDatum; ?>" value="">
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
                    <input type="checkbox" class='form-check-input' id="fruehstueck" name="fruehstueck">
                </div>

                <div>
                    <label for="parkplatz">Parkplatz:</label>
                    <input type="checkbox" class='form-check-input' id="parkplatz" name="parkplatz">
                </div>

                <div>
                    <label for="haustier">Haustiere:</label>
                    <input type="checkbox" class='form-check-input' id="haustier" name="haustier">
                </div>
                <button type="submit" class="btn bg-black text-white" name="newReservation">Reservieren</button>
            </div>
        </div>
    </form>
</div>