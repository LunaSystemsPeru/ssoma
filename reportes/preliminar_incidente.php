<?php

ob_start();
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:../login.php");
}
include('../includes/conectar.php');
require('../includes/fpdf.php');
require('../includes/varios.php');
//require('../includes/rotations.php');
define('FPDF_FONTPATH', '../includes/font/');


$varios = new Varios();
$id = $_GET['id'];
$empresa = $_SESSION['empresa'];
$anio = $_GET['anio'];

class PDF extends FPDF {

    //Cabecera de página
    function Header() {
        $empresa = $_SESSION['empresa'];
        $imagen = "MEMBRETE_SUPERIOR_FISHONE.jpg";
        $this->Image('../upload/' . $empresa . '/documentos/' . $imagen, 0, 0, 230, 35);
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(250, 250, 250);
        $this->SetX(65);
        $this->MultiCell(140, 5, "REPORTE PRELIMINAR DE INCIDENTES O ACCIDENTES", 0, 'R');
        $this->Cell(195, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
    }

    function Footer() {
        $this->SetFont('Arial', '', 8);
        $this->RotatedText(8, 270, "SST-REG-008     Vr. 01      Fec. Aprob.: 03/10/2016", 90);
    }

    var $angle = 0;

    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle*=M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function RotatedImage($file, $x, $y, $w, $h, $angle) {
        //Image rotated around its upper-left corner
        $this->Rotate($angle, $x, $y);
        $this->Image($file, $x, $y, $w, $h);
        $this->Rotate(0);
    }

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function _endpage() {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

}

$ver_datos = "select pi.*, e.nombres, e.ape_pat, e.ape_mat from preliminar_incidente as pi inner join empleado as e on pi.involucrado= e.codigo and pi.empresa = e.empresa where pi.id='" . $id . "' and pi.anio = '" . $anio . "' and pi.empresa = '" . $empresa . "'";
$r_incidente = $conn->query($ver_datos);
if ($r_incidente->num_rows > 0) {
    while ($fila = $r_incidente->fetch_assoc()) {
        $tipo = $fila['tipo_accidente'];
        $involucrado = $fila['nombres'] . ' ' . $fila['ape_pat'] . ' ' . $fila['ape_mat'];
        $gravedad = $fila['consecuencia_probable'];
        $fecha = $varios->fecha_tabla($fila['fecha']);
        $ubicacion= $fila['ubicacion'];
        $hora= $fila['hora'];
        $area= $fila['area'];
        $descripcion= $fila['descripcion_evento'];
        $perdida= $fila['descripcion_perdida'];
        $causas_inmediatas= $fila['causas_inmediatas'];
        $causas_basicas= $fila['causas_basicas'];
        $acciones_inmediatas= $fila['acciones_inmediatas'];
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->Ln(13);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 10, "DETALLES DE LA INVESTIGACION PRELIMINAR", 0, 1, 'L');
$pdf->Cell(40, 5, "TIPO / GRAVEDAD:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(150, 5, $tipo . ' / ' . $gravedad, 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "FECHA:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(150, 5, $fecha, 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "HORA:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $hora, 0, 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "UBICACION:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $ubicacion, 0, 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "INVOLUCRADO:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $involucrado, 0, 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "AREA:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $area, 0, 'J');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 10, "DATOS DEL INCIDENTE", 0, 1, 'L');
$pdf->Cell(60, 5, "BREVE DESCRIPCION:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(130, 5, $descripcion, 0, 'J');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 5, "DESCRIPCION PERDIDA:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(130, 5, $perdida, 0, 'J');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 5, "PROBABLES CAUSAS INMEDIATAS:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(130, 5, $causas_inmediatas, 0, 'J');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 5, "PROBABLES CAUSAS BASICAS:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(160, 5, $causas_basicas, 0, 'J');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 5,"ACCIONES INMEDIATAS:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(160, 5, $acciones_inmediatas, 0, 'J');

$pdf->addPage();
$pdf->Ln(13);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 10, "IMAGENES DE LA INVESTIGACION PRELIMINAR", 0, 1, 'C');
$pdf->SetFont('Arial', '', 9);
$cod = str_pad($id, 3, '0', STR_PAD_LEFT);
$ver_imagenes = "select imagen from imagenes_preliminar where id='" . $id . "' and anio = '" . $anio . "' and empresa = '" . $empresa . "'";
$r_fotos = $conn->query($ver_imagenes);
if ($r_fotos->num_rows > 0) {
    while ($fila = $r_fotos->fetch_assoc()) {
        $imagen_simulacro = $fila['imagen'];
        $descripcion = $fila['descripcion'];
        $ruta_imagen = '../upload/' . $empresa . '/simulacros/' . $anio.$cod. '/imagenes/'. $imagen_simulacro;
        list($ancho, $alto, $tipo, $atributos) = getimagesize($ruta_imagen);
        $factor_x = $alto / 60;
        $factor_y = $ancho / 190;
        $posicion_x = (210 - ($ancho / $factor_x)) / 2;
        $pdf->MultiCell(90,60, $pdf->Image($ruta_imagen, $posicion_x, $pdf->GetY(), 0,60) ,0,"C");
        $pdf->Ln(13);
        //$pdf->Image('../upload/' . $empresa . '/simulacros/' . $anio.$cod. '/imagenes/'. $imagen_simulacro, $pdf->GetX(), $pdf->GetY(),180, 100);
        
    }
}

$pdf->Output();
ob_end_flush();
?>
