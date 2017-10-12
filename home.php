<!DOCTYPE html>
<!--
Versión:1.0
Home de Bell Rings
Realiza busqueda y carga valores para tabla de timbres del día
Carga esquemas de alarmas para permitir edición o eliminar
permite accionar reles de manera manual oprimiendo un botón, esta acción se completa en gpioBR.php
Crea esquemas de alarmas, permitiendo generar N filas conteniendo
Nombre
Repeticiones
Deshabilitada
Hora
Fecha
Dia
Mes(si se repite cada mes)
ruta de música (carga ewn combobox los archivos que se encuentren en /home/pi/Music) 
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
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
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
	///Carga valores para la tabla timbres del dia
	$NombreArr = array();
	$HoraArr = array();
	$sql2 =  "SELECT Nombre, Hora FROM agenda WHERE DATE_FORMAT(Fecha,'%d%m') = DATE_FORMAT(cast(now() as date),'%d%m') AND Deshabilitada = 0"; ///de la fecha actual
	$result2 = $mysqli->query($sql2);
	while($rows2 = $result2->fetch_assoc()){ 
		$NombreArr[] = $rows2['Nombre'];
		$HoraArr[] = $rows2['Hora'];
	}

	$sql4 =  "SELECT Nombre, Hora FROM agenda WHERE DATE_FORMAT(Fecha,'%d') = DATE_FORMAT(cast(now() as date),'%d') AND Deshabilitada = 0 AND Mes = 1"; ///de la fecha actual
	$result4 = $mysqli->query($sql4);
	while($rows4 = $result4->fetch_assoc()){ 
		$NombreArr[] = $rows4['Nombre'];
		$HoraArr[] = $rows4['Hora'];
	}


	$sql3 =  "select Nombre, Hora from agenda where dia = DAYOFWEEK(now()) AND Deshabilitada = 0";// del dia actual
	$result3 = $mysqli->query($sql3);
	while($rows3 = $result3->fetch_assoc()){ 
		$NombreArr[] = $rows3['Nombre'];
		$HoraArr[] = $rows3['Hora'];
	}

	//Carga datos para combobox de edicion
	$sql4 =  "SELECT DISTINCT(Nombre) AS Nombre1 FROM agenda ORDER BY Nombre DESC;";
	$result4 = $mysqli->query($sql4);
	//Carga de datos para edicion	//(Nombre,Dia,Hora,Fecha,Mes,Deshabilitada,Repeticiones,ID_Usuario)
	$IDJS[] = array();
    $NombreJS[] = array();
    $DiaJS[] = array();
    $HoraJS[] = array();
    $FechaJS[] = array();
    $MesJS[] = array();
    $DeshabilitadaJS[] = array();
    $RepeticionesJS[] = array();
    $MelodiaJS[] = array();
    $ID_UsuarioJS[] = array();
	$RepetidoJS[] = array();
	$Nombre_UsuarioJS[] = array();
	$sql5 =  "SELECT agenda.ID as aID, agenda.Nombre as aNombre, agenda.Dia as aDia, agenda.Hora as aHora, agenda.Fecha as aFecha, agenda.Mes as aMes, agenda.Deshabilitada as aDeshabilitada, agenda.Repeticiones as aRepeticiones,agenda.Repetido as aRepetido, agenda.Melodia as aMelodia, agenda.ID_Usuario as aID_Usuario, usuarios.Nombre as Unombre FROM agenda LEFT JOIN usuarios ON agenda.ID_Usuario = usuarios.ID;";
	$result5 = $mysqli->query($sql5);
	while($rows5 = $result5->fetch_assoc()){ 
	$IDJS[] =  $rows5['aID'];
        $NombreJS[] = $rows5['aNombre'];
        $DiaJS[] = $rows5['aDia'];
        $HoraJS[] = $rows5['aHora'];
        $FechaJS[] = $rows5['aFecha'];
        $MesJS[] = $rows5['aMes'];
        $DeshabilitadaJS[] = $rows5['aDeshabilitada'];
        $RepeticionesJS[] = $rows5['aRepeticiones'];
        $MelodiaJS[] = substr($rows5['aMelodia'], strrpos($rows5['aMelodia'], '/') + 1);
        $RepetidoJS[] = $rows5['aRepetido'];
        $ID_UsuarioJS[] = $rows5['aID_Usuario'];
        $Nombre_UsuarioJS[] = $rows5['Unombre'];
    }
    //convert the PHP array into JSON format, so it works with javascript
    $json_IDJS = json_encode($IDJS);
    $json_NombreJS = json_encode($NombreJS);
    $json_DiaJS = json_encode($DiaJS);
    $json_HoraJS = json_encode($HoraJS);
    $json_FechaJS = json_encode($FechaJS);
    $json_MesJS = json_encode($MesJS);
    $json_DeshabilitadaJS = json_encode($DeshabilitadaJS);
    $json_RepeticionesJS = json_encode($RepeticionesJS);
    $json_RepetidoJS = json_encode($RepetidoJS);
    $json_MelodiaJS = json_encode($MelodiaJS);
    $json_ID_UsuarioJS = json_encode($ID_UsuarioJS);
    $json_Nombre_UsuarioJS = json_encode($Nombre_UsuarioJS);
    
    //Carga nombres de canciones que esten en la carpeta 
    $rutamelodia = "/home/pi/Music/";
    //$rutamelodia = "/var/www/html/Bell_Rings/Defaultsounds";
    $filesmel = scandir($rutamelodia);
    $json_filesmel = json_encode($filesmel);
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
					<!-- <h2>Welcome to my website!</h2> -->
					
				</header>

				<nav id="mainnav">
	  				<ul>
						<li class="selected-item"><a href="logout.php"><?php echo $usrname;?> - Logout</a></li>
						<!-- <li><a href="examples.html">Examples</a></li> -->
					</ul>
				</nav>
			</aside>
			<section id="content" class="column-right" style="height:95%;">	
		    <article class="column-left" style=" width:30%; ">
		    <h4 style=" height:20px; margin: 0px">
	              	Bells of the Day
	          	</h4>
	          		<div  style=" height:30px;" >
	            		<table   cellspacing="0" cellpadding="2" class="table beauty-table table-hover ">
	              			<thead >  
	                			<tr>
				                    <th width="60%" class="not_mapped_style" style="text-align:center"><strong>Name</strong></th>
				                    <th width="40%" class="not_mapped_style" style="text-align:center"><strong>Hour</strong></th>                    
				                </tr>
				            </thead >
	          			</table>
	      			</div>
	      			<div id="contenido" style="   overflow: auto; font-size:14px; height:90%;" >
	        			<table   cellspacing="0" cellpadding="2" class="table beauty-table table-hover ">
				          	<tbody>
							<?php
								$count3 =0;
								if(!empty($NombreArr))
								{
				                	foreach ($NombreArr as $nombres2) {
				            ?>
			                    <tr class="not_mapped_style " style="height:30px">
									<td align="center" width="60%"><?php echo utf8_encode($nombres2); ?></td>
									<td align="center" width="40%"><?php echo utf8_encode($HoraArr[$count3]); ?></td>
								</tr>
		            		<?php
				                		$count3 = $count3 +1;
				            		}
				            	}
			            	?>
					        </tbody>
					    </table>
		      		</div>
			</article>
			 <article class="column-right" style=" width:65%; height:100%;">
				<h4 style="margin:0px;">Manual Action</h4>
				<form id="timbreform" method="get" action="gpioBR.php">
			                <input style="width:24%;" class="myButton" type="submit" value="Bell 1" name="Timbre1">
					<input style="width:24%;" class="myButton" type="submit" value="Bell 2" name="Timbre2">
					<input style="width:24%;" class="myButton" type="submit" value="Bell 3" name="Timbre3">
					<input style="width:24%;" class="myButton" type="submit" value="Bell 4" name="Timbre4">
        			</form>
				<hr>
			  	<h4 style="margin:0px;">Alarm Settings</h4>
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
							var json_DiaJS = <?php echo $json_DiaJS; ?>;
							var json_HoraJS = <?php echo $json_HoraJS; ?>;
							var json_FechaJS = <?php echo $json_FechaJS; ?>;
							var json_MesJS = <?php echo $json_MesJS; ?>;
							var json_DeshabilitadaJS = <?php echo $json_DeshabilitadaJS; ?>;
							var json_RepeticionesJS = <?php echo $json_RepeticionesJS; ?>;
							var json_RepetidoJS = <?php echo $json_RepetidoJS; ?>;
                            var json_MelodiaJS = <?php echo $json_MelodiaJS; ?>;
							var json_ID_UsuarioJS = <?php echo $json_ID_UsuarioJS; ?>;
							var json_Nombre_UsuarioJS = <?php echo $json_Nombre_UsuarioJS; ?>;
                            var json_filesmel = <?php echo $json_filesmel; ?>;
                            


							var Nombrefrom = document.getElementById("Nombre");
							Nombrefrom.value = nomcombedit;
							var Deshabilitarfrom = document.getElementById("Deshabilitar");
							var Repitefrom = document.getElementById("Repite");
							var Crear_esquemafrom = document.getElementById("Crear_esquema");
							Crear_esquemafrom.innerHTML = "Edit";
							var Editadoporfrom = document.getElementById("Editadopor");
							var agregarffrom = document.getElementById("agregarf");
							agregarffrom.innerHTML = " ";
	

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
									Repitefrom.value = json_RepeticionesJS[i];
									if (json_DeshabilitadaJS[i] == 1) 
									{
										Deshabilitarfrom.checked = true;
									}else if (json_DeshabilitadaJS[i] == 0) 
									{
										Deshabilitarfrom.checked = false;
									}
									var activado = "<br>Repited ".concat(json_RepetidoJS[i]);
									var creado = "Created by ".concat(json_Nombre_UsuarioJS[i]);
									if(json_RepetidoJS[i] == 0)
									{  
										Editadoporfrom.innerHTML = creado;
									}else
									{
										Editadoporfrom.innerHTML = creado.concat(activado);
									}
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

									//window.alert(json_NombreJS[i]);
									var element6 = document.createElement("input");
									element6.type = "hidden";
									element6.name = "Mes"+rowCount;
									element6.id = "Mes"+rowCount;
									element6.value = "false"
									cell7.appendChild(element6);
									
									//var cell2 = row.insertCell(1);
									var element1 = document.createElement("input");
									element1.type = "time";
									element1.name = "Hora"+rowCount;
									element1.id = "Hora"+rowCount;
									element1.value = json_HoraJS[i];
									element1.style.backgroundColor = "#ffffff";
									element1.style.border = "solid 1px #e5e5e5";
									cell7.appendChild(element1);

									var cell3 = row.insertCell(1);
									var element2 = document.createElement("input");
									element2.type = "date";
									element2.name = "Fecha"+rowCount;
									element2.id = "Fecha"+rowCount;
									element2.value = json_FechaJS[i];
									element2.style.backgroundColor = "#ffffff";
									element2.style.border = "solid 1px #e5e5e5";
									cell3.appendChild(element2);
									
									var cell4 = row.insertCell(2);
									var element3 = document.createElement("select");
									element3.name = "Dia"+rowCount;
						    		var option1 = document.createElement("option");
									option1.value="";
									option1.innerHTML="Select" ;
									element3.appendChild(option1);
									var option2 = document.createElement("option");
									option2.value="2";
									option2.innerHTML="Monday" ;
									element3.appendChild(option2);
									var option3 = document.createElement("option");
									option3.value="3";
									option3.innerHTML="Tuesday" ;
									element3.appendChild(option3);
									var option4 = document.createElement("option");
									option4.value="4";
									option4.innerHTML="Wednesday" ;
									element3.appendChild(option4);
									var option5 = document.createElement("option");
									option5.value="5";
									option5.innerHTML="Thursday" ;
									element3.appendChild(option5);
									var option6 = document.createElement("option");
									option6.value="6";
									option6.innerHTML="Friday" ;
									element3.appendChild(option6);
									var option7 = document.createElement("option");
									option7.value="7";
									option7.innerHTML="Saturday" ;
									element3.appendChild(option7);
									var option8 = document.createElement("option");
									option8.value="1";
									option8.innerHTML="Sunday" ;
									element3.appendChild(option8);
									if(json_DiaJS[i]==0)
									{
										element3.selectedIndex = 0;
									}else{
										element3.selectedIndex = json_DiaJS[i]-1;
									}
									element3.style.backgroundColor = "#ffffff";
									cell4.appendChild(element3);

									var cell6 = row.insertCell(3);
									var element5 = document.createElement("input");
									element5.type = "checkbox";
									element5.name = "Mes"+rowCount;
									element5.id = "Mes"+rowCount;
									element5.value = "true";
									if (json_MesJS[i] == 1) 
									{
										element5.checked = true;
									}
									element5.style.backgroundColor = "#ffffff";
									element5.style.border = "solid 1px #e5e5e5";
									cell6.appendChild(element5);
                                    
                                    var cell7 = row.insertCell(4);
                                    var element6 = document.createElement("select");
									element6.name =  "Melodia"+rowCount;
                                    var options_C = [];
                                    var option_C = document.createElement('option');
                                    //window.alert(json_filesmel[2]);
                                    var index=0;
                                    for(j = 2; j < json_filesmel.length; j++) {
                                        //window.alert(json_filesmel[j]);
                                        // window.alert(j);
                                        option_C.text = json_filesmel[j] ;
                                        //window.alert(arr[i].Name_E);
                                        option_C.value = json_filesmel[j];
                                        option_C.id = json_filesmel[j];
                                        if(json_MelodiaJS[i]==json_filesmel[j])
                                            {
                                                index=j-2;
                                            }
                                        //option_C.value = arr[i].Direccion_C;
                                        options_C.push(option_C.outerHTML);
                                    }
                                    element6.insertAdjacentHTML('beforeEnd', options_C.join('\n'));
                                    element6.selectedIndex = index;
                                    cell7.appendChild(element6);

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
								var r = confirm("Confirm Delete scheme ".concat(nomcombedit) );
								if (r == true) {
								    var Editform = document.getElementById("Edit");
									Editform.value = '2';
									
									var Nombrefrom = document.getElementById("Nombre");
									Nombrefrom.value = nomcombedit;
									document.getElementById("OrdenForm").submit();
								} 
								
							}
						</script>

						</tr>
					</tr>
				</table>	
<hr>
                <content  style="height:100%;   ">
			<div id="Crear" name="crear" class="well cincuentapor " style="overflow:hidden; height:70%;">
				<form id="OrdenForm" name= "OrdenForm" method="post" action="Entrada_BD.php" class="form-horizontal"  style="height:100%;   ">
				<table   cellspacing="0" cellpadding="2" class="table beauty-table table-hover ">
						<tr class="not_mapped_style"  >
							<td width="30%"    style="border-color: white; padding: 0px;"   >
	      						<H4 id="Crear_esquema" style="margin: 0px; ">Create Scheme</H4>
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
					<div class="col-sm-12" style="padding: 0px 0px 10px 0px;">
						<label class="col-sm-6 control-label">Name</label>
						<input class="col-sm-6 style-5" id= "Nombre" name="Nombre" maxlength="20" type="text" style="height:20px;   " >
						<div style="float: right;">
							<input type="hidden"   name="Deshabilitar" value="false" />
							<input type="checkbox" name="Deshabilitar" id="Deshabilitar" value="true" style="float: right;"/> Disable
						</div>
					</div>
					<div class="col-sm-12" style="padding: 0px 0px 10px 0px;">
						<label class="col-sm-4 control-label">Repetitions</label>
						<input class="col-sm-4 style-5" id= "Repite" name="Repite"  value="0"   maxlength="10" type="text" onkeypress='return event.charCode >= 46 && event.charCode<= 57' style="height:20px;   " >
						<div id="agregarf" style="float: right;">
							<label  class="col-sm-4 control-label">Add Row</label>
							<i id="clickMe" type="button" onclick="doFunction();" style="cursor:pointer;">
								<img id="icono_mas" onmouseover="mouseOver()" onmouseout="mouseOut()" src="imagenes/icono_mas.png">
								<script >
									function mouseOver(){
										document.getElementById("icono_mas").src = "imagenes/icono_mas_hover.png";
									}
									function mouseOut(){
										document.getElementById("icono_mas").src = "imagenes/icono_mas.png";
									}

								</script>
							</i> 
						</div>
					</div>
					<div width="100%" style=" height:40px;">
						<table width="100%" id="tablehead1"  class="table beauty-table table-hover ">
							<thead width="100%">
								<tr width="100%">
									<th width="18%" class="not_mapped_style" style="text-align:center">Hour</th>
									<th width="20%" class="not_mapped_style" style="text-align:center">Date</th>
									<th width="18%" class="not_mapped_style" style="text-align:center;">Day</th>
									<th width="14%" class="not_mapped_style" style="text-align:center;">Monthly</th>
                                    <th width="30%" class="not_mapped_style" style="text-align:center;">Sound</th>
								</tr>
							</thead>
						</table>
					</div>
					<div width="100%" style=" height:60%;	overflow-y: auto; overflow-x:  hidden;">
						<table width="100%" id="tableform"  class="table beauty-table table-hover table-crear ">
							<tbody width="100%">
								<tr width="98%">
									<td width="18%">
										
										<input class="style-5" id= "Hora0" name="Hora0"  type="time">
									</td>
									<td width="20%" ><input class="style-5" id= "Fecha0" name="Fecha0" type="date" ></td>
									<td width="18%">
										<select width="100%" name="Dia0"  id="Dia0"/>
										<option > select </option>
								        <option value=2> Monday </option>
								        <option value=3> Tuesday </option>
								        <option value=4> Wednesday </option>
								        <option value=5> Thursday </option>
								        <option value=6> Friday </option>
								        <option value=7> Saturday </option>
								        <option value=1> Sunday </option>
									</td>
									<!-- <td width="10%"><input type="checkbox" name="Semana0"  /></td> -->
									<td width="14%">
										<input type="hidden"   name="Mes0" value="false" />
										<input type="checkbox" name="Mes0" value="true" />
									</td>
                                    <td width="30%">
                                        <select width="100%" name="Dia0"  id="Dia0"/>
                                        <?php
                                        foreach ($filesmel as $melodia ) {
                                            if($melodia==".")
                                                continue;
                                            if($melodia=="..")
                                                continue;
                                            echo "<option value=$melodia> $melodia </option>";
                                        }
                                        ?>
									</td>
									<script type="text/javascript">
									document.getElementById("clickMe").onclick = function () { 
                                        var json_filesmel = <?php echo $json_filesmel; ?>;

										var table = document.getElementById("tableform");
										var rowCount = table.rows.length;
										var row = table.insertRow(rowCount);

										var cell7 = row.insertCell(0);
										var element7 = document.createElement("input");
										element7.type = "hidden";
										element7.name = "ID"+rowCount;
										element7.id = "ID"+rowCount;
										element7.value = "0";
										cell7.appendChild(element7);

										//window.alert(json_NombreJS[i]);
										var element6 = document.createElement("input");
										element6.type = "hidden";
										element6.name = "Mes"+rowCount;
										element6.id = "Mes"+rowCount;
										element6.value = "false"
										cell7.appendChild(element6);

										//Creaci'on de celda para hora
										//var cell2 = row.insertCell(1);
										var element1 = document.createElement("input");
										element1.type = "time";
										element1.name = "Hora"+rowCount;
										element1.id = "Hora"+rowCount;
										/*element1.style.backgroundColor = "#ffffff";
										element1.style.border = "solid 1px #e5e5e5";*/
										cell7.appendChild(element1);

										var cell3 = row.insertCell(1);
										var element2 = document.createElement("input");
										element2.type = "date";
										element2.name = "Fecha"+rowCount;
										element2.id = "Fecha"+rowCount;
										/*element2.style.backgroundColor = "#ffffff";
										element2.style.border = "solid 1px #e5e5e5";*/
										cell3.appendChild(element2);
										
										var cell4 = row.insertCell(2);
										var element3 = document.createElement("select");
										element3.name = "Dia"+rowCount;
										var option1 = document.createElement("option");
                                        var i;
                                        var option1 = document.createElement("option");
										option1.value="";
										option1.innerHTML="Select" ;
										element3.appendChild(option1);
										var option2 = document.createElement("option");
										option2.value="2";
										option2.innerHTML="Monday" ;
										element3.appendChild(option2);
										var option3 = document.createElement("option");
										option3.value="3";
										option3.innerHTML="Tuesday" ;
										element3.appendChild(option3);
										var option4 = document.createElement("option");
										option4.value="4";
										option4.innerHTML="Wednesday" ;
										element3.appendChild(option4);
										var option5 = document.createElement("option");
										option5.value="5";
										option5.innerHTML="Thursday" ;
										element3.appendChild(option5);
										var option6 = document.createElement("option");
										option6.value="6";
										option6.innerHTML="Friday" ;
										element3.appendChild(option6);
										var option7 = document.createElement("option");
										option7.value="7";
										option7.innerHTML="Saturday" ;
										element3.appendChild(option7);
										var option8 = document.createElement("option");
										option8.value="1";
										option8.innerHTML="Sunday" ;
										element3.appendChild(option8);
                                        cell4.appendChild(element3);

										var cell6 = row.insertCell(3);
										var element5 = document.createElement("input");
										element5.type = "checkbox";
										element5.name = "Mes"+rowCount;
										element5.id = "Mes"+rowCount;
										element5.value = "true";
										element5.style.backgroundColor = "#ffffff";
										element5.style.border = "solid 1px #e5e5e5";
										cell6.appendChild(element5);
                                        
                                        var cell7 = row.insertCell(4);
                                        var element6 = document.createElement("select");
                                        element6.name =  "Melodia"+rowCount;
                                        var options_C = [];
                                        var option_C = document.createElement('option');
                                        //window.alert(json_filesmel[2]);
                                        var index=0;
                                        for(j = 2; j < json_filesmel.length; j++) {
                                            //window.alert(json_filesmel[j]);
                                            // window.alert(j);
                                            option_C.text = json_filesmel[j] ;
                                            //window.alert(arr[i].Name_E);
                                            option_C.value = json_filesmel[j];
                                            option_C.id = json_filesmel[j];
                                            //option_C.value = arr[i].Direccion_C;
                                            options_C.push(option_C.outerHTML);
                                        }
                                        element6.insertAdjacentHTML('beforeEnd', options_C.join('\n'));
                                        cell7.appendChild(element6);

									 };
									</script>
                                    
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
		</content>
		</article>
		</section>

		<div class="clear"></div>

	</section>
	

</body>
</html>
<script type="text/javascript">
	$('#OrdenForm').validate({
		rules: {
			Nombre: "required",
			Repite: "required",
			Hora0: "required"
		},
		messages:{
			Nombre: "Write the Schema Name",
			Repite: "Enter number of schema repeats",
			Hora0: "Enter hour"
		}
	});
</script>
