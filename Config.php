<!DOCTYPE html>
<!--
Versión:1.0
Formulario para la edición de valores de configuracion
gpio
duracion
retardo
Fecha: 20171012
Creado por: Boris Urrea
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Bell Rings</title>
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
        <link rel="stylesheet" href="css/estilos.css" type="text/css" />
        <meta name="viewport" content="width=device-width, height=device-height, minimum-scale=1.0, maximum-scale=1.0" />
        <script src="js/jquery-1.11.1.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/jquery.validate.js"></script>
    </head>
<?php
    if(!isset($_SESSION)){
	    session_start();
	}
	if(!isset($_SESSION['ID'])) {
        header('location: logout.php');
    }
     $mestype  = "";
     $mess = "";
    if(isset($_SESSION['message'])) {
        $mestype = $_SESSION['message']['type'];
        $mess = $_SESSION['message']['message'];
        unset($_SESSION['message']);
    }
	$id_usr = $_SESSION['ID'];
 	$usrname = $_SESSION['userNombre'];
	include_once "connect_db.php";
    $sql =  "SELECT * FROM Configuracion";
	$result = $mysqli->query($sql);
    while($rows = $result->fetch_assoc()){
        $Pin_gpio =  $rows['Pin_gpio'];
        $Duracion =  $rows['Duracion'];
        $Retardo =  $rows['Retardo'];
    }
?>
<script type="text/javascript">
    //window.alert("test");
    var mensaje = <?php echo json_encode($mess);?>;
    if(mensaje)
    window.alert(mensaje);
</script>
    <body>
		<section id="body" class="onehundred" >
			<aside id="sidebar" class="column-left">
				<header>
					<img class="logo-sidebar" src="imagenes/Logo-Bell-Rings.png">
					<img class="logo-sidebar" src="imagenes/logo_cng.png">
					<img class="logo-sidebar" src="imagenes/logo_smal.png">
				</header>
				<nav id="mainnav">
                    <ul>
						<li class="selected-item"><a href="crearusr.php">Create user</a></li>
					</ul>
                    <ul>
						<li class="selected-item"><a href=#>Configuration</a></li>
					</ul>
	  				<ul>
						<li class="selected-item"><a href="logout.php"><?php echo $usrname;?> - Logout</a></li>
					</ul>
				</nav>
			</aside>
			<section id="content" class="column-right" style="height:95%;">	
                <h4 style="margin:0px;"></h4>
                <content  style="height:100%;   ">
                    <div id="Crear" name="crear" class="well cincuentapor " style="overflow:hidden; height:70%;">
                        <form id="OrdenForm" name= "OrdenForm" method="post" action="Config_BD.php" class="form-horizontal"  style="height:100%;   ">
                            <table   cellspacing="0" cellpadding="2" class="table beauty-table table-hover ">
                                <tr class="not_mapped_style"  >
                                    <td width="30%"    style="border-color: white; padding: 0px;"   >
                                        <H4 id="Crear_esquema" style="margin: 0px; ">Configuration</H4>
                                    </td>
                                    <td width="40%"    style="border-color: white; padding: 0px;"   >
                                        <H5 id="Editadopor" style="margin: 0px; "></H5>
                                    </td>
                                    <td align="center" width="30%" style="border-color: white;">
                                        <input id="btnCrear" name="btnCrear" class="myButton" type="submit" value="Save" />
                                    </td> 
                                </tr>
                            </table>
                            <input class="col-sm-12" type="hidden" name="Edit" id="Edit" value='0' />
                            <div id="collapse1" class=" collapse in cienpor"  style="  height:100%;">
                                <div width="100%" style=" height:40px;">
                                    <table width="100%" id="tablehead1"  class="table beauty-table table-hover ">
                                        <thead width="100%">
                                            <tr width="100%">
                                                <th width="34%" class="not_mapped_style" style="text-align:center">GPIO</th>
                                                <th width="33%" class="not_mapped_style" style="text-align:center">Duration</th>
                                                <th width="33%" class="not_mapped_style" style="text-align:center">Delay</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div width="100%" style=" height:60%;	overflow-y: auto; overflow-x:  hidden;">
                                    <table width="100%" id="tableform"  class="table beauty-table table-hover table-usr ">
                                        <tbody width="100%">
                                            <tr width="98%">
                                                <td width="34%">
                                                    <input class="style-5" id= "GPIO" name="GPIO"  type="text" value="<?php echo $Pin_gpio;?>">
                                                </td>
                                                <td width="33%">
                                                    <input class="style-5" id= "Duration" name="Duration"  type="text" value="<?php echo $Duracion;?>">
                                                </td>
                                                <td width="33%">
                                                    <input class="style-5" id= "Delay" name="Delay"  type="text" value="<?php echo $Retardo;?>">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </content>
            </section>
            <div class="clear"></div>
        </section>
    </body>
</html>