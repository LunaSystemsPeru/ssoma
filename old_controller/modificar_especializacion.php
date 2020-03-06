<?php 
	ob_start();
	include ('../includes/conectar.php');
	
	if (isset($_POST['modificar_especializacion'])) { 
		$id  = $_POST['codigo'];
		$nombre_db = strtoupper($_POST['nombre_db']);
		$porcentaje_db = $_POST['porcentaje_db'];
		$modificar_especializacion = 'update especializacion set descripcion = "'.$nombre_db.'", porcentaje = "'.$porcentaje_db.'" where id = "'.$id.'"';
		echo $modificar_epp;
		$resultado = $conn->query($modificar_especializacion); 
		if ($resultado === TRUE) {
			header("Location: ../especializacion.php");
			} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			die('Could not enter data: ' . mysqli_error($conn));
		}
		$conn->close();
	}
	ob_end_flush();
?>
