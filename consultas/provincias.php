<?php 
	include ("../includes/conectar.php");
	$id_departamento = $_POST["id_departamento"];
	
	global $conn;
	$html ="";
	$bmodelo = 'select id, nombre from provincia where departamento = "'.$id_departamento.'" order by nombre asc';
	$resultado = $conn->query($bmodelo); 
	if ($resultado->num_rows > 0) {
		while ($fila = $resultado->fetch_assoc()) {
			$html .= '<option value='.$fila['id'].'>'.strtoupper($fila['nombre']).'</option>';
		}
	} 
	echo $html;
?>