<?php
	session_start();
	ob_start();
	
	include('../includes/conectar.php');
	
	$empresa = $_POST['empresa'];
	$usuario = $_POST['usuario'];
	$password = $_POST['password'];
	
	$verifica = "select u.estado, u.nombres, u.ape_pat from usuario as u where u.empresa = '".$empresa."' and u.usuario = '".$usuario."' and u.contrasena = '".$password."'";
	//echo $verifica;
	$resultado = $conn->query($verifica); 
	if ($resultado->num_rows > 0) {
		while ($fila = $resultado->fetch_assoc()) {
			$estado = $fila['estado'];
			$nombres = explode(" ",ucwords(strtolower($fila['nombres'])));
			$ape_pat = ucwords(strtolower($fila['ape_pat']));
			if ($estado == "1") {
				$_SESSION["usuario"] = $usuario;
				$_SESSION["empresa"] = $empresa; 
				$_SESSION["empleado"] = $nombres[0] . " " . $ape_pat;
				header ("Location: ../index.php");
			}
			else {
				$mensaje = "el usuario ha sido bloqueado, contacte al administrador del sistema";
				session_destroy();
				header ("Location: ../login.php?error=".$mensaje);
			}
		} 
	} 
	else {
		$mensaje = "Error el usuario no existe";
		header ("Location: ../login.php?error=".$mensaje);
	}
	$resultado->close();
	ob_end_flush();
?>		