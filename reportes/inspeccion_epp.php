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

$varios = new Varios();
$id = $_GET['id'];
$cod_id = str_pad($id, 3, '0', STR_PAD_LEFT);
$anio = $_GET['anio'];
$item = $_GET['item'];
$cod_item = str_pad($item, 3, '0', STR_PAD_LEFT);

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
        $this->MultiCell(140, 5, "INSPECCION DE EQUIPOS DE PROTECCION PERSONAL", 0, 'R');
        $this->Cell(195, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
        $this->Ln(13);
    }

    function Footer() {
        $this->SetFont('Arial', '', 8);
        $this->RotatedText(8, 270, "SST-REG-010     Vr. 01      Fec. Aprob.: 03/10/2016", 90);
    }
}

$ver_datos = "select ie.*, e.nombres, e.ape_pat, e.ape_mat from inspeccion_epp as ie inner join empleado as e on ie.inspector = e.codigo "
        . " and ie.empresa = e.empresa where ie.id='" . $id . "' and ie.anio = '" . $anio . "' and ie.empresa = '" . $empresa . "' and "
        . "item = '".$item."'";
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
$pdf->Cell(150, 5, $area, 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, "LOCAL:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 5, $local, 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(20, 5, "CODIGO DOC:", 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(20, 5, $anio . '-' . $cod_id . '-' . $cod_item, 0, 1, 'L');

$listar_epp = "select id, nombre from epp order by id";
$r_epp = $conn->query($listar_epp);
if ($r_epp->num_rows > 0) {
    while ($fila = $r_epp->fetch_assoc()) {
        $lista_epp[] = $fila['id'];
        $lista_epp_nombres[] = $fila['nombre'];
    }
}

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(195, 6, "RELACION DE COLABORADORES", 0, 1, 'C');
$pdf->Cell(6, 6, "Item", 1, 0, 'C');
$pdf->Cell(10, 6, "COD", 1, 0, 'C');
$pdf->Cell(80, 6, "APELLIDOS Y NOMBRES", 1, 0, 'C');
$ancho = 65 / count($lista_epp);
for ($index = 0; $index < count($lista_epp); $index++) {
    $pdf->Cell($ancho, 6, $lista_epp[$index], 1, 0, 'C');
}
$pdf->Cell(30, 6, "FIRMA", 1, 1, 'C');
$pdf->SetFont('Arial', '', 9);
for ($index_fila = 0; $index_fila < 17; $index_fila++) {
    $pdf->Cell(6, 8,$index_fila + 1 , 1, 0, 'C');
    $pdf->Cell(10, 8,"", 1, 0, 'C');
    $pdf->Cell(80, 8,"", 1, 0, 'L');
    for ($index_nombre = 0; $index_nombre < count($lista_epp); $index_nombre++) {
        $pdf->Cell($ancho, 8, "", 1, 0, 'C');
    }
    $pdf->Cell(30, 8, "", 1, 1, 'C');
}


$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60, 7, "LEYENDA EPP", 0, 1, 'C');
$pdf->Cell(10, 5, "COD", 1, 0, 'C');
$pdf->Cell(50, 5, "DESCRIPCION", 1, 1, 'C');
$pdf->SetFont('Arial', '', 8);
for ($index = 0; $index < count($lista_epp); $index++) {
    $pdf->Cell(10, 5, $lista_epp[$index], 1, 0, 'C');
    $pdf->Cell(50, 5, $lista_epp_nombres[$index], 1, 1, 'L');
}

$pdf->Output();
ob_end_flush();
?>
