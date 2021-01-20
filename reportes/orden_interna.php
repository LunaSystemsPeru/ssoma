<?php
require '../models/Orden_Interna.php';
require '../models/Empresa.php';
require '../models/Cliente.php';
require '../models/Usuario.php';
require('../tools/fpdf/rotations.php');
require('../tools/varios.php');
define('FPDF_FONTPATH', '../tools/fpdf/font/');

$orden = new Orden_Interna();
$empresa = new Empresa();
$cliente = new Cliente();
$usuario = new Usuario();
$varios = new Varios();

$orden->setId(filter_input(INPUT_GET, 'id_orden'));
$orden->obtenerDatos();

$empresa->setIdEmpresa($orden->getIdEmpresa());
$empresa->obtenerDatos();

$cliente ->setId($orden->getIdCliente());
$cliente->obtenerDatos();

$usuario->setIdUsuario($orden->getIdUsuario());
$usuario->obtenerDatos();

class PDF extends PDF_Rotate
{

//Cabecera de página
    function Header()
    {
        //
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->SetMargins(15, 10, 15);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->Image("../upload/" . $empresa->getRuc() . "/" . $empresa->getLogo(), 10, 5,80, 20);

$pdf->SetFont('Arial', 'B', 15);
$pdf->SetX(115);
$pdf->Cell(80, 6, "ORDEN INTERNA DE SERVICIO", 0, 1, 'R', 0);
$pdf->Ln(10);

$altura= 5;
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(180, $altura,$empresa->getDireccion(), 0, 1, 'L', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(180, $altura,"OIS #: " .  $orden->getCodigo(), 0, 1, 'R', 0);
$pdf->Cell(180, $altura,"OIS Fecha: " .  $varios->fecha_tabla($orden->getFechaGenerado()), 0, 1, 'R', 0);
$pdf->Cell(70, $altura,"Solicitado por: ", 0, 0, 'R', 0);
$pdf->Cell(110, $altura,$orden->getSolicitante(), 1, 1, 'L', 0);
$pdf->Cell(70, $altura,"Cliente:", 0, 0, 'R', 0);
$pdf->Cell(110, $altura,$cliente->getRazon(), 1, 1, 'L', 0);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(37, $altura,"Servicio:", 1, 0, 'L', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(143, $altura,$orden->getObservaciones(), 1, 1, 'L', 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(37, $altura,"Direccion Ejecucion:", 1, 0, 'L', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(143, $altura,$orden->getSedeServicio(), 1, 1, 'L', 0);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(37, $altura,"Generado por:", 0, 0, 'L', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(110, $altura,$usuario->getDato(), 0, 1, 'L', 0);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(37, $altura,"FACTURAR A:", 0, 1, 'L', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(110, $altura,"RUC: " . $cliente->getRuc(), 0, 1, 'L', 0);
$pdf->Cell(110, $altura,$cliente->getRazon(), 0, 1, 'L', 0);
$pdf->MultiCell(180, $altura, $cliente->getDireccion());

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(180, $altura,"DETALLE", 1, 1, 'L', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(180, $altura, $orden->getDetalle(), 0, 'J');

$pdf->SetY(150);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(180, $altura,"INSUMOS", 1, 1, 'L', 0);
$pdf->Cell(180, 30,"", 1, 1, 'L', 0);

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(45, $altura,"Fecha de Inicio:", 1, 0, 'L', 0);
$pdf->Cell(30, $altura,$varios->fecha_tabla($orden->getFechaInicio()), 1, 1, 'L', 0);
$pdf->Cell(45, $altura,"Duracion:", 1, 0, 'L', 0);
$pdf->Cell(30, $altura,$orden->getDuracion(), 1, 1, 'L', 0);
$pdf->Cell(45, $altura,"Monto:", 1, 0, 'L', 0);
$pdf->Cell(30, $altura,"S/ " . number_format($orden->getMonto() * 1.18, 2), 1, 1, 'L', 0);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(180, $altura,"Observaciones", 1, 1, 'L', 0);
$pdf->Cell(180, $altura,"", 1, 1, 'L', 0);
$pdf->Cell(180, $altura,"", 1, 1, 'L', 0);
$pdf->Cell(180, $altura,"", 1, 1, 'L', 0);
$pdf->Cell(180, $altura,"", 1, 1, 'L', 0);

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(180, $altura,"Responsable del Servicio: " . $orden->getResponsable(), 0, 1, 'L', 0);

$pdf->SetY(282);
$pdf->Cell(90, $altura,"REG-OPE-022    Fec.: 01/03/2020   Version: 01", 0, 0, 'L', 0);
$pdf->Cell(90, $altura,"Documento Controlado", 0, 1, 'R', 0);
$pdf->Output('I', "ORDEN-SERVICIO-NRO-" . $orden->getCodigo(), false);