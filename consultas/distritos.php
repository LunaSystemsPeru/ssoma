<?php 
	include ("../includes/conectar.php");
	$id_provincia = $_POST["id_provincia"];
	$id_departamento= $_POST["id_departamento"];
	
	global $conn;
	$html ="";
	$bmodelo = 'select id, nombre from distrito where provincia = "'.$id_provincia.'" and departamento = "'.$id_departamento.'" order by nombre asc';
	$resultado = $conn->query($bmodelo); 
	if ($resultado->num_rows > 0) {
		while ($fila = $resultado->fetch_assoc()) {
			$html .= '<option value='.$fila['id'].'>'.strtoupper($fila['nombre']).'</option>';
		}
	} 
	echo $html;
?>