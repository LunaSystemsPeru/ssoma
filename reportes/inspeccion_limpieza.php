<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
include('../includes/conectar.php');
require('../includes/varios.php');
require('../includes/rotations.php');
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
        $this->MultiCell(140, 5, utf8_decode("INSPECCION SEÑALETICA, ORDEN Y LIMPIEZA"), 0, 'R');
        $this->Cell(195, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
    }

    function Footer() {
        $this->SetFont('Arial', '', 8);
        $this->RotatedText(8, 270, "SST-REG-071     Vr. 01      Fec. Aprob.: 03/05/2014", 90);
    }
}

$varios = new Varios();
$id = "2";
$cod_id = str_pad($id, 3, '0', STR_PAD_LEFT);
$empresa = $_SESSION['empresa'];
$anio = "2016";
$item = "1";
$cod_item = str_pad($item, 3, '0', STR_PAD_LEFT);
/*
  $id = $_GET['id'];
  $empresa = $_SESSION['empresa'];
  $anio = $_GET['anio'];
  $tipo = $_GET['tipo'];
  $area = $_GET['area'];
  $local = $_GET['local']; */

$ver_datos = "select ie.*, e.nombres, e.ape_pat, e.ape_mat from inspeccion_limpieza as ie inner join empleado as e on ie.inspector = e.codigo "
        . " and ie.empresa = e.empresa where ie.id='" . $id . "' and ie.anio = '" . $anio . "' and ie.empresa = '" . $empresa . "' and "
        . "item = '" . $item . "'";
$r_inspecciones = $conn->query($ver_datos);
if ($r_inspecciones->num_rows > 0) {
    while ($fila = $r_inspecciones->fetch_assoc()) {
        $inspector = $fila['nombres'] . ' ' . $fila['ape_pat'] . ' ' . $fila['ape_mat'];
        $area = $fila['area'];
        $local = $fila['local'];
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->Ln(13);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, "INSPECTOR:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 5, $inspector, 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(20, 5, "FECHA INICIO:", 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(20, 5, "___ / ___ / ______", 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, "AREA:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 5, $area, 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(20, 5, "FECHA TERMINO:", 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(20, 5, "___ / ___ / ______", 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, "LOCAL:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 5, $local, 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(20, 5, "CODIGO DOC:", 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(20, 5, $anio . '-' . $cod_id . '-' . $cod_item, 0, 1, 'L');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(92, 6, "Satisfactorio(S)-No satisfactorio (NS)/No Aplica (NA)", 1, 0, 'C');
$pdf->Cell(14, 6, "LUNES", 1, 0, 'C');
$pdf->Cell(16, 6, "MARTES", 1, 0, 'C');
$pdf->Cell(22, 6, "MIERCOLES", 1, 0, 'C');
$pdf->Cell(14, 6, "JUEVES", 1, 0, 'C');
$pdf->Cell(16, 6, "VIERNES", 1, 0, 'C');
$pdf->Cell(16, 6, "SABADO", 1, 1, 'C');

$pdf->SetFont('Arial', '', 8);

$pdf->SetTextColor(85, 107, 47);
$pdf->SetFillColor(153, 255, 100);
$pdf->Cell(190, 6, "VIAS Y AREAS DE ALMACENAMIENTO", 1, 1, 'L', 1);
$pdf->SetTextColor(0, 0, 0);

$lista_items1 = array(utf8_decode("SEÑALIZACION DE LA ZONA DE TRABAJO"), utf8_decode("ÁREA DE PARQUEO"), utf8_decode("VIAS DE ACCESO LIBRES DE OBSTACULOS-SEÑALIZADAS"),
    utf8_decode("UBICACIÓN E IDENTIFICACIÓN DE ALMACENAMIENTO DE MATERIALES"));

for ($index = 0; $index < count($lista_items1); $index++) {
    $longitud = strlen($lista_items1[$index]);
    if ($longitud > 50) {
        $alto = 10;
    } else {
        $alto = 5;
    }
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(92, 5, $lista_items1[$index], 1, 'J');
    $pdf->setXY($x + 92, $y);
    $pdf->Cell(14, $alto, "", 1, 0, 'C');
    $pdf->Cell(16, $alto, "", 1, 0, 'C');
    $pdf->Cell(22, $alto, "", 1, 0, 'C');
    $pdf->Cell(14, $alto, "", 1, 0, 'C');
    $pdf->Cell(16, $alto, "", 1, 0, 'C');
    $pdf->Cell(16, $alto, "", 1, 1, 'C');
}

$pdf->SetTextColor(85, 107, 47);
$pdf->SetFillColor(153, 255, 100);
$pdf->Cell(190, 6, "LIMPIEZA E HIGIENE", 1, 1, 'L', 1);
$pdf->SetTextColor(0, 0, 0);

$lista_items2 = array(utf8_decode("DISPONEN LOS TRABAJADORES DE UN ÁREA PARA EL CAMBIO DE ROPA Y GUARDARLA"), utf8_decode("DISPONEN DE UN ÁREA PARA EL CONSUMO DE ALIMENTOS"), utf8_decode("DISPONEN DE SERVICIOS SANITARIOS PARA SUS NECESIDADES FISIOLOGICAS. ORDENADO Y LIMPIO"),
    utf8_decode("DISPONEN DE AGUA POTABLE PARA EL CONSUMO Y DE VASOS DESECHABLES"), utf8_decode("DISPONEN DE ELEMENTOS PARA EL ASEO DE ELEMENTOS DE PROTECCION PERSONAL."));

for ($index = 0; $index < count($lista_items2); $index++) {
    $longitud = strlen($lista_items2[$index]);
    if ($longitud > 50) {
        $alto = 10;
    } else {
        $alto = 5;
    }
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(92, 5, $lista_items2[$index], 1, 'J');
    $pdf->setXY($x + 92, $y);
    $pdf->Cell(14, $alto, "", 1, 0, 'C');
    $pdf->Cell(16, $alto, "", 1, 0, 'C');
    $pdf->Cell(22, $alto, "", 1, 0, 'C');
    $pdf->Cell(14, $alto, "", 1, 0, 'C');
    $pdf->Cell(16, $alto, "", 1, 0, 'C');
    $pdf->Cell(16, $alto, "", 1, 1, 'C');
}

$pdf->SetTextColor(85, 107, 47);
$pdf->SetFillColor(153, 255, 100);
$pdf->Cell(190, 6, "AREAS Y CONDICIONES DE TRABAJO", 1, 1, 'L',1);
$pdf->SetTextColor(0, 0, 0);

$lista_items3 = array(utf8_decode("UBICACIÓN E IDENTIFICACIÓN DE PUNTO ECOLOGICO DE RESIDUOS GENERADOS "), utf8_decode("ÁREA DE TRABAJO LIMPIA Y ORDENADA"), utf8_decode("SE ENCUENTRA EXTINTOR Y BOTIQUIN DE PRIMEROS AUXILIOS EN  EL ÁREA DE TRABAJO"));

for ($index = 0; $index < count($lista_items3); $index++) {
    $longitud = strlen($lista_items3[$index]);
    if ($longitud > 50) {
        $alto = 10;
    } else {
        $alto = 5;
    }
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(92, 5, $lista_items3[$index], 1, 'J');
    $pdf->setXY($x + 92, $y);
    $pdf->Cell(14, $alto, "", 1, 0, 'C');
    $pdf->Cell(16, $alto, "", 1, 0, 'C');
    $pdf->Cell(22, $alto, "", 1, 0, 'C');
    $pdf->Cell(14, $alto, "", 1, 0, 'C');
    $pdf->Cell(16, $alto, "", 1, 0, 'C');
    $pdf->Cell(16, $alto, "", 1, 1, 'C');
}

$pdf->Ln(5);
$pdf->Cell(190, 6, "RECOMENDACIONES", 0, 1, 'L');
$pdf->Cell(190, 5, "", 1, 1, 'L');
$pdf->Cell(190, 5, "", 1, 1, 'L');
$pdf->Cell(190, 5, "", 1, 1, 'L');
$pdf->Cell(190, 5, "", 1, 1, 'L');
$pdf->Cell(190, 5, "", 1, 1, 'L');
$pdf->Cell(190, 5, "", 1, 1, 'L');
$pdf->Cell(190, 5, "", 1, 1, 'L');
$pdf->Cell(190, 5, "", 1, 1, 'L');
$pdf->Cell(190, 5, "", 1, 1, 'L');
$pdf->Cell(190, 5, "", 1, 1, 'L');

$pdf->Ln(10);
$pdf->Cell(95, 6, "INSPECTOR", 1, 0, 'C');
$pdf->Cell(95, 6, "SUPERVISOR", 1, 1, 'C');
$pdf->Cell(95, 30, "", 1, 0, 'L');
$pdf->Cell(95, 30, "", 1, 1, 'L');


$pdf->Output();
ob_end_flush();
?>
