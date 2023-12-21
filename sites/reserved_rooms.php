<style>
    /* Add custom styles for the scrollable content */
    .accordion-body {
        overflow-y: scroll; /* Enable vertical scrolling */
    }
</style>
<?php
    //TODO the Reervation for admins
    include_once "navbar.php";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // holt die benutzerid vom datenbank, wobei die email adresse = session email adresse.
    $benutzerid = get_user();
    $sql = "SELECT anreisedatum,abreisedatum,fruehstuck,parkplatz,haustier,gesamtpreis,status,date(reservierungsdatum),reservierungsdatum
            FROM reservierung WHERE  benutzerid = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i",$benutzerid);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
        echo "
        <div class='container-fluid pt-4'>
            <div class='table-responsive'>
                <table class='table table-hover'>
                    <thead class='table-dark'>
                        <tr>
                            <th scope='col'>#</th>
                            <th scope='col'>Anreise Datum</th>
                            <th scope='col'>Abreise Datum</th>
                            <th scope='col'>Frühstück</th>
                            <th scope='col'>Parkplatz</th>
                            <th scope='col'>Haustier</th>
                            <th scope='col'>Status</th>
                            <th scope='col'>Gesamtpreis</th>
                            <th scope='col'>Reservierungsdatum</th>
                            <th scope='col'>Stornieren</th>
                        </tr>
                    </thead>
                    <tbody>
        ";

        $counter = 1;
        while ($row = $result->fetch_assoc()) {
            echo "
                <tr class='table-warning'>
                    <form method='post'>
                        <th scope='row'>$counter</th>
                        <input type='hidden' name='{$row['reservierungsdatum']}'>
                        <td>{$row['anreisedatum']}</td>
                        <td>{$row['abreisedatum']}</td>
                        <td>" . ($row['fruehstuck'] ? 'inklusiv' : 'nicht inklusiv') . "</td>
                        <td>" . ($row['parkplatz'] ? 'inklusiv' : 'nicht inklusiv') . "</td>
                        <td>" . ($row['haustier'] ? 'inklusiv' : 'nicht inklusiv') . "</td>
                        <td>{$row['status']}</td>
                        <td>{$row['gesamtpreis']}</td>
                        <td>{$row['date(reservierungsdatum)']}</td>
                        <td>
                        <button name='reservierungstornieren' type='submit' style='background: none; border: none;'>
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
                        </td>
                    </form>
                </tr>
            ";
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
            <p class='text-danger'>Sie haben kein Zimmer reserviert.</p>
            <button class='btn btn-dark'><a href='?rooms' class='text-white'>Zur Reservierung</a></button>
        </div>
        ";
}
?>
