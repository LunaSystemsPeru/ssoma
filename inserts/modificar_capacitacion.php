<?php 
    session_start();
    ob_start();
	include ('../includes/conectar.php');
	include ('../includes/varios.php');
	$varios = new Varios();	
	
	$empresa = $_SESSION['empresa'];
	
	if (isset($_POST['graba_modificacion'])){
		
		
		$id = $_POST['id'];
		$anio = $_POST['anio'];
		$tema = strtoupper($_POST['tema']);
		$fecha = $varios->fecha_hora_mysql($_POST['fecha_evento']);		
		$duracion = strtoupper($_POST['duracion']);
		$expositor = strtoupper($_POST['expositor']);
		global $conn;
		
		$modificar = "update programa_capacitaciones set tema = '".$tema."', expositor = '".$expositor."', fecha_programado = '".$fecha."', duracion = '".$duracion."' where id = '".$id."' and anio = '".$anio."' and empresa = '".$empresa."'";
		echo $modificar;
		$resultado = $conn->query($modificar); 
		if(! $resultado ) {
			die('Could not enter data: ' . mysqli_error($conn));
		}
		else 
		{
			header('Location: ../programa_capacitaciones.php');
		}
		
	}
    ob_end_flush();
?>
