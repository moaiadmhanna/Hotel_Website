<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="styles/fotos/Else/parisi-udvar-hotel-budapest-exterior-night-2.webp" class="d-block w-100" alt="Unser Hotel">
        </div>
    </div>
</div>
<div class="d-flex flex-column align-items-center">
    <p class="newsP mt-5" style="text-align:center;font-size: 30px; font-weight:bolder;">Unser News</p>
    <?php
            if(isset($_SESSION["email"]) && $_SESSION["email"]=="admin@gmail.com"){
                echo "
                <div class='d-flex justify-content-between w-25 '>
                    <a class='new_reservation_a' href='?editnews=addnews'>Beitrag Hinzufügen</a>
                    <a class='new_reservation_a 'href='?editnews=removenews'>Beitrag Löschen</a>
                </div>
            ";
            }
            
    ?>
</div>
<div class="container mt-5">
    <div class='row justify-content-around'>
            <?php
                $sql = "SELECT * FROM beitrag ORDER BY beitragsdatum desc";
                $result = $db->query($sql);
                while($row=$result->fetch_assoc()){
                    $ueberschrift = $row["ueberschrift"];
                    $beschreibung = $row["beschreibung"];
                    $fotopfad = $row["fotopfad"];
                    $beitragsdatum = $row['beitragsdatum'];
                    echo "
                    <div class='card col-12 col-md-6 col-lg-4 m-2 p-2' style='width: 27rem; border:none;'>
                        <img src='$fotopfad' class='card-img' style='height:27rem;' alt='...'>
                        <div class='card-body d-flex flex-column justify-content-between'>
                            <h4 style='text-align:center;'>$ueberschrift</h4>
                            <p class='fs-5 pt-3' style='font-family: \'Courier New\', Courier, monospace;'>$beschreibung</p>
                            <p class='card-text text-warning bg-dark p-2' style='text-align:center;line-height:1.5;margin-top'>$beitragsdatum</p>
                        </div>
                        </div>
                    ";
                };
            ?>
    </div>
</div>