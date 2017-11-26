<?php
    session_start();
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

    if(isset($_REQUEST["submit"])){ 
       if($_REQUEST["pwd"]=="hemmelig"){
           $_SESSION["pwd"]="hemmelig";
           //$_SESSION["vejledernavn"]=$_REQUEST["vejledernavn"];
           if($_REQUEST["koenavn"]!=""){
               $navn=$_REQUEST["koenavn"]; 
               $navn= strip_tags($_REQUEST["koenavn"]);
               $navn=preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $navn);
               $navn=str_replace(' ', '', $navn);
               $navn=str_replace('.', '', $navn);
               $navn=str_replace(':', '', $navn);
               $navn=str_replace(';', '', $navn);
               $navn=str_replace(',', '', $navn);
               $navn=str_replace('-', '', $navn);
               $navn=str_replace('$', '', $navn);
                $_SESSION["koenavn"]=$navn;
                $koer =file_get_contents('koer.txt');;
               if(!strpos($koer, $navn)){
                   $koer=$koer . "," . $navn;
                }
               
                file_put_contents('koer.txt',$koer);
            }else{
               die("<div style='color:red; cursor:pointer' onclick='history.go(-1)'>ingen kø blev valgt</div> ");
           }
           header('Location: index.php');
       } 
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Administration af vejledningskø</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

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
            }

            h1 {
                font-size: 2em;
                display: inline-block;
            }

            h2 {
                font-size: 1.5em;
            }

            .opstilling {
                display: inline-block;
                width: 9vw;
            }

            button {
                padding: 0.1vw;
            }

            .wrapper1 {
                width: 31vw;
                margin: auto;
                display: none;
            }

            .wrapper {
                width: 31vw;
                margin: auto;
                display: block;
            }

            img,
            iframe {
                width: 29vw;
            }

            iframe {
                width: 40vw;
                height: 60vw;
                border: 0;
            }

            input[type=text],
            input[type=submit],
            input[type=password],
            select,
            textarea,
            button,
            .slet {
                -webkit-transition: all 0.80s ease-in-out;
                -moz-transition: all 0.80s ease-in-out;
                -ms-transition: all 0.80s ease-in-out;
                -o-transition: all 0.80s ease-in-out;
                outline: none;
                padding: 5px 0px 5px 5px;
                margin: 5px 1px 5px 0px;
                border: 1px solid #666666;
            }

            input[type=text]:focus,
            input[type=submit]:focus,
            input[type=password]:focus,
            textarea:focus {
                box-shadow: 0 0 10px rgba(255, 192, 203, 1);
                padding: 5px 0px 5px 5px;
                margin: 5px 1px 5px 0px;
                border: 1px solid rgba(255, 192, 203, 1);
            }

            input[type=text]:hover,
            input[type=submit]:hover,
            input[type=password]:hover,
            textarea:hover,
            button:hover,
            .slet:hover {
                box-shadow: 0 0 10px rgba(255, 192, 203, 1);
                padding: 5px 0px 5px 5px;
                margin: 5px 1px 5px 0px;
                border: 1px solid rgba(255, 192, 203, 1);
                position: relative;
            }

            .f-slet {
                display: inline-block;
            }

            #urlcontainer {
                font-size: 0.5em;
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
            <h1>Administration af kø: </h1>

            <h2>1. Vælg kø</h2>
            Vælg kø:
            <select id="eksnavn">
               <?php echo $options; ?> 
            </select><br> eller tilføj ny kø:
            <input type="text" id="nynavn" placeholder="kø-navn" autofocus><br>

            <h2>2. Log ind</h2>
            <form>
                <input id="koenavn" name="koenavn" type="hidden">

                <!--            <input type="text" name="vejledernavn" placeholder="undervisernavn" required ><br><br>-->
                <input type="password" name="pwd" placeholder="hemmeligt password" required><br><br>
                <input name="submit" type="submit" value="Gå til køen">
            </form>
            (nye køer slettes jævnligt)
        </div>
        <script>
            $("#nynavn").on("input", setname);

            function setname() {
                $("#koenavn").val($(this).val());
            }
            $("#eksnavn").on("change", setname2);
            $("#eksnavn").on("input", setname2);

            function setname2() {
                $("#koenavn").val($("#eksnavn option:selected").val());
            }

        </script>
    </body>

    </html>
