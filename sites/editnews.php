<?php
    $errors=[];
    $uploadok=FALSE;
    $removeok=FALSE;
    if(isset($_POST["beitraglöschen"])){
        if(isset($_POST['beitrag'])){
            $sql = "SELECT fotopfad FROM beitrag WHERE beitragsdatum = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("s", $_POST["beitrag"]);
            $stmt->execute();
            $result=$stmt->get_result();
            $row = $result->fetch_assoc();
            $filename = $row["fotopfad"];
            unlink($filename);
            $sql = "DELETE FROM beitrag WHERE beitragsdatum = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("s", $_POST["beitrag"]);
            if($stmt->execute()){
                $removeok = TRUE;
            }
            else{
                $errors["removeError"]="Fehler aufgetreten";
            }
        }
        else{
            $errors["beitrag"]="Kein Beitrag wurde gewählt";
        }
    }
    if (isset($_POST["beitraghochladen"])){
        $ueberschrift = isset($_POST["ueberschrift"])?$_POST["ueberschrift"]:null;
        $beschreibung = isset($_POST["beschreibung"])?$_POST["beschreibung"]:null;
        if(empty($_FILES["foto"]["name"])){
            $errors["foto"]="Kein foto wurde gewählt";
        }
        if(empty($ueberschrift)){
            $errors["ueberschrift"]="Kein überschrift wurde eingegben";
        }
        if(empty($beschreibung)){
            $errors["beschreibung"]="Kein beschreibung wurde eingegben";
        }
        if(empty($errors)){
            $info = pathinfo($_FILES["foto"]["name"]);
            //echo "Mime-Type: " . mime_content_type($_FILES["foto"]["tmp_name"]);
            if (mime_content_type($_FILES["foto"]["tmp_name"]) !== "image/jpeg") {
                $errors["imageType"]= "Nur jpeg Fotos sind erlaubt";
            }
            else{
                $filename = "styles/fotos/news/" . uniqid() . "_img." . $info["extension"];
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $filename) === false) {
                    $errors["uploadError"]="Fehler aufgetreten";
                }
                else{
                    list($width, $height) = getimagesize($filename);
                    $newwidth = 3264;
                    $newheight = 4928;
                    $thumb = imagecreatetruecolor($newwidth, $newheight);
                    $source = imagecreatefromjpeg($filename);
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                    imagejpeg($thumb, $filename);
                    imagedestroy($thumb);
                    imagedestroy($source);
                    $sql = "INSERT INTO beitrag(ueberschrift,beschreibung,fotopfad) VALUES(?,?,?)";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("sss",$ueberschrift,$beschreibung,$filename);
                    $stmt->execute();
                    $uploadok = TRUE;
                }
            }
        }
    }
    if($_GET['editnews']=="addnews"){
?>
<div class="d-flex justify-content-center align-items-center h-100">
    <form enctype="multipart/form-data" method="post">
        <div class="sign-outter">
            <div class="sign-logo">
                <a href="?hotel" class="d-flex align-items-center">
                    <img src="styles/fotos/Else/upper-belvedere-vienna.png" class="sign-logo-img" width="65px" alt="Logo">
                </a>
                <p class="sign-logo-p mt-4" style="font-size: 30px;">Vienna Stars Hotel</p>
            </div>
            <div class="sign-bar" style="gap:5px;">
                <h5 style="text-align:center;">Beitrag Hochladen</h5>
                <?php
                    if(isset($errors["uploadError"])){
                        echo '<div style="color:red; text-align:center;">'.$errors['uploadError'].'</div>';
                    }
                    if($uploadok){
                        echo '<div style="color:green; text-align:center;">Der Beitrag wurde hinzüfugt</div>';
                        echo "
                        <div class='d-flex justify-content-center'>
                            <a href='?news' class='new_reservation_a' style='font-size:15px;'>Zur News</a>
                        </div>
                    ";
                    }
                ?>
                <input type="text" id="ueberschrift" name="ueberschrift" placeholder="Bitte geben Sie Ihre Überschrift">
                <?php
                    if(isset($errors["ueberschrift"])){
                        echo '<div style="color:red; text-align:center;">'.$errors['ueberschrift'].'</div>';
                    }
                ?>
                <textarea name="beschreibung" id="beschreibung" placeholder="Bitte geben Sie Ihre beschreibung" cols="40" rows="5"></textarea>
                <?php
                    if(isset($errors["beschreibung"])){
                        echo '<div style="color:red; text-align:center;">'.$errors['beschreibung'].'</div>';
                    }
                ?>
                <input type="file" name="foto" accept="image/jpeg,image/png">
                <?php
                    if(isset($errors["foto"])){
                        echo '<div style="color:red; text-align:center;">'.$errors['foto'].'</div>';
                    }
                    if(isset($errors["imageType"])){
                        echo '<div style="color:red; text-align:center;">'.$errors['imageType'].'</div>';
                    }
                ?>
                <button type="submit" class="btn bg-black text-white" name="beitraghochladen">Hochladen</button>
            </div>
        </div>
    </form>
</div>
<?php
    }
    else if($_GET['editnews']=="removenews"){
?>
<div class="d-flex justify-content-center align-items-center h-100">
    <form enctype="multipart/form-data" method="post">
        <div class="sign-outter">
            <div class="sign-logo">
                <a href="?hotel" class="d-flex align-items-center">
                    <img src="styles/fotos/Else/upper-belvedere-vienna.png" class="sign-logo-img" width="65px" alt="Logo">
                </a>
                <p class="sign-logo-p mt-4" style="font-size: 30px;">Vienna Stars Hotel</p>
            </div>
            <div class="sign-bar" style="gap:5px;">
                <h5 style="text-align:center;">Beitrag Löschen</h5>
                <?php
                    if(isset($errors["removeError"])){
                        echo '<div style="color:red; text-align:center;">'.$errors['removeError'].'</div>';
                    }
                    if($removeok){
                        echo '<div style="color:green; text-align:center;">Der Beitrag wurde gelöscht</div>';
                        echo "
                        <div class='d-flex justify-content-center'>
                            <a href='?news' class='new_reservation_a' style='font-size:15px;'>Zur News</a>
                        </div>
                    ";
                    }
                    echo "<select id='news' name='beitrag'>";
                    echo "<option selected disabled> Bitte Wählen Sie einen Beitrag aus </option>";
                    $sql = "SELECT * from beitrag";
                    $result = $db->query($sql);
                    while($row=$result->fetch_assoc()){
                        echo "<option value='".$row["beitragsdatum"]."'>".$row["ueberschrift"]." am : ". $row["beitragsdatum"]."</option>";
                    }
                ?>
                </select>
                <?php
                    if(isset($errors["beitrag"])){
                        echo '<div style="color:red; text-align:center;">'.$errors['beitrag'].'</div>';
                    }
                ?>
                <button type="submit" class="btn bg-black text-white" name="beitraglöschen">Löschen</button>
<?php
    }
    else{
        header("Location: ?news");
        exit();
    }
?>