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
                <div>
                    <button class='btn bg-black text-white'><a href='?addnews' style='color:white;'>Beitrag Hinzufügen</a></button>
                </div>
            ";
            }
            //TODO  remove the news button; 
            //TODO add the date for the news
            //TODO make the photos smaller 
            
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
                    echo "
                    <div class='card col-12 col-md-6 col-lg-4 m-2 p-2' style='width: 27rem; border:none;'>
                        <img src='$fotopfad' class='card-img' style='height:27rem;' alt='...'>
                        <div class='card-body'>
                            <h5 style='text-align:center;'>$ueberschrift<h5>
                            <p class='pt-5 pr-2' style='font-family: \'Courier New\', Courier, monospace;'>$beschreibung</p>
                        </div>
                        </div>
                    ";
                };
            ?>
    </div>
</div>