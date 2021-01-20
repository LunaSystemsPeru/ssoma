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
        //$ruc_empresa = $_SESSION['ruc_empresa'];
        //$this->Image('../upload/' . $ruc_empresa . '/carnet/carnet_horizontal.png', 0, 0, 91.5, 59.5);
    }
}

$pdf = new PDF('P', 'mm', Array("22","280"));
$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(true, 1);
$pdf->AddPage();

    $pdf->SetFont('Arial', '', 9);
    
$i = 0;
$h = 3.5;
foreach ($a_lista as $fila) {
    $imagen = '../upload/' . $ruc_empresa . '/empleados/perfil/' . $fila['foto'];
    if (!file_exists($imagen)) {
        $imagen = "../upload/noimage.png";
    }

    //$pdf->SetY(($i * 59.5) + 20);
    $documento =  $fila['documento'];
    $pdf->Cell(22, 3.5, $documento, 1,1, 'L');
    $pdf->Cell(22,27.5, $pdf->Image($imagen, $pdf->GetX(), $pdf->GetY(), 22, 27.5), 1,1, 'L');
        //$pdf->Ln(1);
}
$pdf->Output();