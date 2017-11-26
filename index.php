<?php
    session_start();
    include "../forbindelse.php";
    $form="";
    $folder="http://mni-kea.dk/Q/";
    $test="";
    $options="";
    if(!isset($_SESSION["koenavn"]) or $_SESSION["koenavn"]==""){

        $i=0;
        $options="<option value='kø-navn'>kø-navn</option>";
        $koer =file_get_contents('koer.txt');
        $koer= explode(",", $koer);

        while ($i<count($koer)){
            $options.="<option value='";
            $options.=$koer[$i];
            $options.="'>";
            $options.=$koer[$i];
            $option.="</option>";
            $i++;
        }

        $test = "test";
    }else{
        $sql="SHOW TABLES LIKE 'q2_".$_SESSION["koenavn"]."'";
        $result=$forbindelse->query($sql);
        if($result->num_rows<1){
            header('Location: opretQ.php');
        }
    }
    if(isset($_REQUEST["Q"])){
        $_SESSION["koenavn"]=$_REQUEST["Q"];
        header('Location: index.php');
    }
    function secondsToTime($s){
        $h = floor($s / 3600);
        $s -= $h * 3600;
        $m = floor($s / 60);
        $s -= $m * 60;
        return $h.':'.sprintf('%02d', $m).':'.sprintf('%02d', $s);
    }
    function sletStud($nr, $f){
        $sql="SELECT navn FROM q2_".$_SESSION["koenavn"]." WHERE deltagernummer =".$nr;
        $result=$f->query($sql);
        if($result->num_rows>0) {
            while($row=$result->fetch_assoc()){
                $studnavn = $row["navn"];
                $_SESSION["studerende"]=$studnavn;
                $_SESSION["starttid"]=microtime(true);
            }
        }
        $sql="DELETE FROM q2_".$_SESSION["koenavn"]." WHERE deltagernummer =".$nr;
        $f->query($sql);
    }
    function sletmig($f){
        $sql="DELETE FROM q2_".$_SESSION["koenavn"]." WHERE tidspunkt ='" . $_SESSION["mig"]."'";
        $f->query($sql);
        unset($_SESSION["mig"]);
    }
    $output="";
    $fejloutput="";
    if( isset( $_REQUEST["navn"] ) ){
        if(isset($_SESSION["mig"])){
             $sql="select * from q2_".$_SESSION["koenavn"]." where tidspunkt='".$_SESSION["mig"]."'";
             $result=$forbindelse->query($sql);
            if($result->num_rows==0 AND !isset($_SESSION["pwd"])){
                unset($_SESSION["mig"]);
            }
        }
        if(!isset($_SESSION["mig"]) OR isset($_SESSION["pwd"])){
            $t=microtime(true);
            $sql="insert into q2_".$_SESSION["koenavn"]." (navn, tidspunkt, emne) values('".$_REQUEST['navn']."','".$t."','".$_REQUEST['emne']."')";
            $forbindelse->query($sql);

            $_SESSION["mig"]=$t;

            header('Location: index.php');
        } else {

            $fejloutput= "Hov, ".$_REQUEST["navn"]."! Du må kun stå i køen 1 gang.".
               "<form class='f-slet'><button name='sletmig' title='slet mig fra køen' value='".$_SESSION['mig']."' type='submit'> Slet mig fra køen </button></a></form>";
        }
    }else if(isset($_REQUEST["sletmig"])){
        sletmig($forbindelse);
        header('Location: index.php');
    }else if(isset($_REQUEST["slettes"])){
        sletStud($_REQUEST["slettes"],$forbindelse);
        header('Location: index.php');
    }
    else if(isset($_REQUEST["logud"])){
        //unset($_SESSION["vejledernavn"]);
        unset($_SESSION["pwd"]);
        unset($_SESSION["studerende"]);
        unset($_SESSION["starttid"]);
        header('Location: index.php');
    }
    if(isset($_SESSION["pwd"])){
        $output.="<button onclick='location.href=\"opretQ.php\"'>Ryd kø</button><button onclick='location.href=\"index.php?logud=true\"'>Log ud</button><br>";

    }
    $forbindelse->close();
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>kom på vejledningskø</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
        <style>
            * {
                padding: 0;
                margin: 0;
            }

            body,
            input,
            form,
            .knap,
            button {
                font-family: sans-serif;
                font-size: 1.5vw;
            }

            h1 {
                font-size: 2vw;
                display: inline-block;
            }

            .opstilling {
                display: inline-block;
                width: 12vw;
            }

            button {
                padding: 0.1vw;
            }

            .wrapper1 {
                width: 38vw;
                margin: auto;
                display: none;
            }

            .wrapper {
                width: 38vw;
                margin: auto;
                display: block;
            }

            img,
            iframe {
                width: 22vw;
            }

            iframe {
                width: 40vw;
                height: 60vw;
                border: 0;
            }

            input[type=text],
            input[type=submit],
            textarea,
            button,
            .slet {
                -webkit-transition: all 0.80s ease-in-out;
                -moz-transition: all 0.80s ease-in-out;
                -ms-transition: all 0.80s ease-in-out;
                -o-transition: all 0.80s ease-in-out;
                outline: none;
                border: none;
                padding: 5px;
                padding-left: 9px;
                padding-right: 9px;
                margin: 5px;
                background-color: lightgrey;
                color: darkgray;
                border-radius: 20px;

            }

            input[type=text]:focus,
            input[type=submit]:focus,
            textarea:focus {
                color: red;
                background-color: darkgrey;
                color: lightgray;
            }

            input[type=text]:hover,
            input[type=submit]:hover,
            textarea:hover,
            button:hover,
            .slet:hover {

                background-color: darkslategray;
                color: lightgray;
            }

            .f-slet {
                display: inline-block;
            }

            #urlcontainer {
                font-size: 0.7em;
                padding-bottom: 20px;
            }


            @media screen and (max-width: 800px) {
                * {
                    padding: 0;
                    margin: 0;
                }
                body,
                input,
                form,
                .knap,
                button {
                    font-family: sans-serif;
                    font-size: 1em;
                }
                h1 {
                    font-size: 2em;
                    display: inline-block;
                }
                .opstilling {
                    display: inline-block;
                    width: 30vw;
                }
                button {
                    padding: 0vw;
                }
                .wrapper {
                    width: 100vw;
                    margin: auto;
                }
                img,
                iframe {
                    width: 94vw;
                }
                iframe {
                    width: 100vw;
                    height: 100vh;
                    border: 0;
                }
            }

        </style>
    </head>

    <body>
        <div class="wrapper">
            <?php if ($test) { ?>
            <h2>1. Vælg kø</h2>
            Vælg kø:
            <select id="eksnavn">
               <?php echo $options; ?>
            </select>

            <form>
                <input id="koenavn" name="Q" type="hidden">

                <!--            <input type="text" name="vejledernavn" placeholder="undervisernavn" required ><br><br>-->
                <input name="submit" type="submit" value="Gå til køen">
            </form>
        </div>
        <script>
            $("#eksnavn").on("change", setname2);
            $("#eksnavn").on("input", setname2);

            function setname2() {
                $("#koenavn").val($("#eksnavn option:selected").val());
            }

        </script>

        <?php } else { ?>
        <h1>Vejledningskø:
            <?php
                    if(isset($_SESSION["koenavn"]) and $_SESSION["koenavn"]!=""){
                        echo $_SESSION["koenavn"];
                    }else {
                        echo "Ingen";
                    }
                ?>
        </h1>

        <div id="header"></div>

        <div>I kø:
            <div id="under"></div>
            <form class="kinput">
                <input type="text" name="navn" placeholder="Navn" required autofocus>
                <div id="emne_drop"></div>

                <input id="ny_emne" type="text" name="ny_emne" placeholder="Emne">


                <input id="emne" name="emne" type="hidden">
                <button type="submit">i kø</button>
            </form>
            <?php if(isset($_SESSION["mig"]))

                    echo $fejloutput; ?>
            <div id="queue"></div>
            <div id="adm">
                <?php echo $output; ?><br></div>
        </div>
        <div id="d"></div>
        <script>
            $(document).on("ready", opdater);

            $("#emne_drop").load("visEmne.php", opdaterEmne);

            function opdaterEmne() {

                $("#ny_emne").on("input", setemne);
                $("#eks_emne").on("change", setemne2);
                $("#eks_emne").on("input", setemne2);
            }

            function setemne() {
                $("#emne").val($(this).val());
            }


            function setemne2() {
                $("#emne").val($("#eks_emne option:selected").val());
            }

            function opdater() {
                $("#under").load("visO.php").css("display", "none");
                var a = $("#under").html().split("*");
                $("#queue").load("visQ.php");
            }
            setInterval(opdater, 10000);

        </script>

        <?php } ?>
    </body>

    </html>
