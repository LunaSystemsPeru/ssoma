<?php
session_start();

require '../models/Colaborador.php';
require('../tools/fpdf/rotations.php');
require('../tools/varios.php');
define('FPDF_FONTPATH', '../tools/fpdf/font/');

$ruc_empresa = $_SESSION['ruc_empresa'];
$varios = new Varios();
$colaborador = new Colaborador();

$colaborador->setIdEmpresa($_SESSION['empresa']);
$colaborador->setIdColaborador(filter_input(INPUT_GET, 'colaborador'));
$colaborador->obtenerDatos();

class PDF extends PDF_Rotate
{

//Cabecera de página
    function Header()
    {
        $ruc_empresa = $_SESSION['ruc_empresa'];
        $this->Image('../upload/' . $ruc_empresa . '/carnet/carnet_horizontal.png', 0, 0, 93, 58.5);
    }
}

$pdf = new PDF('L', 'mm', array(93, 58.5));
$pdf->SetMargins(6, 15, 0);
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();

$i = 0;
$h = 3.5;
$id_nacionalidad = $colaborador->getTipoDocumento();
$id_cargo = $colaborador->getIdCargo();
if ($id_cargo == 10) {
    $cargo = "Empleado" ;
} else {
    $cargo = "Obrero";
}
if ($id_nacionalidad == 1) {
    $nacionalidad = "Peruana";
    $documento = "DNI";
} else {
    $nacionalidad = "Venezonala";
    $documento = "CI";
}

$imagen = '../upload/' . $ruc_empresa . '/empleados/perfil/' . $colaborador->getFoto();
if (!file_exists($imagen)) {
    $imagen = "../upload/noimage.png";
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->MultiCell(53, $h+.5, $colaborador->getDato(), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(42.5, $h, "Cargo: " . $cargo, 0, 1, 'L');
$pdf->Cell(42.5, $h, "Nacionalidad: " . $nacionalidad, 0, 1, 'L');
$pdf->Cell(42.5, $h, $documento . " Nro. " . $colaborador->getDocumento(), 0, 2, 'L');
$pdf->Cell(42.5, $h, "Fec Nac. " . $varios->fecha_tabla($colaborador->getFechaNacimiento()), 0, 1, 'L');
$pdf->Image($imagen, 61.5, 13.2, 25.7, 36.15);
$i++;

$pdf->Output('', $ruc_empresa.'-'.$colaborador->getDocumento().'.pdf', false);