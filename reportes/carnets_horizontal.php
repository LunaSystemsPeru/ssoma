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
$a_lista = $colaborador->verFilasFotos();

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
$pdf->SetMargins(8, 20, 0);
$pdf->SetAutoPageBreak(true, 17);
$pdf->AddPage();

$i = 0;
$h = 3.5;
foreach ($a_lista as $fila) {
    //$pdf->SetY(($i * 59.5) + 20);
    $id_nacionalidad = $fila['tipo_documento'];
    $id_cargo = $fila['id_cargo'];
    if ($id_nacionalidad == 1) {
        $nacionalidad =  "Peruana";
        $documento = "DNI";
    } else {
        $nacionalidad =  "Venezonala";
        $documento = "CI";
    }

    $imagen = '../upload/' . $ruc_empresa . '/empleados/perfil/' . $fila['foto'];
    if (!file_exists($imagen)) {
        $imagen = "../upload/noimage.png";
    }

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->MultiCell(51, $h, utf8_decode($fila['datos']), 0, 'L');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(51, $h, "Cargo: Obrero", 0, 1, 'L');
    $pdf->Cell(51, $h, "Nacionalidad: " . $nacionalidad, 0, 1, 'L');
    $pdf->Cell(51, $h, $documento . " Nro. " . $fila['documento'], 0, 2, 'L');
    $pdf->Cell(51, $h, "Fec Nac. " . $varios->fecha_tabla($fila['fecha_nacimiento']), 0, 1, 'L');
    $pdf->Image($imagen, 60.048, 14.069, 26.2, 33.15);
    $i++;
    if (strlen($fila['datos']) < 27) {
        $pdf->Ln($h);
    }
}
$pdf->Output();