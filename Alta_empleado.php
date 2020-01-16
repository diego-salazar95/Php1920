
<?php

echo "<h1>Alta empleado</h1>";

/* Conexión BD */
define('DB_SERVER', '10.129.25.209');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'rootroot');
define('DB_DATABASE', 'empleadonn');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   
   if (!$db) {
		die("Error conexión: " . mysqli_connect_error());
	}

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 

	/*Función que obtiene los departamentos de la empresa*/
	$departamentos = obtenerDepartamentos($db);
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
	<div>
    <label for="dni"> DNI:</label>
        <input type="text" name="dni"><br>
    <label for="nombre"> Nombre:</label>
        <input type="text" name="nombre"><br>
    <label for="apellido"> Apellido:</label>
        <input type="text" name="apellido"><br>
    <label for="fecha_nac"> Fecha Nacimiento:</label>
        <input type="text" name="fecha_nac"><br>
    <label for="salario"> Salario:</label>
        <input type="text" name="salario"><br>
	<label for="departamento">Departamentos:</label>
	<select name="departamento">
		<?php foreach($departamentos as $departamento) : ?>
			<option> <?php echo $departamento ?> </option>
		<?php endforeach; ?>
	</select>
	</div>
	</BR>
<?php
	echo '<div><input type="submit" value="Alta Empleado"></div>
	</form>';
} else { 

    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fecha_nac = $_POST["fecha_nac"];
    $salario = $_POST["salario"];
    $departa = $_POST["departamento"];

    $depa_cod="SELECT cod_dpto as a from departamento where nombre_dpto='$departa'";
    $resul_depa_cod = mysqli_query($db, $depa_cod);
    $fila = mysqli_fetch_assoc($resul_depa_cod);
    $newDpto = $fila['a'];
    
    $insert ="INSERT INTO empleado (dni, nombre, apellidos, fecha_nac, salario) 
    VALUES ('$dni','$nombre', '$apellido','$fecha_nac','$salario')";

    $db -> query($insert);

    $fecha_actual = gmdate('Y-m-d');
    $insert_dpto = "INSERT INTO emple_depart (dni, cod_dpto, fecha_ini) 
    VALUES ('$dni','$newDpto', '$fecha_actual')";

    $db -> query($insert_dpto);
    
    echo "Se ha insertado el empleado correctamente";


    mysqli_close($db);
}
?>

<?php
// Funciones utilizadas en el programa

// Obtengo todos los departamentos para mostrarlos en la lista de valores
function obtenerDepartamentos($db) {
	$departamentos = array();
	
	$sql = "SELECT cod_dpto,nombre_dpto FROM departamento";
	
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$departamentos[] = $row['nombre_dpto'];
		}
	}
	return $departamentos;
}
