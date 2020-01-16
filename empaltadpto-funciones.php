<?php
function insertar($servername,$username,$password,$dbname,$nombre){
try {
    $conexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $info = $conexion->prepare("SELECT max(cod_dpto) from departamento");
    $info->execute();
    // set the resulting array to associative
    $result = $info->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $key=>$c)
	{
        foreach($c as $key=>$codigo)
	    {
        $cod = substr($codigo , 1 , 3);
        $cod=intval($cod);
        $cod=$cod+1;
        $cod=str_pad($cod,3,"0",STR_PAD_LEFT);
        $cod="D".$cod;
        $sql = "INSERT INTO departamento (cod_dpto, nombre_dpto) VALUES ('$cod', '$nombre')";
        $conexion->exec($sql);
	    }
	
	}
    echo "New record created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
$conexion = null;
}
?>