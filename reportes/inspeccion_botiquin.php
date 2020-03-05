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
        $imagen = "MEMBRETE_HORIZONTAL_FISHONE.png";
        $this->Image('../upload/' . $empresa . '/documentos/' . $imagen, 0, 0, 297, 35);
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(250, 250, 250);
        $this->Cell(280, 5, "REGISTRO DE INSPECCION DE BOTIQUIN", 0, 1, 'R');
        $this->Cell(280, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
        $this->Ln(13);
    }

    function Footer() {
        $this->SetFont('Arial', '', 8);
        $this->RotatedText(6, 170, "SST-REG-073     Vr. 01      Fec. Aprob.: 23/07/2016", 90);
    }

}

$varios = new Varios();
$id = $_GET['id'];
$cod_id = str_pad($id, 3, '0', STR_PAD_LEFT);
$empresa = $_SESSION['empresa'];
$anio = $_GET['anio'];
$item = $_GET['item'];
$cod_item = str_pad($item, 3, '0', STR_PAD_LEFT);

$ver_datos = "select ie.*, e.nombres, e.ape_pat, e.ape_mat from inspeccion_botiquin as ie inner join empleado as e on ie.inspector = e.codigo "
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

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 5, "INSPECTOR:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(150, 5, $inspector, 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "FECHA:", 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 5, "___ / ___ / ______", 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 5, "AREA:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(150, 5, $area, 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 5, "LOCAL:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(150, 5, $local, 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "CODIGO DOC:", 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 5, $anio . '-' . $cod_id . '-' . $cod_item, 0, 1, 'L');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(85, 107, 47);
$pdf->SetFillColor(153, 255, 100);
$pdf->Cell(275, 6, "DETALLE DE BOTIQUIN", 1, 1, 'C', 1);
$pdf->Cell(65, 6, "CRITERIO", 1, 0, 'C', 1);
$pdf->Cell(20, 6, "CANT. MIN.", 1, 0, 'C', 1);
$pdf->Cell(25, 6, "CANT. ACT.", 1, 0, 'C', 1);
$pdf->Cell(25, 6, "CANT. FAL.", 1, 0, 'C', 1);
$pdf->Cell(30, 6, "FEC. VENC.", 1, 0, 'C', 1);
$pdf->Cell(30, 6, "ACTO PARA USO", 1, 0, 'C', 1);
$pdf->Cell(80, 6, "OBSERVACIONES", 1, 1, 'C', 1);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', '', 8);
$array_criterio = array(
    utf8_decode("Algodon"),
    utf8_decode("Gasas de rollo (Venda de Gasa)"),
    utf8_decode("Gasas esteriles (4x4cm)"),
    utf8_decode("Curas para ojos"),
    utf8_decode("Adhesivo"),
    utf8_decode("Curitas"),
    utf8_decode("Vendas Elasticas 6 cm"),
    utf8_decode("Vendas Elasticas 8 cm"),
    utf8_decode("Vendas Elasticas 12 cm"),
    utf8_decode("Apositos Esteriles 5 x 9 cm"),
    utf8_decode("Espatulas Baja Lengua"),
    utf8_decode("Aplicadores de Algodon - Hisopos"),
    utf8_decode("Vendas Triangulares 90x90x140 cm"),
    utf8_decode("Tijeras Punta roma"),
    utf8_decode("Jabon Azul o neutro"),
    utf8_decode("Termometro oral"),
    utf8_decode("Copa para lavado ocular"),
    utf8_decode("Antinflamatorio de uso externo"),
    utf8_decode("Alcohol"),
    utf8_decode("Agua Oxigenada"),
    utf8_decode("Guantes Desechables"),
);

$array_minimo = array(
    utf8_decode("1 Pkte."),
    utf8_decode("2 Pkte."),
    utf8_decode("20 Und."),
    utf8_decode("2 Und."),
    utf8_decode("1 Rollo"),
    utf8_decode("50 Und."),
    utf8_decode("2 Und."),
    utf8_decode("2 Und."),
    utf8_decode("2 Und."),
    utf8_decode("4 Und."),
    utf8_decode("10 Und."),
    utf8_decode("50 Und."),
    utf8_decode("4 Und."),
    utf8_decode("1 Und."),
    utf8_decode("1 Und."),
    utf8_decode("1 Und."),
    utf8_decode("1 Und."),
    utf8_decode("1 Und."),
    utf8_decode("1 Und."),
    utf8_decode("1 Und."),
    utf8_decode("1 Par"),
);

for ($index = 0; $index < count($array_criterio); $index++) {
    $longitud = strlen($array_criterio[$index]);
    if ($longitud > 60) {
        $alto = 10;
    } else {
        $alto = 5;
    }
    $pdf->Cell(65, 5, $array_criterio[$index], 1, 0, 'L');
    $pdf->Cell(20, 5, $array_minimo[$index], 1, 0, 'C');
    $pdf->Cell(25, 5, "", 1, 0, 'C');
    $pdf->Cell(25, 5, "", 1, 0, 'C');
    $pdf->Cell(30, 5, "___/___/______", 1, 0, 'C');
    $pdf->Cell(30, 5, "SI  /  NO", 1, 0, 'C');
    $pdf->Cell(80, 5, "", 1, 1, 'C');
}

$pdf->Cell(95, 5, "INSPECTOR", 1, 0, 'C');
$pdf->Cell(85, 5, "", 0, 0, 'C');
$pdf->Cell(95, 5, "SUPERVISOR", 1, 1, 'C');
$pdf->Cell(95, 20, "", 1, 0, 'L');
$pdf->Cell(85, 10, "", 0, 0, 'C');
$pdf->Cell(95, 20, "", 1, 1, 'L');


$pdf->Output();
ob_end_flush();
?>
