<?php
/*
Versión:1.0
Limpia todo y redirecciona a index.php 
Fecha: 20171012
Creado por: Boris Urrea
*/
//DESTROYS THE SESSION AND RETURNS
session_start();
session_unset();
session_destroy();
session_regenerate_id(true);
    header('location: index.php');
?>
