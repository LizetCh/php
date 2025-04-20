<?php
    require("funciones.php");

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina con PHP</title>
    <!--Bootstrap-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.3.3/cosmo/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Hola mundo</h1>
    <?php 
    //Comentario
    $saludo="Buenas noches";
    $titulo = '<h1 class="text-danger">Hola desde PHP</h1>';
    echo $titulo;
    echo "Hola Liz " ,$saludo;
    $x=1;
    $contador=1;
    while($x<5)
    {
        $contador +=2;
        echo '<p>'. $contador . '<p>';
        $x +=1;
    }
    ?>
    <p>Hoy es <?=hoy()?></p>
</body>
</html>