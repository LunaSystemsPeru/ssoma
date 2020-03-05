<?php

session_start();
ob_start();
include('../includes/conectar.php');
require('../includes/rotations.php');
require('../includes/varios.php');
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
        $this->MultiCell(140, 5, utf8_decode("DECLARACION JURADA DE DOMICILIO"), 0, 'R');
        $this->Cell(180, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
    }
}

$empleado = $_GET['empleado'];
$empresa = $_GET['empresa'];

$varios = new Varios();

function ver_departamento($id) {
    global $conn;
    $departamento = "";
    $ver_datos = "select nombre from departamento where id = '" . $id . "'";
    $resultado = $conn->query($ver_datos);
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $departamento = $fila['nombre'];
        }
    }
    return $departamento;
}

function ver_provincia($provincia_id, $departamento_id) {
    global $conn;
    $provincia = "";
    $ver_datos = "select nombre from provincia where id = '" . $provincia_id . "' and departamento = '" . $departamento_id . "'";
    $resultado = $conn->query($ver_datos);
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $provincia = $fila['nombre'];
        }
    }
    return $provincia;
}

function ver_distrito($distrito_id, $provincia_id, $departamento_id) {
    global $conn;
    $distrito = "";
    $ver_datos = "select nombre from distrito where id = '" . $distrito_id . "' and provincia = '" . $provincia_id . "' and departamento = '" . $departamento_id . "'";
    $resultado = $conn->query($ver_datos);
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $distrito = $fila['nombre'];
        }
    }
    return $distrito;
}

$ver_datos = "select e.dni, e.nombres, e.ape_pat, e.ape_mat, e.direccion, e.departamento, e.provincia, e.distrito, e.fecha_ingreso, DAY(e.fecha_ingreso) as dia_ingreso, MONTH(e.fecha_ingreso) as mes_ingreso, YEAR(e.fecha_ingreso) as anio_ingreso from empleado as e inner join seguro_pension as sp on e.seguro_pension = sp.id where e.codigo = '" . $empleado . "' and e.empresa = '" . $empresa . "'";
//echo $ver_datos;
$resultado = $conn->query($ver_datos);
if ($resultado->num_rows > 0) {
    if ($fila = $resultado->fetch_assoc()) {
        $nombre_empleado = $fila['ape_pat'] . ' ' . $fila['ape_mat'] . ' ' . $fila['nombres'];
        $dni = $fila['dni'];
        $domicilio = $fila['direccion'];
        $dia = $fila['dia_ingreso'];
        $mes = $fila['mes_ingreso'];
        $anio = $fila['anio_ingreso'];
        $id_provincia = $fila['provincia'];
        $id_distrito = $fila['distrito'];
        $id_departamento = $fila['departamento'];
        $departamento = ver_departamento($id_departamento);
        $provincia = ver_provincia($id_provincia, $id_departamento);
        $distrito = ver_distrito($id_distrito, $id_provincia, $id_departamento);
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetMargins(20, 10, 20);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->Ln(13);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(170, 15, "DECLARACION JURADA DE DOMICILIO", 0, 1, 'C');
$pdf->SetFont('Arial', '', 9);

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 14);
$pdf->MultiCell(170, 10, "Yo " . $nombre_empleado . ", identificado con DNI Nro: " . $dni, 0, 'J');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 16);
$pdf->MultiCell(170, 10, "DECLARO BAJO JURAMENTO", 0, 'L');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 16);
$pdf->MultiCell(170, 10, utf8_decode("Que, mi domicilio legal esta ubicado en " . $domicilio . " en el distrito de " . $distrito . ", en la provincia de " . $provincia . " y en el departamento de " . $departamento . ". De acuerdo a la norma legal del Art. 1 de la Ley 28882 LEY DE SIMPLIFICACION DE LA CERTIFICACION DOMICILIARIA"), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(170, 10, utf8_decode("Para mayor veracidad de la presente Declaración Jurada firmo y pongo mi huella digital a los $dia días del mes de " . $varios->nombremes($mes) . " del $anio"), 0, 'J');

$pdf->SetFont('Arial', '', 14);
$pdf->Ln(10);
$pdf->MultiCell(170, 10, utf8_decode("Atentamente"), 0, 'C');

$pdf->SetY(-60);
$pdf->Cell(170, 10, "______________", 0, 1, 'C');
$pdf->Cell(170, 8, "Firma y Huella", 0, 1, 'C');
$pdf->Cell(170, 8, "DNI: " . $dni, 0, 1, 'C');
$pdf->Output();
ob_end_flush();
?>
