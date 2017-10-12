<!DOCTYPE html>
<!--
Versión:1.0
Pantalla de recibimiento del administrador, permite crear editar o eliminar usuarios de bell rings
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
    
    //Carga datos para combobox de edicion
	$sql4 =  "SELECT DISTINCT(Nombre) AS Nombre1 FROM usuarios ORDER BY Nombre DESC;";
	$result4 = $mysqli->query($sql4);

	//Carga de datos para edicion
	//(Nombre,Dia,Hora,Fecha,Mes,Deshabilitada,Repeticiones,ID_Usuario)
	$IDJS[] = array();
    $NombreJS[] = array();
    $ClaveJS[] = array();
	$sql5 =  "SELECT * FROM usuarios";
	$result5 = $mysqli->query($sql5);
	while($rows5 = $result5->fetch_assoc()){ 
        $IDJS[] =  $rows5['ID'];
        $NombreJS[] = $rows5['Nombre'];
        $ClaveJS[] = $rows5['Clave'];
    }
    //convert the PHP array into JSON format, so it works with javascript
    $json_IDJS = json_encode($IDJS);
    $json_NombreJS = json_encode($NombreJS);
    $json_ClaveJS = json_encode($ClaveJS);
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
						<li class="selected-item"><a href=#>Create user</a></li>
						<!-- <li><a href="examples.html">Examples</a></li> -->
					</ul>
                    <ul>
						<li class="selected-item"><a href="Config.php">Configuration</a></li>
						<!-- <li><a href="examples.html">Examples</a></li> -->
					</ul>
	  				<ul>
						<li class="selected-item"><a href="logout.php"><?php echo $usrname;?> - Logout</a></li>
						<!-- <li><a href="examples.html">Examples</a></li> -->
					</ul>
				</nav>
			</aside>
			<section id="content" class="column-right" style="height:95%;">	
                <h4 style="margin:0px;">User Edit</h4>
			  	<table   cellspacing="0" cellpadding="2" class="table beauty-table table-hover ">
					<tr class="not_mapped_style" >
						<td align="center" width="30%" >Select Name</td>
					    <td width="30%" class="styled-select blue semi-square">
					        <select width="100%" name="nombrecombedit"  id="nombrecombedit"/>
                            <?php
                                echo "<option > Select </option>";
                                while($rows = $result4->fetch_assoc()){ 

                                	echo "<option value=" .$rows['Nombre1'] . ">" . $rows['Nombre1'] . "</option>";
                                }
                                echo "</select> "
                            ?>
					    </td>
                        <td align="center" width="20%" >
                            <input id="Beditar" name ="Beditar" class="myButton" type="submit" value="Edit" onclick="changedates();" />
                            <script type="text/javascript">
                            document.getElementById("Beditar").onclick = function () { 
                                var e = document.getElementById("nombrecombedit");
                                var nomcombedit = e.options[e.selectedIndex].text;
                                var json_IDJS = <?php echo $json_IDJS; ?>;
                                var json_NombreJS = <?php echo $json_NombreJS; ?>;
                                var json_ClaveJS = <?php echo $json_ClaveJS; ?>;
                                var btnCrear = document.getElementById("btnCrear");
                                btnCrear.value = "Update";
                                var Editform = document.getElementById("Edit");
                                Editform.value = '1';


                                var table = document.getElementById("tableform");
                                var rowCount = table.rows.length;
                                for (rowCount;rowCount>0;rowCount--)
                                {
                                    table.deleteRow(rowCount-1);
                                }
                                rowCount--;
                                //window.alert(json_NombreJS);
                                for (var i=0, iLen=json_NombreJS.length; i<iLen; i++) {

                                if (json_NombreJS[i] == nomcombedit) 
                                    {

                                        //window.alert(json_DeshabilitadaJS[1]);
                                        var row = table.insertRow(rowCount);
                                        rowCount++;
                                        var cell7 = row.insertCell(0);
                                        var element7 = document.createElement("input");
                                        element7.type = "hidden";
                                        element7.name = "ID"+rowCount;
                                        element7.id = "ID"+rowCount;
                                        element7.value = json_IDJS[i];
                                        cell7.appendChild(element7);



                                        //var cell2 = row.insertCell(1);
                                        var element1 = document.createElement("input");
                                        element1.type = "text";
                                        element1.name = "Nombre"+rowCount;
                                        element1.id = "Nombre"+rowCount;
                                        element1.value = json_NombreJS[i];
                                        cell7.appendChild(element1);

                                        var cell3 = row.insertCell(1);
                                        var element2 = document.createElement("input");
                                        element2.type = "text";
                                        element2.name = "Clave"+rowCount;
                                        element2.id = "Clave"+rowCount;
                                        element2.value = json_ClaveJS[i];
                                        cell3.appendChild(element2);


                                    }
                                }					
                             };
                            </script>
                        </td>
						<td align="center" width="20%" >
                            <input id="BtnBorrar" name ="BtnBorrar" class="Buttondel" type="submit" value="Delete" onclick="changedates();" />
                            <script type="text/javascript">
                                document.getElementById("BtnBorrar").onclick = function () { 
                                    var e = document.getElementById("nombrecombedit");
                                    var nomcombedit = e.options[e.selectedIndex].text;
                                    var r = confirm("Confirm Delete User ".concat(nomcombedit) );
                                    if (r == true) {
                                        var Editform = document.getElementById("Edit");
                                        Editform.value = '2';

                                        var Nombrefrom = document.getElementById("Nombre0");
                                        Nombrefrom.value = nomcombedit;
                                        document.getElementById("OrdenForm").submit();
                                    } 

                                }
                            </script>
                        </td>
                    </tr>
                </table>	
                <hr>
                <content  style="height:100%;   ">
                    <div id="Crear" name="crear" class="well cincuentapor " style="overflow:hidden; height:70%;">
                        <form id="OrdenForm" name= "OrdenForm" method="post" action="usr_BD.php" class="form-horizontal"  style="height:100%;   ">
                            <table   cellspacing="0" cellpadding="2" class="table beauty-table table-hover ">
                                <tr class="not_mapped_style"  >
                                    <td width="30%"    style="border-color: white; padding: 0px;"   >
                                        <H4 id="Crear_esquema" style="margin: 0px; ">Create User</H4>
                                    </td>
                                    <td width="40%"    style="border-color: white; padding: 0px;"   >
                                        <H5 id="Editadopor" style="margin: 0px; "></H5>
                                    </td>
                                    <td align="center" width="30%" style="border-color: white;">
                                        <input id="btnCrear" name="btnCrear" class="myButton" type="submit" value="Create" />
                                    </td> 
                                </tr>
                            </table>
                            <input class="col-sm-12" type="hidden" name="Edit" id="Edit" value='0' />
                            <div id="collapse1" class=" collapse in cienpor"  style="  height:100%;">
                                <div width="100%" style=" height:40px;">
                                    <table width="100%" id="tablehead1"  class="table beauty-table table-hover ">
                                        <thead width="100%">
                                            <tr width="100%">
                                                <th width="50%" class="not_mapped_style" style="text-align:center">Name</th>
                                                <th width="50%" class="not_mapped_style" style="text-align:center">Password</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div width="100%" style=" height:60%;	overflow-y: auto; overflow-x:  hidden;">
                                    <table width="100%" id="tableform"  class="table beauty-table table-hover table-usr ">
                                        <tbody width="100%">
                                            <tr width="98%">
                                                <td width="50%">
                                                    <input class="style-5" id= "Nombre0" name="Nombre0"  type="text">
                                                </td>
                                                <td width="50%">
                                                    <input class="style-5" id= "Clave0" name="Clave0"  type="text">
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