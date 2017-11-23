# QGIT
Vejledningskø

1. Upload filerne til en mappe - vilkårligt navn.

2. Tilføj en fil, forbindelse.php, på samme niveau som mappen.
Filen forbindelse.php skal have dette indhold (værdier tilpasses ens egen database):

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

3. I filen vejledning.php skal variablen $folder tilpasses: url-adressen på ens mappe.
