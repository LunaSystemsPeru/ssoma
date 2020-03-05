<?php
	ob_start();
	include('../includes/conectar.php');
	require('../includes/fpdf.php');
	require('../includes/varios.php');
	
	$varios = new Varios();
	
	$empleado = $_GET['empleado'];
	$empresa = $_GET['empresa'];
	
	$ver_datos = "select e.dni, e.nombres, e.ape_pat, e.ape_mat, e.direccion, e.fecha_ingreso, DAY(e.fecha_ingreso) as dia_ingreso, MONTH(e.fecha_ingreso) as mes_ingreso, YEAR(e.fecha_ingreso) as anio_ingreso, sp.nombre as seguro_pension from empleado as e inner join seguro_pension as sp on e.seguro_pension = sp.id where codigo = '".$empleado."' and empresa = '".$empresa."'";
	//echo $ver_datos;
	$resultado = $conn->query($ver_datos); 
	if ($resultado->num_rows > 0) {
		if ($fila = $resultado->fetch_assoc()) {
			$nombre_empleado = $fila['ape_pat'] . ' ' . $fila['ape_mat'] . ' ' . $fila['nombres'];
			$dni = $fila['dni'];
			$domicilio = $fila['direccion'];
			$seguro_pension = $fila['seguro_pension'];
			$dia = $fila['dia_ingreso'];
			$mes = $fila['mes_ingreso'];
			$anio = $fila['anio_ingreso'];
		}
	}
	
	$pdf = new FPDF('P','mm','A4');
	$pdf->SetMargins(20, 10 , 20); 
	$pdf->SetAutoPageBreak(true,10); 
	$pdf->AddPage();
	
	$membrete = "MEMBRETE_SUPERIOR_FISHONE.jpg";
	$pdf->Image('../upload/'.$empresa.'/documentos/'. $membrete,0,0,230,35);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',11);
	$pdf->SetTextColor(250,250,250);
	$pdf->Cell(175,5,"DECLARACION JURADA RENTAS DE 5TA CATEGORIA",0,1,'R');
	$pdf->Cell(175,5,"Pagina 1 de 1",0,1,'R');	
	
	$pdf->Ln(13);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',18);
	$pdf->Cell(170,15,"DECLARACION JURADA RENTAS DE 5TA CATEGORIA",0,1,'C');
	$pdf->SetFont('Arial','',9);
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',14);
	$pdf->MultiCell(170, 10,"Yo " . $nombre_empleado.", identificado con DNI Nro: " . $dni,0,'J');
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',16);
	$pdf->MultiCell(170, 10,"DECLARO BAJO JURAMENTO",0,'C');
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',16);
	$pdf->MultiCell(170, 10,utf8_decode("Que  no tuve percepciones de Renta de Quinta Categoría, ni se me hizo retenciones de Rentas Quinta Categoría desde el mes _______________ hasta el mes de _______________ del año dos mil doce."),0,'J');
	$pdf->Ln(10);
	$pdf->MultiCell(170, 10,utf8_decode("Para mayor veracidad de la presente Declaración Jurada firmo y pongo  mi huella digital a los $dia días del mes de ". $varios->nombremes($mes). " del $anio"),0,'J');
	
	$pdf->SetFont('Arial','',14);
	$pdf->Ln(5);
	$pdf->MultiCell(170, 10,utf8_decode("Atentamente"),0,'C');
	
	$pdf->SetY(-60);
	$pdf->Cell(170,10,"______________",0,1,'C');
	$pdf->Cell(170,8,"Firma y Huella",0,1,'C');
	$pdf->Cell(170,8,"DNI: " . $dni,0,1,'C');
	$pdf->Output();
	ob_end_flush();
?>
