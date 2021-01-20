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
        $this->MultiCell(140, 5, "REGISTRO DE SIMULACROS", 0, 'R');
        $this->Cell(195, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
    }

    function Footer() {
        $this->SetFont('Arial', '', 8);
        $this->RotatedText(8, 270, "SST-REG-046     Vr. 01      Fec. Aprob.: 03/10/2016", 90);
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

$ver_datos = "select ps.*, e.nombres, e.ape_pat, e.ape_mat from programa_simulacros as ps inner join empleado as e on ps.observador = e.codigo and ps.empresa = e.empresa where ps.id='" . $id . "' and ps.anio = '" . $anio . "' and ps.empresa = '" . $empresa . "'";
$r_simulacro = $conn->query($ver_datos);
if ($r_simulacro->num_rows > 0) {
    while ($fila = $r_simulacro->fetch_assoc()) {
        $observador = $fila['nombres'] . ' ' . $fila['ape_pat'] . ' ' . $fila['ape_mat'];
        $lugar = $fila['lugar'];
        $fecha = $varios->fecha_hora_segundos_tabla($fila['fecha_programado']);
        $simulacion = $fila['simulacion_creada'];
        $magnitud = $fila['magnitud'];
        $antes = $fila['antes'];
        $durante = $fila['durante'];
        $despues = $fila['despues'];
        $apoyo = $fila['externo'];
        $observaciones = $fila['observaciones'];
        $recomendaciones = $fila['recomendaciones'];
        $conclusiones = $fila['conclusiones'];
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->Ln(13);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 10, "SITUACION CREADA", 0, 1, 'C');

$pdf->Cell(40, 5, "INSTALACION:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(150, 5, $lugar, 0, 1, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "FECHA:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(150, 5, $fecha, 0, 1, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "SIMULACION CREADA:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $simulacion, 0, 'J');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "MAGNITUD:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $magnitud, 0, 'J');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "OBSERVADOR:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, utf8_decode("Se designará como observador al ingeniero de seguridad de MASS: " . $observador . " quien "
                . "tomaran todos los datos sobre el simulacro y, al término del mismo se reunirán con los participantes en los puntos de encuentro "
                . "más cercano para comentar todas las observaciones encontradas."), 0, 'J');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 10, "ACCIONES DE RESPUESTA", 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "ANTES:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $antes, 0, 'J');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "DURANTE:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $durante, 0, 'J');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "DESPUES:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $despues, 0, 'J');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "APOYO EXTERNO:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $apoyo, 0, 'J');

$pdf->addPage();
$pdf->Ln(13);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 10, "IMAGENES DEL SIMULACRO", 0, 1, 'C');
$pdf->SetFont('Arial', '', 9);
$cod = str_pad($id, 3, '0', STR_PAD_LEFT);
$ver_imagenes = "select correlativo, imagen, descripcion from imagenes_simulacro where id='" . $id . "' and anio = '" . $anio . "' and empresa = '" . $empresa . "' order by correlativo asc";
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
        $pdf->MultiCell(190,60, $pdf->Image($ruta_imagen, $posicion_x, $pdf->GetY(), 0,60) ,0,"C");
        $pdf->Cell(190, 10, $descripcion, 0, 1, 'C');
        $pdf->Ln(13);
        //$pdf->Image('../upload/' . $empresa . '/simulacros/' . $anio.$cod. '/imagenes/'. $imagen_simulacro, $pdf->GetX(), $pdf->GetY(),180, 100);
        
    }
}

$pdf->addPage();
$pdf->Ln(13);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 10, "RESULTADOS DEL SIMULACRO", 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "OBSERVACIONES:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $observaciones, 0, 'J');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "RECOMENDACIONES:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $recomendaciones, 0, 'J');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, "CONCLUSIONES:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(150, 5, $conclusiones, 0, 'J');

$pdf->Ln(13);
$pdf->Cell(40, 5, "CONCLUSIONES:", 0, 0, 'L');
$pdf->Output();
ob_end_flush();
?>
