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
        $this->MultiCell(140, 5, utf8_decode("INSPECCION PLANEADA A OFICINAS"), 0, 'R');
        $this->Cell(195, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
    }

    function Footer() {
        $this->SetFont('Arial', '', 8);
        $this->RotatedText(8, 270, "SST-REG-030     Vr. 01      Fec. Aprob.: 03/05/2014", 90);
    }
}

$varios = new Varios();
$id = $_GET['id'];
$cod_id = str_pad($id, 3, '0', STR_PAD_LEFT);
$empresa = $_SESSION['empresa'];
$anio = $_GET['anio'];
$item = $_GET['item'];
$cod_item = str_pad($item, 3, '0', STR_PAD_LEFT);

$ver_datos = "select ie.*, e.nombres, e.ape_pat, e.ape_mat from inspeccion_oficina as ie inner join empleado as e on ie.inspector = e.codigo "
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
$pdf->Cell(10, 6, "ITEM", 1, 0, 'C',1);
$pdf->Cell(80, 6, "DESCRIPCION", 1, 0, 'C',1);
$pdf->Cell(10, 6, "C / NC", 1, 0, 'C',1);
$pdf->Cell(10, 6, "NA", 1, 0, 'C',1);
$pdf->Cell(80, 6, "OBSERVACIONES", 1, 1, 'C',1);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', '', 8);
$lista_items1 = array(
    utf8_decode("Los cables, enchufes, tomacorrientes, accesorios y tableros electricos estan en buen estado."), 
    utf8_decode("Las luminarias se encuentran todas operativas"), 
    utf8_decode("Están todos los equipos de iluminación (fluorescentes, focos) con protector o cinta de seguridad colocados "), 
    utf8_decode("Las PC's del área tienen conexión a tierra"), 
    utf8_decode("Los cables estan canaleteados"), 
    utf8_decode("No existen bidones de agua cerca a instalaciones eléctricas"), 
    utf8_decode("No se utilizan triples como adaptadores  "), 
    utf8_decode("El personal conoce la ubicación de los extintores"), 
    utf8_decode("El área de los extintores está despejada"),
    utf8_decode("El borde superior de la pantalla puede situarse a la altura de los ojos o algo por debajo"),
    utf8_decode("La pantalla del monitor se encuentra a una distancia optima (40 cm) "),
    utf8_decode("Conoce la Politica de Seguridad de la empresa"),
    utf8_decode("El nivel de iluminación del punto de trabajo es aceptable, la disposición de las luminarias es la correcta."),
    utf8_decode("Las luminarias cuentan con difusores para impedir la visión directa de la lámpara. "),
    utf8_decode("Las áreas de circulación y salida del personal  están libres de obstrucción."),
    utf8_decode("Pisos, paredes, ventanas en buenas condiciones de mantenimiento."),
    utf8_decode("Pisos, paredes, ventanas, mesas y equipos de trabajo limpios."),
    utf8_decode("Recipientes para residuos identificados y ordenados."),
    utf8_decode("Las computadoras tienen puesta a tierra?"),
    utf8_decode("Las rutas de evacuación estan despejadas?."),
    utf8_decode("Las rutas de evacuación se encuentra señalizadas?"),
    utf8_decode("Los extintores se encuentran inspeccionados?")
    );

for ($index = 0; $index < count($lista_items1); $index++) {
    $longitud = strlen($lista_items1[$index]);
    if ($longitud > 60) {
        $alto = 10;
    } else {
        $alto = 5;
    }
    $pdf->Cell(10, $alto, $index + 1, 1, 0, 'C');
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(80, 5, $lista_items1[$index], 1, 'J');
    $pdf->setXY($x + 80, $y);
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(80, $alto, "", 1, 1, 'C');
}
$pdf->Ln(5);
$pdf->Cell(190, 6, "NOTA: C: cumple / NC: No Cumple", 1, 0, 'L',1);
//añadir valores deficiente, correcta, etc etc

$pdf->Ln(10);
$pdf->Cell(95, 6, "INSPECTOR", 1, 0, 'C');
$pdf->Cell(95, 6, "SUPERVISOR", 1, 1, 'C');
$pdf->Cell(95, 30, "", 1, 0, 'L');
$pdf->Cell(95, 30, "", 1, 1, 'L');


$pdf->Output();
ob_end_flush();
?>
