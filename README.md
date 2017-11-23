# QGIT
Vejledningskø
Upload filerne til en mappe. 
Tilføj filen forbindelse.php på samme niveau som mappen.
forbindelse.php skal indeholde login-info til sql-databasen:

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
