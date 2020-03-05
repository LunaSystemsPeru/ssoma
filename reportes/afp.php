<?php

session_start();
ob_start();
include('../includes/conectar.php');
require('../includes/rotations.php');
require('../includes/varios.php');
define('FPDF_FONTPATH', '../includes/font/');

class PDF extends PDF_Rotate {

//Cabecera de página
    function Header() {
        $empresa = $_SESSION['empresa'];
        $imagen = "MEMBRETE_SUPERIOR_FISHONE.jpg";
        $this->Image('../upload/' . $empresa . '/documentos/' . $imagen, 0, 0, 230, 35);
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(250, 250, 250);
        $this->SetX(65);
        $this->MultiCell(140, 5, utf8_decode("DECLARACION JURADA DE AFP"), 0, 'R');
        $this->Cell(180, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
    }
}

$empleado = $_GET['empleado'];

$varios = new Varios();
$empresa = $_SESSION['empresa'];

$ver_datos = "select e.dni, e.nombres, e.ape_pat, e.ape_mat, e.direccion, e.fecha_ingreso, DAY(e.fecha_ingreso) as dia_ingreso, MONTH(e.fecha_ingreso) as mes_ingreso, YEAR(e.fecha_ingreso) as anio_ingreso, sp.nombre as seguro_pension from empleado as e inner join seguro_pension as sp on e.seguro_pension = sp.id where codigo = '" . $empleado . "' and empresa = '" . $empresa . "'";
//echo $ver_datos;
$r_datos = $conn->query($ver_datos);
if ($r_datos->num_rows > 0) {
    while ($fila = $r_datos->fetch_assoc()) {
        $nombre_empleado = $fila['ape_pat'] . ' ' . $fila['ape_mat'] . ' ' . $fila['nombres'];
        $dni = $fila['dni'];
        $domicilio = $fila['direccion'];
        $seguro_pension = $fila['seguro_pension'];
        $dia = $fila['dia_ingreso'];
        $mes = $fila['mes_ingreso'];
        $anio = $fila['anio_ingreso'];
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetMargins(30, 10, 20);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->Ln(13);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(150, 15, "DECLARACION JURADA AFP", 0, 1, 'C');
$pdf->SetFont('Arial', '', 9);

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 14);
$pdf->MultiCell(150, 10, "Yo " . $nombre_empleado . ", identificado con DNI Nro: " . $dni . ", domiciliado en " . $domicilio, 0, 'J');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 16);
$pdf->MultiCell(150, 10, "DECLARO BAJO JURAMENTO", 0, 'L');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 16);
$pdf->MultiCell(150, 10, utf8_decode("Que me  encuentro afiliado a la AFP: " . $seguro_pension . "."), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(150, 10, utf8_decode("Para mayor veracidad de la presente Declaración Jurada firmo y pongo  mi huella digital a los $dia días del mes de " . $varios->nombremes($mes) . " del $anio"), 0, 'J');

$pdf->SetFont('Arial', '', 14);
$pdf->Ln(30);
$pdf->MultiCell(150, 10, utf8_decode("Atentamente"), 0, 'C');

$pdf->SetY(-60);
$pdf->Cell(150, 10, "______________", 0, 1, 'C');
$pdf->Cell(150, 8, "Firma y Huella", 0, 1, 'C');
$pdf->Cell(150, 8, "DNI: " . $dni, 0, 1, 'C');
$pdf->Output();
ob_end_flush();
?>
