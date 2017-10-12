<?php
/*
Versión:1.0
Escribe en uno de los siguientes pin de la gpio segun el botón al que se le dio clic
17
27
22
5
Fecha: 20171012
Creado por: Boris Urrea
*/
	$setmode17 = shell_exec("/usr/local/bin/gpio -g mode 17 out");
	$setmode27 = shell_exec("/usr/local/bin/gpio -g mode 27 out");
	$setmode22 = shell_exec("/usr/local/bin/gpio -g mode 22 out");
	$setmode5 = shell_exec("/usr/local/bin/gpio -g mode 5 out");
	if(isset($_GET['Timbre1'])){
	        $gpio_on = shell_exec("/usr/local/bin/gpio -g write 17 1");
	        sleep(5);
		$gpio_off = shell_exec("/usr/local/bin/gpio -g write 17 0");
	}
	if(isset($_GET['Timbre2'])){
	        $gpio_on = shell_exec("/usr/local/bin/gpio -g write 27 1");
	        sleep(5);
		$gpio_off = shell_exec("/usr/local/bin/gpio -g write 27 0");
	}
	if(isset($_GET['Timbre3'])){
	        $gpio_on = shell_exec("/usr/local/bin/gpio -g write 22 1");
	        sleep(5);
		$gpio_off = shell_exec("/usr/local/bin/gpio -g write 22 0");
	}
	if(isset($_GET['Timbre4'])){
	        $gpio_on = shell_exec("/usr/local/bin/gpio -g write 5 1");
	        sleep(5);
		$gpio_off = shell_exec("/usr/local/bin/gpio -g write 5 0");
	}
	header('Location: home.php');
?>
