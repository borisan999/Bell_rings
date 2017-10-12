<?php
/*
Versión:1.0
Guarda datos de agendamiento de timbres en base de datos, guardando los siguientes:
nombre
deshabilitado
repeticiones
hora
fecha
dia
mensualmente
ruta de cancion
nombre de usuario quien lo crea
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
    	//$arr[] = 4;
        foreach($_POST as $inputName => $inputValue)
        {
        	$arr[$inputName]= $inputValue;
        }
    }
    $rutamelodia = "/home/pi/Music/";
    $editao=0;
    $nueva=0;
    if($arr['Edit']==0)
    {
        $queryaskno = "SELECT * FROM agenda WHERE Nombre = '".$arr['Nombre']."'";
        $resultn = $mysqli->query($queryaskno);
        while($rows = $resultn->fetch_assoc())
        { 
            if (!is_null($rows["Nombre"]))
            {
                flash_message ('Error',"The name of the schema '".$arr['Nombre']."' is already registered in the database");
                $mysqli->close();
                echo "El nombre ".$arr['Nombre']." del esquema YA se encuentra resgistrado en la base de datos";
                if($DEBUG==0)
                {
                    header('Location: home.php');
                }
                break;
            }
        }
    }else if($arr['Edit']==2){
        $querydel = "DELETE FROM agenda WHERE Nombre = '".$arr['Nombre']."'";
        $mysqli->query($querydel);
        flash_message ('OK',"The  name of the schema '".$arr['Nombre']."' has been deleted in the database");
        $mysqli->close();
        if($DEBUG==0)
        {
            header('Location: home.php');
        }
    }
    $Deshabilitar=0;
    if(strcmp($arr['Deshabilitar'],'true') == 0)
    { 
        $Deshabilitar=1;
    }
    if((count($arr)-10)>0)
    {
        echo "llega con dos filas";
        $K=0;
        for($i = 5; $i < count($arr); $i = 5 + $i )
        {
            $Mes=0;
            $MesNN = "Mes".$K;
            $Dia = "Dia".$K;
            $Fecha = "Fecha".$K;
            $Hora = "Hora".$K;
            $Melodia = "Melodia".$K;
            $ID = "ID".$K;
            $RMelodia = $rutamelodia.$arr[$Melodia];
            if(strcmp($arr[$MesNN],'true') == 0)
            { 
                $Mes=1;
            }
            if($arr['Edit']==0)
            {
                $sql = "INSERT INTO agenda (Nombre,Dia,Hora,Fecha,Mes,Deshabilitada,Repeticiones,ID_Usuario,Melodia)
                 VALUES ('$arr[Nombre]','$arr[$Dia]','$arr[$Hora]','$arr[$Fecha]','$Mes','$Deshabilitar',$arr[Repite],'$id_usr','$RMelodia')";
                if($DEBUG==1)
                {
                    echo $sql;
                }
                $mysqli->query($sql);
                $nueva=1;
            }else
            {
               $sql = " UPDATE agenda SET Dia = '$arr[$Dia]',Hora = '$arr[$Hora]',Fecha = '$arr[$Fecha]',Mes = '$Mes',Deshabilitada = '$Deshabilitar', Repeticiones = '$arr[Repite]',ID_Usuario = '$id_usr',Melodia = '$RMelodia'
                   WHERE Nombre = '$arr[Nombre]' AND ID = '$arr[$ID]'";
                   $mysqli->query($sql);
                if($DEBUG==1)
                {
                    echo $sql;
                }
                    $editao=1;
            }
           
            $K =1 + $K;
        }
        
    }else
    { 
        $Mes=0;
        if(strcmp($arr['Mes0'],'true') == 0)
        { 
            $Mes=1;
        }
        echo "solo una fila";
        $RMelodia = $rutamelodia.$arr['Melodia0'];
        if($arr['Edit']==0)
        {
            $sql = "INSERT INTO agenda (Nombre,Dia,Hora,Fecha,Mes,Deshabilitada,Repeticiones,ID_Usuario,Melodia)
            VALUES ('$arr[Nombre]','$arr[Dia0]','$arr[Hora0]','$arr[Fecha0]','$Mes','$Deshabilitar',$arr[Repite],'$id_usr','$RMelodia')";
            $mysqli->query($sql);
            $nueva=1;
        }else
        {
           $sql = " UPDATE agenda SET Dia = '$arr[Dia0]',Hora = '$arr[Hora0]',Fecha = '$arr[Fecha0]',Mes = '$Mes',Deshabilitada = '$Deshabilitar', Repeticiones = '$arr[Repite]',ID_Usuario = '$id_usr',Melodia = '$RMelodia'
                   WHERE Nombre = '$arr[Nombre]' AND ID = '$arr[ID0]'";
                   $mysqli->query($sql);
            $editao=1;
        }
    }
    $mysqli->close();
    if ($nueva==1) {     
        flash_message ('OK',"The scheme of name '".$arr['Nombre']."' was saved correctly in database");
    } 
    if ($editao==1) {
        flash_message ('OK',"The scheme of name ".$arr['Nombre']." was edited correctly in database");
    }
    if($DEBUG==0)
    {
        header('Location: home.php');
    }
    function flash_message($type, $message) {
        $_SESSION['message'] = array('type' => $type, 'message' => $message);
    }
?>