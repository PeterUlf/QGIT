<?php
    session_start();

    $i = 0;
    $emner = array();
    $options="<option value='kø-emne'>kø-emne</option>";

    $koer =file_get_contents('koer.txt'); ;
    if (strpos($koer, $_SESSION["koenavn"])){

        include "forbindelse.php";

        $sql = "select emne from q2_".$_SESSION["koenavn"]." order by emne asc";
        $result= $forbindelse->query($sql);

        if($result->num_rows>0) {

            while($row=$result->fetch_assoc()){
                array_push($emner,$row["emne"]);
            }



            $result = array_unique($emner);
            $result = array_values(array_filter($result));

            while ($i<count($result)){
                $options.="<option value='";
                $options.=$result[$i];
                $options.="'>";
                $options.=$result[$i];
                $option.="</option>";
                $i++;
            }


            echo "Vælg et emne <select id='eks_emne'>";
                echo $options;
            echo "</select> Eller opret et nyt";
        }else{
            echo "Skriv et emne";
        }
        echo "<br>";
        $forbindelse->close();
    }else{
        echo "Køen eksisterer ikke.";
    }
?>
