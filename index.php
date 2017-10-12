<!DOCTYPE html>
<!--
Versión:1.2
Login de Bell Rings
recibe usuario y contrasenia y llama a validar.php
Creado por: Boris Urrea
-->
<html>
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="css/estilos.css" type="text/css" />
        <title>Bell Rings V Beta 1.1</title>
    </head>
    <body >
        <div style="width:100% !important; text-align: center !important; ">
            <table   cellspacing="0" cellpadding="2" class="table beauty-table table-hover "   >
                <thead  >  
                    <tr  >
                        <th width="30%" class="not_mapped_style" style="text-align:center"></th>
                        <th width="40%" class="not_mapped_style" style="text-align:center"><img src="imagenes/Logo-Bell-Rings.png" class="logo-index"></th> 
                        <th width="30%" class="not_mapped_style" style="text-align:center"></th>
                    </tr>
                </thead >
            </table> 
            <form action="validar.php" method="post">
                <table  style="width:100%"  border="0" align="center" valign="middle">
                    <tr>
                        <td style="height:60px; width:40% ; text-align: center; " > 
                            <input  class="style-6"  type="text" name="mail" placeholder="User">
                        </td>
                    </tr>
                    <tr>
                        <td style="height:60px; width:40% ; text-align: center !important;">
                            <input placeholder="Password" type="password" name="pass" class="style-6"></td>
                    </tr>
                </table>
                <input class="myButton" type="submit" value="Login" >
            </form>
            <table   cellspacing="0" cellpadding="2" class="table beauty-table table-hover ">
                <thead >  
                    <tr>
                        <th width="25%" class="not_mapped_style" style="text-align:center"></th>
                        <th width="20%" class="not_mapped_style" style="text-align:center"><img  src="imagenes/logo_cng.png" class="logo-index2" ></th> 
                        <th width="10%" class="not_mapped_style" style="text-align:center"></th>
                        <th width="20%" class="not_mapped_style" style="text-align:center"><img  src="imagenes/logo_smal.png" class="logo-index2" ></th>
                        <th width="25%" class="not_mapped_style" style="text-align:center"></th>                     
                    </tr>
                </thead >
            </table>  
        </div>
    </body>
    <footer class="footer-distributed" style="width:100% !important; text-align: center !important; ">
        <div class="footer-left">
            <p>BELL RINGS Version beta 1.1. CSIC &copy; 2017</p>
        </div>
    </footer>
</html>
