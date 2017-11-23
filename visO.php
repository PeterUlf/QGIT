<?php
    session_start();

    function secondsToTime($s){
        $h = floor($s / 3600);
        $s -= $h * 3600;
        $m = floor($s / 60);
        $s -= $m * 60;
        return $h.':'.sprintf('%02d', $m).':'.sprintf('%02d', $s);
    }
    
   
    if(isset($_SESSION["studerende"])){
        $varighed=secondsToTime(microtime(true)-$_SESSION["starttid"]);
        echo $_SESSION["studerende"]."*$varighed";
    }
?>