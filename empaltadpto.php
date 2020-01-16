<?php
require "../FuncionesGlobales.php";
require "empaltadpto-funciones.php";
$nombre=$_POST['nombre'];
limpiar_campos($nombre);
insertar("localhost","root","rootroot","empleadonn",$nombre);
?>