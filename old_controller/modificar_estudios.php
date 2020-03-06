<?php 
    session_start();
    ob_start();
	include ('../includes/conectar.php');
	
	if (isset($_POST['modificar_estudios'])) { 
        $empresa = $_SESSION['empresa'];
		$empleado  = $_POST['empleado'];
		$estudio = $_POST['id_estudios'];
		$institucion = strtoupper($_POST['institucion']);
        $grado = $_POST['grado'];
        $tipo = $_POST['tipo'];

        $modificar_estudios = "update estudios set institucion = '".$institucion."', tipo = '".$tipo."', grado = '".$grado."' where id = '".$estudio."' and empleado = '".$empleado."' and empresa = '".$empresa."'";
		echo $modificar_estudios;
		$resultado = $conn->query($modificar_estudios); 
		if ($resultado === TRUE) 
        {   
			header("Location: ../academico_empleado.php?id=" . $empleado);
		} 
        else
        {
			echo "Error: " . $modificar_estudios . "<br>" . $conn->error;
			die('Could not enter data: ' . mysqli_error($conn));
		}
		$conn->close();
	} else {
        echo "no hizo clic en el boton";
    }
    ob_end_flush();
?>
