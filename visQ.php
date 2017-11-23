<?php
    session_start();
    
    function secondsToTime($s){
        $h = floor($s / 3600);
        $s -= $h * 3600;
        $m = floor($s / 60);
        $s -= $m * 60;
        return $h.':'.sprintf('%02d', $m).':'.sprintf('%02d', $s);
    }
    $koer =file_get_contents('koer.txt'); ;
    if (strpos($koer, $_SESSION["koenavn"])){

        include "../forbindelse.php";

        $sql = "select * from ".$_SESSION["koenavn"]." order by tidspunkt asc";
        $result= $forbindelse->query($sql);

        if($result->num_rows>0) { 
            echo "<br>";
            while($row=$result->fetch_assoc()){
                $navn = $row["navn"];
                $tidspunkt = $row["tidspunkt"];
                $t= secondsToTime(microtime(true)-$tidspunkt);
                echo "<div class='opstilling'>$navn</div><div class='opstilling'> $t </div>"; 
                if(isset($_SESSION["pwd"])){
                    echo "<form class='opstilling'> <input type='hidden' name='slettes' value='".$row['deltagernummer']."'><input class='slet' type='submit' value='X'></form><br>";
                }
                else if(isset($_SESSION["mig"]) ){
                     if(intval($_SESSION["mig"])== intval($tidspunkt)){
                        echo "<form class='f-slet'><button class='slet'  title='slet ".$_SESSION['mig']." fra køen'  name='sletmig' value='".$_SESSION['mig']."' type='submit'> X  </button></a></form><br>";
                    } else {echo "<br>"; }

                }else{ echo "<br>"; }
            }
            echo "<br>";
        }else{
            echo "køen er tom";
        }
        echo "<br>";
        $forbindelse->close();
    }else{
        echo "Køen eksisterer ikke.";
    }
?>