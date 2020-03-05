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
        $this->Cell(280, 5, "REGISTRO DE INSPECCION DE EXTINTORES", 0, 1, 'R');
        $this->Cell(280, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
        $this->Ln(13);
    }

    function Footer() {
        $this->SetFont('Arial', '', 8);
        $this->RotatedText(6, 170, "SST-REG-051     Vr. 01      Fec. Aprob.: 23/05/2016", 90);
    }

}

$varios = new Varios();
$id = $_GET['id'];
$cod_id = str_pad($id, 3, '0', STR_PAD_LEFT);
$empresa = $_SESSION['empresa'];
$anio = $_GET['anio'];
$item = $_GET['item'];
$cod_item = str_pad($item, 3, '0', STR_PAD_LEFT);

$ver_datos = "select ie.*, e.nombres, e.ape_pat, e.ape_mat from inspeccion_extintores as ie inner join empleado as e on ie.inspector = e.codigo "
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

$pdf->SetFont('Arial', '', 8);
$array_criterio = array(
    utf8_decode("¿EL EXTINTOR ESTA NUMERADO?"),
    utf8_decode("¿CUENTA CON SU STICKER DE INSPECCION MENSUAL?"),
    utf8_decode("¿TIENE UN PICTOGRAMA DE CLASE DE FUEGO?"),
    utf8_decode("¿NO HA SOBREPASADO LA FECHA DE VENCIMIENTO?"),
    utf8_decode("¿TIENE EL PASADOR DE SEGURIDAD?"),
    utf8_decode("¿TIENE PRECINTO DE SEGURIDAD?"),
    utf8_decode("¿LA MARCA EN EL  MANÓMETRO ESTA DENTRO DE LO PERMITIDO?"),
    utf8_decode("¿LA MANIJA DE ACARREO ESTA EN BUEN ESTADO?"),
    utf8_decode("¿LA MANGUERA ESTA LIMPIA Y EN BUEN ESTADO?"),
    utf8_decode("¿LA BOQUILLA O TOBERA ESTA LIMPIA Y SIN OBSTRUCCION?"),
    utf8_decode("¿EL SUJETADOR DE MANGUERA ESTA EN BUENAS CONDICIONES?"),
    utf8_decode("¿EL CILINDRO ESTA LIMPIO, SIN ABOLLADURAS, NI RAJADURAS?"),
    utf8_decode("¿EL LUGAR DONDE SE UBICA EL EXTINTOR ESTA LIBRE DE OBSTÁCULOS?"),
);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetTextColor(85, 107, 47);
$pdf->SetFillColor(153, 255, 100);
$pdf->Cell(8, 6, "COD", 1, 0, 'C', 1);
$pdf->Cell(50, 6, "DESCRIPCION", 1, 0, 'C', 1);
$pdf->Cell(20, 6, "SERIE", 1, 0, 'C', 1);
$pdf->Cell(20, 6, "RECARGA", 1, 0, 'C', 1);
$pdf->Cell(30, 6, "UBICACION", 1, 0, 'C', 1);
$ancho = 72 / count($array_criterio);
for ($index = 0; $index < count($array_criterio); $index++) {
    $pdf->Cell($ancho, 6, $index + 1, 1, 0, 'C', 1);
}
$pdf->Cell(40, 6, "ACCIONES CORRECTIVAS", 1, 0, 'C', 1);
$pdf->Cell(40, 6, "OBSERVACIONES", 1, 1, 'C', 1);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', '', 8);
$ver_extintores = "select * from extintor where empresa = '" . $empresa . "'";
$r_extintores = $conn->query($ver_extintores);
$nro_extintores = $r_extintores->num_rows;
if ($nro_extintores > 0) {
    while ($fila = $r_extintores->fetch_assoc()) {
        $id_extintor = $fila['id'];
        $marca = $fila['marca'];
        $serie = $fila['serie'];
        $descripcion = $marca . ' ' . $fila['tipo'] . ' // DE: ' . $fila['capacidad'] . ' KG';
        $area_extintor = $fila['area'];
        $fecha_recarga = $varios->fecha_tabla($fila['fecha_recarga']);
        $ubicacion = $fila['ubicacion'];
        $pdf->Cell(8, 6, $id_extintor, 1, 0, 'C');
        $pdf->Cell(50, 6, $descripcion, 1, 0, 'L');
        $pdf->Cell(20, 6, $serie, 1, 0, 'C');
        $pdf->Cell(20, 6, $fecha_recarga, 1, 0, 'C');
        $pdf->Cell(30, 6, $ubicacion, 1, 0, 'L');
        $ancho = 72 / count($array_criterio);
        for ($index = 0; $index < count($array_criterio); $index++) {
            $pdf->Cell($ancho, 6, "", 1, 0, 'C');
        }
        $pdf->Cell(40, 6, "", 1, 0, 'C');
        $pdf->Cell(40, 6, "", 1, 1, 'C');
    }
}
for ($nro = 0; $nro < 17 - $nro_extintores; $nro++) {
$pdf->Cell(8, 6, "", 1, 0, 'C');
$pdf->Cell(50, 6, "", 1, 0, 'C');
$pdf->Cell(20, 6, "", 1, 0, 'C');
$pdf->Cell(20, 6, "", 1, 0, 'C');
$pdf->Cell(30, 6, "", 1, 0, 'C');
$ancho = 72 / count($array_criterio);
for ($index = 0; $index < count($array_criterio); $index++) {
    $pdf->Cell($ancho, 6, "", 1, 0, 'C');
}
$pdf->Cell(40, 6, "", 1, 0, 'C');
$pdf->Cell(40, 6, "", 1, 1, 'C');
}
/*
  for ($index = 0; $index < count($array_criterio); $index++) {
  $longitud = strlen($array_criterio[$index]);
  if ($longitud > 60) {
  $alto = 10;
  } else {
  $alto = 5;
  }
  $pdf->Cell(65, 5, $array_criterio[$index], 1, 0, 'L');
  $pdf->Cell(20, 5, "", 1, 0, 'C');
  $pdf->Cell(25, 5, "", 1, 0, 'C');
  $pdf->Cell(25, 5, "", 1, 0, 'C');
  $pdf->Cell(30, 5, "___/___/______", 1, 0, 'C');
  $pdf->Cell(30, 5, "SI  /  NO", 1, 0, 'C');
  $pdf->Cell(80, 5, "", 1, 1, 'C');
  } */

$pdf->Ln(8);
$pdf->Cell(95, 5, "INSPECTOR", 1, 0, 'C');
$pdf->Cell(85, 5, "", 0, 0, 'C');
$pdf->Cell(95, 5, "SUPERVISOR", 1, 1, 'C');
$pdf->Cell(95, 20, "", 1, 0, 'L');
$pdf->Cell(85, 10, "", 0, 0, 'C');
$pdf->Cell(95, 20, "", 1, 1, 'L');

$pdf->AddPage();
$pdf->Cell(140, 5, "LEYENDA - DETALLE DE ITEMS", 1, 1, 'C',1);
$pdf->Cell(15, 5, "COD", 1, 0, 'C',1);
$pdf->Cell(125, 5, "DESCRIPCION", 1, 1, 'C',1);
for ($index = 0; $index < count($array_criterio); $index++) {
    $pdf->Cell(15, 5, $index + 1, 1, 0, 'C');
    $pdf->Cell(125, 5, $array_criterio[$index], 1, 1, 'L');
}
$pdf->Output();
ob_end_flush();
?>
