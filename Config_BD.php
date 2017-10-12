<?php
/*
Versión:1.0
Guarda los datos de configuracion, siendo:
gpio
duracion
retardo
Fecha: 20171012
Creado por: Boris Urrea
*/
    if(!isset($_SESSION)){
        session_start();
    }
    $id_usr = $_SESSION['ID'];
    
    $DEBUG=0;
    include_once "connect_db.php";
    if(isset($_POST))
    {
    	$arr = array( );
        foreach($_POST as $inputName => $inputValue)
        {
        	$arr[$inputName]= $inputValue;
        }
    }
    $sql = " UPDATE Configuracion SET Pin_gpio = '$arr[GPIO]',Duracion = '$arr[Duration]', Retardo = '$arr[Delay]' WHERE ID = 1";
    $mysqli->query($sql);
    echo $sql;
    $editao=1;
    $mysqli->close();
    if ($editao==1) {
        flash_message ('OK',"The configuration is update");
    }
    if($DEBUG==0)
    {
        header('Location: Config.php');
    }
    function flash_message($type, $message) {
        $_SESSION['message'] = array('type' => $type, 'message' => $message);
    }
?>