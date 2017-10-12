<!--
Versión:1.0
habilitador de gpio para raspberry, archivo base
Fecha: 20171012
Creado por: Boris Urrea
-->
<html>
 <head>
 <meta name="viewport" content="width=device-width" />
 <title>LED Control</title>
 </head>
         <body>
         LED Control:
         <form method="get" action="gpio.php">
                 <input type="submit" value="ON" name="on">
                 <input type="submit" value="OFF" name="off">
         </form>
         <?php
         $setmode17 = shell_exec("/usr/local/bin/gpio -g mode 22 out");
         if(isset($_GET['on'])){
                 $gpio_on = shell_exec("/usr/local/bin/gpio -g write 22 1");
                 echo "LED is on";
         }
        else if(isset($_GET['off'])){
                $gpio_off = shell_exec("/usr/local/bin/gpio -g write 22 0");
                echo "LED is off";
        }
        ?>
        </body>
</html>