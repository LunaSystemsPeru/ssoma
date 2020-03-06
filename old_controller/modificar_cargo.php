<?php 
	ob_start();
	include ('../includes/conectar.php');
	
	if (isset($_POST['modificar_cargo'])) { 
		$id  = $_POST['codigo'];
		$nombre_db = strtoupper($_POST['nombre_db']);
		$jornal_db = $_POST['jornal_db'];
		$modificar_epp = 'update cargo set nombre = "'.$nombre_db.'", jornal = "'.$jornal_db.'" where id = "'.$id.'"';
		echo $modificar_epp;
		$resultado = $conn->query($modificar_epp); 
		if ($resultado === TRUE) {
			header("Location: ../cargo.php");
			} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			die('Could not enter data: ' . mysqli_error($conn));
		}
		$conn->close();
	}
	ob_end_flush();
?>
