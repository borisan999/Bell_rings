<?php
/*
Versión:1.0
Guarda en base de datos un nuevo usuario, permite editar o eliminar
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
    $editao=0;
    $nueva=0;
    if($arr['Edit']==0)
    {
        $queryaskno = "SELECT * FROM usuarios WHERE Nombre = '".$arr['Nombre0']."'";
        $resultn = $mysqli->query($queryaskno);
        while($rows = $resultn->fetch_assoc())
        { 
            if (!is_null($rows["Nombre"]))
            {
                flash_message ('Error',"The name of the user '".$arr['Nombre']."' is already registered in the database");
                $mysqli->close();
                if($DEBUG==0)
                {
                    header('Location: crearusr.php');
                }
                break;
            }
        }
    }else if($arr['Edit']==2){
        $querydel = "DELETE FROM usuarios WHERE Nombre = '".$arr['Nombre0']."'";
        $mysqli->query($querydel);
        flash_message ('OK',"The  name of the user '".$arr['Nombre0']."' has been deleted in the database");
        $mysqli->close();
        if($DEBUG==0)
        {
            header('Location: crearusr.php');
        }
    }
    if($arr['Edit']==0)
    {
        $sql = "INSERT INTO usuarios (Nombre,Clave)
        VALUES ('$arr[Nombre0]','$arr[Clave0]')";
        $mysqli->query($sql);
        $nueva=1;
    }else if($arr['Edit']==1)
    {
       $sql = " UPDATE usuarios SET Nombre = '$arr[Nombre0]',Clave = '$arr[Clave0]' WHERE ID = '$arr[ID0]'";
               $mysqli->query($sql);
        //echo $sql;
        $editao=1;
    }
    $mysqli->close();
    if ($nueva==1) {     
        flash_message ('OK',"The user of name '".$arr['Nombre0']."' was saved correctly in database");
    } 
    if ($editao==1) {
        flash_message ('OK',"The user of name '".$arr['Nombre0']."' was edited correctly in database");
    }
    if($DEBUG==0)
    {
        header('Location: crearusr.php');
    }
    function flash_message($type, $message) {
        $_SESSION['message'] = array('type' => $type, 'message' => $message);
    }
?>