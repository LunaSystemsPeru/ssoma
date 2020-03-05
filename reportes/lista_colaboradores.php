<?php
	ob_start();
	session_start();
	include('../includes/conectar.php');
	require('../includes/fpdf.php');
	require('../includes/varios.php');
	require('../includes/rotations.php');
	define('FPDF_FONTPATH', '../includes/font/');

	class PDF extends PDF_Rotate
	{
		function RotatedText($x,$y,$txt,$angle)
		{
			//Text rotated around its origin
			$this->Rotate($angle,$x,$y);
			$this->Text($x,$y,$txt);
			$this->Rotate(0);
		}
	}
	
	$varios = new Varios();
	
	$empresa = $_SESSION['empresa'];
	
	$pdf = new PDF('L','mm','A4');
	$pdf->SetAutoPageBreak(true,10); 
	$pdf->AddPage();
	
	
	
	$imagen = "MEMBRETE_HORIZONTAL_FISHONE.png";
	$pdf->Image('../upload/'.$empresa.'/documentos/'. $imagen,0,0,297,35);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',11);
	$pdf->SetTextColor(250,250,250);
	$pdf->Cell(280,5,"LISTADO DE COLABORADORES",0,1,'R');
	$pdf->Cell(280,5,"Pagina 1 de 1",0,1,'R');	
	
	$pdf->Ln(13);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',9);
	
	
	$pdf->Ln(5);
	//CARGAR EMPLEADOS
	
	$pdf->Cell(8,8,"COD",1,0,'C');
        $pdf->Cell(17,8,"DNI",1,0,'C');
	$pdf->Cell(90,8,"APELLIDOS Y NOMBRES",1,0,'C');
        $pdf->Cell(17,8,"EST. CIVIL",1,0,'C');
	$pdf->Cell(80,8,"DIRECCION",1,0,'C');
	$pdf->Cell(17,8,"TEL/CEL",1,0,'C');
	$pdf->Cell(17,8,"FEC. NAC.",1,0,'C');
	$pdf->Cell(15,8,"JORNAL",1,0,'C');
	$pdf->Cell(15,8,"RTA 5TA",1,1,'C');
	
	$pdf->SetFont('Arial','',9);
	$ver_datos = "select e.nombres, e.ape_pat, e.ape_mat, e.dni, e.codigo, e.fecha_nacimiento, e.telefono, e.jornal, e.renta_5ta, ec.nombre as estado_civil, e.direccion from empleado as e inner join estado_civil as ec on e.estado_civil = ec.id where e.empresa = '".$empresa."' order by e.codigo asc ";
	//echo $ver_datos;
	$resultado = $conn->query($ver_datos); 
	if ($resultado->num_rows > 0) {
		while ($fila = $resultado->fetch_assoc()) {
			$codigo = $fila['codigo'];
			$nombre_completo = $fila['ape_pat'] . ' ' . $fila['ape_mat'] . ' ' . $fila['nombres'];
			$dni = $fila['dni'];
                        $fecha_nacimiento = $varios->fecha_tabla($fila['fecha_nacimiento']);
                        $telefono = $fila['telefono'];
                        $jornal = $fila['jornal'];
                        $direccion = $fila['direccion'];
                        $estado_civil = $fila['estado_civil'];
                        if ($fila['renta_5ta']) {
                            $renta = "SI";
                        } else {
                            $renta = "NO";
                        }
			$pdf->Cell(8,6,$codigo,1,0,'C');
                        $pdf->Cell(17,6,$dni,1,0,'C');
			$pdf->Cell(90,6,utf8_decode($nombre_completo),1,0,'L');
			$pdf->Cell(17,6,$estado_civil,1,0,'C');
			$pdf->Cell(80,6,$direccion,1,0,'L');
			$pdf->Cell(17,6,$telefono,1,0,'C');
			$pdf->Cell(17,6,$fecha_nacimiento,1,0,'C');
			$pdf->Cell(15,6,$jornal,1,0,'C');
			$pdf->Cell(15,6,$renta,1,1,'C');
		}
	}
	
	
	$pdf->SetFont('Arial','',8);
	$pdf->RotatedText(10,170,"SST-REG-045     Vr. 01      Fec. Aprob.: 21/10/2016",90);
	$pdf->Output();
	
	ob_end_flush();
?>
