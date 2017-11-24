# QGIT
VEJLEDNINGSKØ

1. Upload filerne til en mappe - vilkårligt navn

2. Tilføj en fil, forbindelse.php, på samme niveau som mappen.

    filens indhold (udfyld de rigtige navne/password):

    <!--
    <?php
        $servername = "xxx";
        $username = "yyy";
        $password = "zzz";
        $dbname = qqq";

        $forbindelse = new mysqli($servername, $username, $password, $dbname);
        mysqli_set_charset($forbindelse, "utf8");
        if ($forbindelse->connect_error) {
            die("Connection failed: " . $forbindelse->connect_error);
        }
    ?>
    -->

3. I filen vejledning.php: af linje 5:
    $folder="http://helf-kea.dk/Q2/";
    til mappe-adressen på domæne.
