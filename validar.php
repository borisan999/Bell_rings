<?php
/*
Versión:1.0
Valida usuario y contraseña ingresado en index.php y redirecciona a crearusr.php si los datos coinciden con el de administrador o a home.php, si estos están guardados en base de datos
Fecha: 20171012
Creado por: Boris Urrea
*/
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();
	require("connect_db.php");
	$username=$_POST['mail'];
	$pass=$_POST['pass'];
    if(!strcmp($username,"Admin"))
    {
        if(!strcmp($pass,"900007657"))
        {
            echo "buenas";
            $_SESSION['ID']=0;
			$_SESSION['userNombre']=$username;
            header('Location: crearusr.php');
        }else{
            echo '<script>alert("THIS USER DOES NOT EXIST, PLEASE REGISTER TO BE ABLE TO LOGIN")</script> ';
            header('Location: index.php');
        }
    }else{
        $sql2=mysqli_query($mysqli,"SELECT * FROM usuarios WHERE Nombre='$username'");
        if($f2=mysqli_fetch_assoc($sql2)){
            if($pass==$f2['Clave']){
                $_SESSION['ID']=$f2['ID'];
                $_SESSION['userNombre']=$f2['Nombre'];
                header('Location: home.php');
            }
        }
        else{	
            echo '<script>alert("THIS USER DOES NOT EXIST, PLEASE REGISTER TO BE ABLE TO LOGIN")</script> ';
            header('Location: index.php');
        }
    }
        
?>
