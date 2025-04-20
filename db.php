<?php
//Crear conexión base datos
$db_host = "localhost";
$db_username ="Liz";
$db_password="Lizet8888";
$db_database="alumnos";




$db = new mysqli($db_host,$db_username,$db_password, $db_database); //variable
mysqli_query($db, "SET NAMES 'utf8' ");

if($db->connect_errno > 0){
    die('No es posible conectarse a la BD ['. $db->connect_error . ']');
}
