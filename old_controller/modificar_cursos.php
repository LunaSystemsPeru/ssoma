<?php 
    session_start();
    ob_start();
	include ('../includes/conectar.php');
	
	if (isset($_POST['modificar_cursos'])) { 
        $empresa = $_SESSION['empresa'];
		$empleado  = $_POST['empleado'];
		$curso = $_POST['id_curso'];
		$institucion = strtoupper($_POST['institucion']);
        $descripcion = strtoupper($_POST['descripcion']);
        $duracion = $_POST['duracion'];
        $tipo_duracion = $_POST['tipo_duracion'];

        $modificar = "update cursos set institucion = '".$institucion."', tipo_duracion = '".$tipo_duracion."', duracion = '".$duracion."', descripcion = '".$descripcion."' where id = '".$curso."' and empleado = '".$empleado."' and empresa = '".$empresa."'";
		echo $modificar;
		$resultado = $conn->query($modificar); 
		if ($resultado === TRUE) 
        {   
			header("Location: ../academico_empleado.php?id=" . $empleado);
		} 
        else
        {
			echo "Error: " . $modificar . "<br>" . $conn->error;
			die('Could not enter data: ' . mysqli_error($conn));
		}
		$conn->close();
	} else {
        echo "no hizo clic en el boton";
    }
    ob_end_flush();
?>
