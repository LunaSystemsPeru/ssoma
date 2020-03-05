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
        $this->MultiCell(140, 5, utf8_decode("INSPECCION DE SERVICIOS HIGIENICOS"), 0, 'R');
        $this->Cell(195, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
    }

    function Footer() {
        $this->SetFont('Arial', '', 8);
        $this->RotatedText(8, 270, "SST-REG-072     Vr. 01      Fec. Aprob.: 03/05/2014", 90);
    }
}

$varios = new Varios();
$id = $_GET['id'];
$cod_id = str_pad($id, 3, '0', STR_PAD_LEFT);
$empresa = $_SESSION['empresa'];
$anio = $_GET['anio'];
$item = $_GET['item'];
$cod_item = str_pad($item, 3, '0', STR_PAD_LEFT);

$ver_datos = "select ie.*, e.nombres, e.ape_pat, e.ape_mat from inspeccion_sshh as ie inner join empleado as e on ie.inspector = e.codigo "
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
$pdf->Cell(190, 6, "DATOS GENERALES", 1, 1, 'C',1);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 6, "NRO. PERSONAS", 0, 0, 'R');
$pdf->Cell(30, 6, "HOMBRES _____", 0, 0, 'R');
$pdf->Cell(25, 6, "", 0, 0, 'C');
$pdf->Cell(40, 6, utf8_decode("NRO. BAÑOS"), 0, 0, 'R');
$pdf->Cell(30, 6, "HOMBRES _____", 0, 0, 'R');
$pdf->Cell(25, 6, "", 0, 1, 'R');
$pdf->Cell(40, 6, "", 0, 0, 'R');
$pdf->Cell(30, 6, "MUJERES _____", 0, 0, 'R');
$pdf->Cell(25, 6, "", 0, 0, 'C');
$pdf->Cell(40, 6, "", 0, 0, 'R');
$pdf->Cell(30, 6, "MUJERES _____", 0, 0, 'R');
$pdf->Cell(25, 6, "", 0, 1, 'R');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(85, 107, 47);
$pdf->SetFillColor(153, 255, 100);
$pdf->Cell(86, 6, "CONDICIONES DEL AREA DE TRABAJO", 1, 0, 'C',1);
$pdf->Cell(10, 6, "SI", 1, 0, 'C',1);
$pdf->Cell(10, 6, "NO", 1, 0, 'C',1);
$pdf->Cell(10, 6, "NA", 1, 0, 'C',1);
$pdf->Cell(10, 6, "CANT.", 1, 0, 'C',1);
$pdf->Cell(64, 6, "OBSERVACIONES", 1, 1, 'C',1);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', '', 8);
$lista_items1 = array(
    utf8_decode("Existe baño en el área"), 
    utf8_decode("Los baños están rotulados (Varones/Mujeres)"), 
    utf8_decode("El acceso es el adecuado"), 
    );

for ($index = 0; $index < count($lista_items1); $index++) {
    $longitud = strlen($lista_items1[$index]);
    if ($longitud > 60) {
        $alto = 12;
    } else {
        $alto = 6;
    }
    $pdf->Cell(6, $alto, $index + 1, 1, 0, 'C');
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(80, 6, $lista_items1[$index], 1, 'J');
    $pdf->setXY($x + 80, $y);
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(64, $alto, "", 1, 1, 'C');
}

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(85, 107, 47);
$pdf->SetFillColor(153, 255, 100);
$pdf->Cell(86, 6, "CONDICIONES DEL AREA DE TRABAJO", 1, 0, 'C',1);
$pdf->Cell(10, 6, "SI", 1, 0, 'C',1);
$pdf->Cell(10, 6, "NO", 1, 0, 'C',1);
$pdf->Cell(10, 6, "NA", 1, 0, 'C',1);
$pdf->Cell(10, 6, "CANT.", 1, 0, 'C',1);
$pdf->Cell(64, 6, "OBSERVACIONES", 1, 1, 'C',1);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', '', 8);
$lista_items2 = array(
    utf8_decode("Cuenta con seguro externo en la puerta"), 
    utf8_decode("Cuenta con seguro interno en la puerta"), 
    utf8_decode("Tiene piso antideslizante"), 
    utf8_decode("Cuenta con papel higiénico"), 
    utf8_decode("Cuenta con tacho con bolsa negra para papeles"), 
    utf8_decode("Cuenta con sistema de ventilación"), 
    utf8_decode("Se cuenta con Personal de limpieza "), 
    utf8_decode("Se mantiene el orden y la limpieza"), 
    utf8_decode("Cuenta con desinfectante para manos / Jabón líquido"), 
    utf8_decode("Ausencia de malos olores"), 
    );

for ($index = 0; $index < count($lista_items2); $index++) {
    $longitud = strlen($lista_items2[$index]);
    if ($longitud > 60) {
        $alto = 12;
    } else {
        $alto = 6;
    }
    $pdf->Cell(6, $alto, $index + 1, 1, 0, 'C');
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(80, 6, $lista_items2[$index], 1, 'J');
    $pdf->setXY($x + 80, $y);
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(64, $alto, "", 1, 1, 'C');
}

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(85, 107, 47);
$pdf->SetFillColor(153, 255, 100);
$pdf->Cell(190, 6, "OPINIONES DEL PERSONAL - ¿ESTA CONFORME CON EL SERVICIO?", 1, 1, 'C',1);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', '', 8);
for ($index = 0; $index < 3; $index++) {
    $alto = 6;
    $pdf->Cell(6, $alto, $index + 1, 1, 0, 'C');
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(80, 6, "PERSONA " . ($index + 1), 1, 'J');
    $pdf->setXY($x + 80, $y);
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(10, $alto, "", 1, 0, 'C');
    $pdf->Cell(64, $alto, "", 1, 1, 'C');
}

$pdf->Ln(10);
$pdf->Cell(190, 6, "NOTA: ESTE REGISTRO SE APLICARA A CADA SERVICIO HIGIENICO", 1, 0, 'L',1);

$pdf->Ln(10);
$pdf->Cell(95, 6, "INSPECTOR", 1, 0, 'C');
$pdf->Cell(95, 6, "SUPERVISOR", 1, 1, 'C');
$pdf->Cell(95, 30, "", 1, 0, 'L');
$pdf->Cell(95, 30, "", 1, 1, 'L');


$pdf->Output();
ob_end_flush();
?>
