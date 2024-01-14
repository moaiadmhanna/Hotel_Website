<style>
    td>.btn{
        padding:0px;
    }
</style>
<?php
    if(isset($_POST["searchReservations"])){
        $_SESSION["searchUser"]=$_POST["user"];
        $_SESSION["searchStatus"]=$_POST["status"];
    }
?>
<div class="d-flex justify-content-center">
    <form class="d-flex mt-4" method="post" style="width:30%; gap:10px;">
    <select class="form-select" aria-label="Default select example" name="user" style="border: 2px solid gray" required>
        <option selected disabled value ="">Wählen Sie den Benutzer</option>
        <option value ="">Alle</option>
        <?php
            $result= get_users("");
            while($row = $result->fetch_assoc()){
                echo "<option value=".$row['email'].">".$row['email']."</option>";
            }
        ?>
    </select>
    <select class="form-select" aria-label="Default select example" name="status" style="border: 2px solid gray" required>
        <option selected disabled value ="">Wählen Sie die Status</option>
        <option value="">Alle</option>
        <option class="text-success" value="bestaetigt">bestätigt</option>
        <option class="text-danger" value="storniert">storniert</option>
        <option class="text-primary" value="neu">neu</option>
    </select>
    <button class="btn btn-outline-success" type="submit" name="searchReservations">Suchen</button>
    </form>
</div>
<?php
    // wenn der stornieren button geklickt ist wird der stautus vom reservierung zu storniert geändert.
    if(isset($_POST["reservierungstornieren"])){
        $status = 'storniert';
        change_status($status,$_POST["email"]);
        $zimmer = $_POST['name'];
        $zimmerid = get_room($zimmer);
        change_room_availablity($zimmerid,1);
    };
    // wenn der bestätigen button geklickt ist wird der stautus vom reservierung zu bestätigt geändert.
    if(isset($_POST["reservierungbestaetigen"])){
        $status = 'bestaetigt';
        change_status($status,$_POST["email"]);
    };
    // holt alle reservierungen vom Datenbank und gibt die in tabelle aus.
    if(isset($_SESSION["searchUser"])&&isset($_SESSION["searchStatus"])){
        $result = get_reservations($_SESSION["searchUser"],$_SESSION["searchStatus"]);
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='container-fluid pt-4'>";
            echo    "<div class='table-responsive'>";
            echo        "<table class='table table-hover'>";
            echo            "<thead class='table-dark'>";
            echo                "<tr>";
            echo                    "<th scope='col'>#</th>";
            echo                    "<th scope='col'>Benutzer</th>";
            echo                    "<th scope='col'>Zimmer</th>";
            echo                    "<th scope='col'>Anreise Datum</th>";
            echo                    "<th scope='col'>Abreise Datum</th>";
            echo                    "<th scope='col'>Frühstück</th>";
            echo                    "<th scope='col'>Parkplatz</th>";
            echo                    "<th scope='col'>Haustier</th>";
            echo                    "<th scope='col'>Status</th>";
            echo                    "<th scope='col'>Gesamtpreis</th>";
            echo                    "<th scope='col'>Reservierungsdatum</th>";
            echo                    "<th scope='col'>Verwahlten</th>";
            echo                "</tr>";
            echo            "</thead>";
            echo            "<tbody>";
            $counter = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr class='table-warning'>";
            echo "<form method='post'>";
            echo    "<th scope='row'>$counter</th>";
            echo        "<input type='hidden' name='datum' value='{$row['reservierungsdatum']}'>";
            echo        "<input type='hidden' name='email' value='{$row['email']}'>";
            echo        "<input type='hidden' name='name' value='{$row['name']}'>";
            echo        "<td>{$row['email']}</td>";
            echo        "<td>{$row['name']}</td>";
            echo        "<td>{$row['anreisedatum']}</td>";
            echo        "<td>{$row['abreisedatum']}</td>";
            echo        "<td>" . ($row['fruehstuck'] ? 'inklusiv' : 'nicht inklusiv') . "</td>";
            echo        "<td>" . ($row['parkplatz'] ? 'inklusiv' : 'nicht inklusiv') . "</td>";
            echo        "<td>" . ($row['haustier'] ? 'inklusiv' : 'nicht inklusiv') . "</td>";
    
            // Bestimmet die Textfarbe basierend auf dem Reservierungsstatus
            $statusColor = '';
            if ($row["status"] == 'neu') {
                $statusColor = 'primary';
            } elseif ($row["status"] == 'bestaetigt') {
                $statusColor = 'success';
            } else {
                $statusColor = 'danger';
            }
    
            echo       "<td class='text-$statusColor'>{$row['status']}</td>";
            echo       "<td>{$row['gesamtpreis']}</td>";
            echo       "<td>{$row['date(reservierungsdatum)']}</td>";
            echo       "<td>";
    
            // Zeigt Modal und Button nur für Reservierungen mit Status „neu“ anzeigen
            if ($row["status"] == "neu") {
                echo "
                    <!-- Button trigger modal -->
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal_stornieren$counter' style='background: none; border: none;'>
                        <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='24' height='24' viewBox='0 0 48 48'>
                            <linearGradient id='wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1' x1='9.858' x2='38.142' y1='9.858' y2='38.142' gradientUnits='userSpaceOnUse'>
                                <stop offset='0' stop-color='#f44f5a'></stop>
                                <stop offset='.443' stop-color='#ee3d4a'></stop>
                                <stop offset='1' stop-color='#e52030'></stop>
                            </linearGradient>
                            <circle fill='url(#wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1)' cx='24' cy='24' r='20'></circle>
                            <path fill='#fff' d='M31.071,15.515l1.414,1.414c0.391,0.391,0.391,1.024,0,1.414L18.343,32.485
                                c-0.391,0.391-1.024,0.391-1.414,0l-1.414-1.414c-0.391-0.391-0.391-1.024,0-1.414l14.142-14.142
                                C30.047,15.124,30.681,15.124,31.071,15.515z'></path>
                            <path fill='#fff' d='M32.485,31.071l-1.414,1.414c-0.391,0.391-1.024,0.391-1.414,0L15.515,18.343
                                c-0.391-0.391-0.391-1.024,0-1.414l1.414-1.414c0.391-0.391,1.024-0.391,1.414,0l14.142,14.142
                                C32.876,30.047,32.876,30.681,32.485,31.071z'></path>
                        </svg>
                    </button>
    
                        <!-- Modal -->
                        <div class='modal fade' id='exampleModal_stornieren$counter' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Storniern</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <p>Sind Sie Sicher wollen sie die Reservierung stornieren</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Abbrechen</button>
                                        <button type='submit' class='btn btn-danger' name='reservierungstornieren'>Stornieren</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                    echo "
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal_bestätigen$counter' style='background: none; border: none;'>
                        <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='24' height='24' viewBox='0 0 48 48'>
                            <linearGradient id='wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1_green' x1='9.858' x2='38.142' y1='9.858' y2='38.142' gradientUnits='userSpaceOnUse'>
                                <stop offset='0' stop-color='#4CAF50'></stop>
                                <stop offset='1' stop-color='#45A047'></stop>
                            </linearGradient>
                            <circle fill='url(#wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1_green)' cx='24' cy='24' r='20'></circle>
                            <path fill='#fff' d='M30.485,15.5l-10,10L17.515,23l-1.414,1.414l6,6L31.899,16.914L30.485,15.5z'></path>
                        </svg>
                    </button>
                    <div class='modal fade' id='exampleModal_bestätigen$counter' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Bestätigen</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <p>Sind Sie Sicher wollen sie die Reservierung bestätigen</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Abbrechen</button>
                                        <button type='submit' class='btn btn-success' name='reservierungbestaetigen'>bestätigen</button>
                                    </div>
                                </div>
                            </div>
                        </div>                
                ";
                }
                else if($row["status"] == "bestaetigt"){
                    echo "
                    <!-- Button trigger modal -->
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal_stornieren$counter' style='background: none; border: none;'>
                        <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='24' height='24' viewBox='0 0 48 48'>
                            <linearGradient id='wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1' x1='9.858' x2='38.142' y1='9.858' y2='38.142' gradientUnits='userSpaceOnUse'>
                                <stop offset='0' stop-color='#f44f5a'></stop>
                                <stop offset='.443' stop-color='#ee3d4a'></stop>
                                <stop offset='1' stop-color='#e52030'></stop>
                            </linearGradient>
                            <circle fill='url(#wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1)' cx='24' cy='24' r='20'></circle>
                            <path fill='#fff' d='M31.071,15.515l1.414,1.414c0.391,0.391,0.391,1.024,0,1.414L18.343,32.485
                                c-0.391,0.391-1.024,0.391-1.414,0l-1.414-1.414c-0.391-0.391-0.391-1.024,0-1.414l14.142-14.142
                                C30.047,15.124,30.681,15.124,31.071,15.515z'></path>
                            <path fill='#fff' d='M32.485,31.071l-1.414,1.414c-0.391,0.391-1.024,0.391-1.414,0L15.515,18.343
                                c-0.391-0.391-0.391-1.024,0-1.414l1.414-1.414c0.391-0.391,1.024-0.391,1.414,0l14.142,14.142
                                C32.876,30.047,32.876,30.681,32.485,31.071z'></path>
                        </svg>
                    </button>
    
                        <!-- Modal -->
                        <div class='modal fade' id='exampleModal_stornieren$counter' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Storniern</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <p>Sind Sie Sicher wollen sie die Reservierung stornieren</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Abbrechen</button>
                                        <button type='submit' class='btn btn-danger' name='reservierungstornieren'>Stornieren</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                echo "</td>";
                echo "</form>";
                echo "</tr>";
                $counter++;
        }
            echo "
                        </tbody>
                    </table>
                </div>
            </div>
            ";
        } else {
            echo "
            <div class='container text-center mt-5'>
                <p class='text-danger'>Der Benutzer hat kein Zimmer reserviert.</p>
            </div>
            ";
        }
    }
?>