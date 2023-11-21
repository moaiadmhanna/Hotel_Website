<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
<style>
    /* Add custom styles for the scrollable content */
    .accordion-body {
        overflow-y: scroll; /* Enable vertical scrolling */
    }
</style>
</head>
<body>
    <?php
        include_once "navbar.php";
    ?>
    <?php
        $numberOfReservations=1;
        $reservationCounter=1;
        foreach($reservationdata as $reservation){
            if($reservation["reservationEmail"]==$_SESSION["email"]){
                $numberOfReservations++;
            }
        }
        if($numberOfReservations>1){
            foreach($reservationdata as $reservation){
                if($reservation["reservationEmail"]==$_SESSION["email"]){
                    $zimmer = $reservation["zimmer"];
                    $anreiseDatum = $reservation["anreiseDatum"];
                    $abreiseDatum = $reservation["abreiseDatum"];
                    $fruehstueck = $reservation["fruehstueck"];
                    $parkplatz = $reservation["parkplatz"];
                    $haustier = $reservation["haustier"];
                    echo "
                    <div class='accordion mt-5 m-2' id='accordionExample'>
                        <div class='accordion-item'>
                        <h2 class='accordion-header'>
                            <button class='accordion-button collapsed bg-dark text-white' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$reservationCounter' aria-expanded='true' aria-controls='collapse$reservationCounter'>
                                Reservation $reservationCounter
                            </button>
                        </h2>
                        <div id='collapse$reservationCounter' class='accordion-collapse collapse' data-bs-parent='#accordionExample'>
                            <div class='accordion-body'>
                                <p>Zimmer : $zimmer</p>
                                <p>Anreisedatum : $anreiseDatum</p>
                                <p>Abreisedatum : $abreiseDatum</p>
                                <p>Frühstück : $fruehstueck</p>
                                <p>Parkplatz : $parkplatz</p>
                                <p>Haustier : $haustier</p>
                            </div>
                        </div>
                        </div>
                    </div>
                    ";
                }
                $reservationCounter++;
            }
        }
        $reservationCounter=1;
        if($numberOfReservations==1){      
            echo "
            <div class='d-flex flex-column  align-items-center'>
                <p style='color:red;'>Sie haben kein Zimmer Reserviert</p>
                <button class='btn bg-black text-white'><a href='?new_reservation' style='color:white;'> Zur Reservierung</a></button>
            </div>
            ";
        }
    ?>
</body>
</html>