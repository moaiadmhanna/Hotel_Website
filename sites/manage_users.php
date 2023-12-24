<div class="d-flex justify-content-center">
    <form class="d-flex w-50 mt-4" method="post">
        <input class="form-control me-2" type="search" name="usersearch" placeholder="Suchen" aria-label="Search" style="border: 2px solid gray" value=''>
        <button class="btn btn-outline-success" type="submit" name="searchUsers">Suchen</button>
    </form>
</div>
<?php
    if(isset($_POST['userdeaktivieren'])){
        $status = 'Inaktiv';
        change_user_status($status);
    }
    if(isset($_POST['useraktivieren'])){
        $status = 'Aktiv';
        change_user_status($status);
    }
    if(isset($_POST["searchUsers"])){
        $_SESSION['search'] = $_POST['usersearch'];
    }
    if(!isset($_SESSION['search'])){
        $result = get_users('');
    }
    else{
        $result = get_users($_SESSION['search']);
    }
        if(mysqli_num_rows($result) > 0){
        echo "<div class='container-fluid pt-4 w-75'>";
        echo    "<div class='table-responsive'>";
        echo        "<table class='table table-hover'>";
        echo            "<thead class='table-dark'>";
        echo                "<tr>";
        echo                    "<th scope='col'>#</th>";
        echo                    "<th scope='col'>Vorname</th>";
        echo                    "<th scope='col'>Nachname</th>";
        echo                    "<th scope='col'>Username</th>";
        echo                    "<th scope='col'>Email</th>";
        echo                    "<th scope='col'>Status</th>";
        echo                    "<th scope='col'>Verwalten</th>";
        echo                "</tr>";
        echo            "</thead>";
        echo            "<tbody>";
        $counter = 1;
        while($row = $result->fetch_assoc()){
            echo "<tr class='table-warning'>";
            echo "<form method='post'>";
            echo    "<th scope='row'>$counter</th>";
            echo        "<input type='hidden' name='email' value='{$row['email']}'>";
            echo        "<td>{$row['vorname']}</td>";
            echo        "<td>{$row['nachname']}</td>";
            echo        "<td>{$row['username']}</td>";
            echo        "<td>{$row['email']}</td>";
            // Bestimmet die Textfarbe basierend auf dem Reservierungsstatus
            $statusColor = '';
            if ($row["status"] == 'Aktiv') {
                $statusColor = 'success';
            } elseif ($row["status"] == 'Inaktiv') {
                $statusColor = 'danger';
            };
            echo       "<td class='text-$statusColor'>{$row['status']}</td>";
            echo       "<td>";

            // Zeigt Modal und Button nur für Reservierungen mit Status „neu“ anzeigen
            if ($row["status"] == "Aktiv") {
                echo "
                    <!-- Button trigger modal -->
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal_$counter' style='background: none; border: none;'>
                        <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='24' height='24' viewBox='0 0 48 48'>
                            <linearGradient id='wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1_red' x1='9.858' x2='38.142' y1='9.858' y2='38.142' gradientUnits='userSpaceOnUse'>
                                <stop offset='0' stop-color='#f44f5a'></stop>
                                <stop offset='1' stop-color='#e52030'></stop>
                            </linearGradient>
                            <circle fill='url(#wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1_red)' cx='24' cy='24' r='20'></circle>
                            <path fill='#fff' d='M31.071,15.515l1.414,1.414c0.391,0.391,0.391,1.024,0,1.414L18.343,32.485
                                c-0.391,0.391-1.024,0.391-1.414,0l-1.414-1.414c-0.391-0.391-0.391-1.024,0-1.414l14.142-14.142
                                C30.047,15.124,30.681,15.124,31.071,15.515z'></path>
                            <path fill='#fff' d='M32.485,31.071l-1.414,1.414c-0.391,0.391-1.024,0.391-1.414,0L15.515,18.343
                                c-0.391-0.391-0.391-1.024,0-1.414l1.414-1.414c0.391-0.391,1.024-0.391,1.414,0l14.142,14.142
                                C32.876,30.047,32.876,30.681,32.485,31.071z'></path>
                        </svg>
                    </button>

                        <!-- Modal -->
                        <div class='modal fade' id='exampleModal_$counter' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Deaktvieren</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <p>Sind Sie Sicher wollen sie der Benutzer deaktvieren</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Abbrechen</button>
                                        <button type='submit' class='btn btn-danger' name='userdeaktivieren'>Deaktivieren</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
            else{
                echo "
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal_$counter' style='background: none; border: none;'>
                        <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='24' height='24' viewBox='0 0 48 48'>
                            <linearGradient id='wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1_green' x1='9.858' x2='38.142' y1='9.858' y2='38.142' gradientUnits='userSpaceOnUse'>
                                <stop offset='0' stop-color='#4CAF50'></stop>
                                <stop offset='1' stop-color='#45A047'></stop>
                            </linearGradient>
                            <circle fill='url(#wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1_green)' cx='24' cy='24' r='20'></circle>
                            <path fill='#fff' d='M30.485,15.5l-10,10L17.515,23l-1.414,1.414l6,6L31.899,16.914L30.485,15.5z'></path>
                        </svg>
                    </button>
                    <div class='modal fade' id='exampleModal_$counter' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Aktivieren</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <p>Sind Sie Sicher wollen sie der Benutzer aktvieren</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Abbrechen</button>
                                        <button type='submit' class='btn btn-success' name='useraktivieren'>Aktivieren</button>
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
    }
    else{
        echo "<p class='pt-4' style='color:red; text-align:center;'>Kein Benutzer gefunden</p>";
    }
?>