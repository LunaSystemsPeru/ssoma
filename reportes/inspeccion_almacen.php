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
        $this->MultiCell(140, 5, utf8_decode("INSPECCION DE ALMACEN"), 0, 'R');
        $this->Cell(195, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
    }

    function Footer() {
        $this->SetFont('Arial', '', 8);
        $this->RotatedText(8, 270, "SST-REG-049     Vr. 01      Fec. Aprob.: 03/05/2014", 90);
    }
}

$varios = new Varios();
$id = $_GET['id'];
$cod_id = str_pad($id, 3, '0', STR_PAD_LEFT);
$empresa = $_SESSION['empresa'];
$anio = $_GET['anio'];
$item = $_GET['item'];
$cod_item = str_pad($item, 3, '0', STR_PAD_LEFT);
/*
  $id = $_GET['id'];
  $empresa = $_SESSION['empresa'];
  $anio = $_GET['anio'];
  $tipo = $_GET['tipo'];
  $area = $_GET['area'];
  $local = $_GET['local']; */

$ver_datos = "select ie.*, e.nombres, e.ape_pat, e.ape_mat from inspeccion_almacen as ie inner join empleado as e on ie.inspector = e.codigo "
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
$pdf->Cell(20, 5, "FECHA:", 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(20, 5, "___ / ___ / ______", 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, "AREA:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 5, $area, 0, 1, 'L');
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
$pdf->SetTextColor(85, 107, 47);
$pdf->SetFillColor(153, 255, 100);
$pdf->Cell(190, 6, "CONDICIONES FISICAS", 1, 1, 'C', 1);
$pdf->SetTextColor(0, 0, 0);

$pdf->Cell(70, 6, "ITEMS", 1, 0, 'C');
$pdf->Cell(20, 6, "SI/ NO/ NA", 1, 0, 'C');
$pdf->Cell(100, 6, "OBSERVACIONES", 1, 1, 'C');

$pdf->SetFont('Arial', '', 8);
$lista_items1 = array(utf8_decode("VERIFICACIÓN DE EXTINTORES"), utf8_decode("INSTALACIONES ELECTRICAS"), utf8_decode("RUTA DE EVACUACIÓN"), utf8_decode("BUEN ESTADO DE LOS ANAQUELES")
        , utf8_decode("NO ENTRE EL AGUA"), utf8_decode("LIMPIEZA DEL ALMACEN"), utf8_decode("PINTURA EN GENERAL"), utf8_decode("ALUMBRADO CON PROTECTOR")
    , utf8_decode("OTROS (ALMACEN)"), "", "", "", "");

for ($index = 0; $index < count($lista_items1); $index++) {
    $longitud = strlen($lista_items1[$index]);
    if ($longitud > 50) {
        $alto = 12;
    } else {
        $alto = 6;
    }
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(70, 6, $lista_items1[$index], 1, 'J');
    $pdf->setXY($x + 70, $y);
    $pdf->Cell(20, $alto, "", 1, 0, 'C');
    $pdf->Cell(100, $alto, "", 1, 1, 'C');
}

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(85, 107, 47);
$pdf->SetFillColor(153, 255, 100);
$pdf->Cell(190, 6, "CONDICIONES FISICAS DE LOS MATERIALES", 1, 1, 'C', 1);
$pdf->SetTextColor(0, 0, 0);

$pdf->Cell(70, 6, "ITEMS", 1, 0, 'C');
$pdf->Cell(20, 6, "SI/ NO/ NA", 1, 0, 'C');
$pdf->Cell(100, 6, "OBSERVACIONES", 1, 1, 'C');

$pdf->SetFont('Arial', '', 8);
$lista_items2 = array(utf8_decode("ORDEN DEL MATERIAL"), utf8_decode("ESTADO DEL EMPAQUE"), utf8_decode("ESTIBADO CORRECTO"), utf8_decode("LIMPIEZA DE LOS MATERIALES")
        , utf8_decode("OTROS (MATERIALES)"), "", "", "", "");

for ($index = 0; $index < count($lista_items2); $index++) {
    $longitud = strlen($lista_items2[$index]);
    if ($longitud > 50) {
        $alto = 10;
    } else {
        $alto = 6;
    }
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(70, 6, $lista_items2[$index], 1, 'J');
    $pdf->setXY($x + 70, $y);
    $pdf->Cell(20, $alto, "", 1, 0, 'C');
    $pdf->Cell(100, $alto, "", 1, 1, 'C');
}

$pdf->Ln(10);
$pdf->Cell(95, 6, "INSPECTOR", 1, 0, 'C');
$pdf->Cell(95, 6, "SUPERVISOR", 1, 1, 'C');
$pdf->Cell(95, 30, "", 1, 0, 'L');
$pdf->Cell(95, 30, "", 1, 1, 'L');


$pdf->Output();
ob_end_flush();
?>
