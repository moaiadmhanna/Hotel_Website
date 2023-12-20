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
    $sql = "SELECT anreisedatum,abreisedatum,fruehstuck,parkplatz,haustier,gesamtpreis,status,date(reservierungsdatum)
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
                        </tr>
                    </thead>
                    <tbody>
        ";

        $counter = 1;
        while ($row = $result->fetch_assoc()) {
            echo "
                <tr class='table-warning'>
                    <th scope='row'>$counter</th>
                    <td>{$row['anreisedatum']}</td>
                    <td>{$row['abreisedatum']}</td>
                    <td>" . ($row['fruehstuck'] ? 'inklusiv' : 'nicht inklusive') . "</td>
                    <td>" . ($row['parkplatz'] ? 'inklusiv' : 'nicht inklusive') . "</td>
                    <td>" . ($row['haustier'] ? 'inklusiv' : 'nicht inklusive') . "</td>
                    <td>{$row['status']}</td>
                    <td>{$row['gesamtpreis']}</td>
                    <td>{$row['date(reservierungsdatum)']}</td>
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
