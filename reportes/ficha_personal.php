<?php
error_reporting(E_ALL);
ob_start();
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

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
        $this->MultiCell(140, 5, utf8_decode("FICHA PERSONAL"), 0, 'R');
        $this->Cell(190, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
        $this->Ln(13);
    }

}

$varios = new Varios();

$codigo = $_GET['id'];
$empresa = $_SESSION['empresa'];

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

$ver_empleado = "select e.codigo, e.dni, e.nombres, e.ape_pat, e.ape_mat, e.direccion, e.fecha_nacimiento, ec.nombre as estado_civil, e.email, ca.nombre as cargo, e.telefono, sp.nombre as seguro_pension, "
		. "gs.nombre as grupo_sanguineo, fs.nombre as factor_sanguineo, e.fecha_ingreso, e.estado, e.imagen, e.provincia, e.departamento, e.distrito, e.cuspp, cat.nombres as categoria "
		. "from empleado as e " 
		. "inner join estado_civil as ec on e.estado_civil = ec.id "
		. "inner join cargo as ca on e.cargo = ca.id "
		. "inner join seguro_pension as sp on e.seguro_pension = sp.id inner join grupo_sanguineo as gs on e.grupo_sanguineo = gs.id "
		. "inner join factor_sanguineo as fs on e.factor_sanguineo = fs.id "
		. "inner join categoria as cat on e.categoria = cat.id "
		. "where e.empresa = '" . $empresa . "' and e.codigo = '" . $codigo . "'";
$resultado = $conn->query($ver_empleado);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $codigo_empleado = $fila['codigo'];
        $dni = $fila['dni'];
        $nombres = $fila['ape_pat'] . ' ' . $fila['ape_mat'] . ' ' . $fila['nombres'];
        $cargo = $fila['cargo'];
        $id_departamento = $fila['departamento'];
        $id_provincia = $fila['provincia'];
        $id_distrito = $fila['distrito'];
        $imagen = $fila['imagen'];
        $direccion = $fila['direccion'];
        $email = $fila['email'];
        $estado_civil = $fila['estado_civil'];
        $fecha_nacimiento = $varios->fecha_tabla($fila['fecha_nacimiento']);
        $fecha_ingreso = $varios->fecha_tabla($fila['fecha_ingreso']);
        $sangre = $fila['grupo_sanguineo'] . ' ' . $fila['factor_sanguineo'];
        $categoria = $fila['categoria'];
        $telefono = $fila['telefono'];
        $cuspp = $fila['cuspp'];
        $seguro_pension = $fila['seguro_pension'];
    }
    $departamento = ver_departamento($id_departamento);
    $provincia = ver_provincia($id_provincia, $id_departamento);
    $distrito = ver_distrito($id_distrito, $id_provincia, $id_departamento);
}


$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

//$pdf->Ln(13);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);

$pdf->Image('../upload/' . $empresa . '/perfil/' . $imagen, 160, 55, 35);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 15, "DATOS GENERALES", 1, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$x = 15;

$pdf->SetX($x);
$pdf->Cell(45, 7, "CODIGO", 0, 0, 'L');
$pdf->Cell(30, 7, ": $codigo", 0, 1, 'L');
$pdf->SetX($x);
$pdf->Cell(45, 7, "NRO. DOC", 0, 0, 'L');
$pdf->Cell(30, 7, ": $dni", 0, 1, 'L');
$pdf->SetX($x);
$pdf->Cell(45, 7, "APELLIDOS Y NOMBRES ", 0, 0, 'L');
$pdf->Cell(30, 7, ": $nombres", 0, 1, 'L');
$pdf->SetX($x);
$pdf->Cell(45, 7, "DOMICILIO", 0, 0, 'L');
$pdf->Cell(30, 7, ": $direccion", 0, 1, 'L');
$pdf->SetX(60);
$pdf->Cell(35, 7, $departamento, 0, 0, 'L');
$pdf->Cell(35, 7, $provincia, 0, 0, 'L');
$pdf->Cell(35, 7, $distrito, 0, 1, 'L');
$pdf->SetX($x);
$pdf->Cell(45, 7, "EMAIL", 0, 0, 'L');
$pdf->Cell(30, 7, ": $email", 0, 1, 'L');
$pdf->SetX($x);
$pdf->Cell(45, 7, "FECHA NACIMIENTO", 0, 0, 'L');
$pdf->Cell(30, 7, ": $fecha_nacimiento", 0, 1, 'L');
$pdf->SetX($x);
$pdf->Cell(45, 7, "TELEFONO / CELULAR", 0, 0, 'L');
$pdf->Cell(30, 7, ": $telefono", 0, 1, 'L');
$pdf->SetX($x);
$pdf->Cell(45, 7, "TIPO DE SANGRE", 0, 0, 'L');
$pdf->Cell(30, 7, ": $sangre", 0, 1, 'L');
$pdf->SetX($x);
$pdf->Cell(45, 7, "ESTADO CIVIL", 0, 0, 'L');
$pdf->Cell(30, 7, ": $estado_civil", 0, 1, 'L');
$pdf->SetX($x);
$pdf->Cell(45, 7, "CATEOGORIA", 0, 0, 'L');
$pdf->Cell(50, 7, ": $categoria", 0, 0, 'L');
$pdf->Cell(30, 7, "CARGO", 0, 0, 'L');
$pdf->Cell(40, 7, ": $cargo", 0, 1, 'L');
$pdf->SetX($x);
$pdf->Cell(45, 7, "FECHA INGRESO", 0, 0, 'L');
$pdf->Cell(30, 7, ": $fecha_ingreso", 0, 1, 'L');
$pdf->SetX($x);
$pdf->Cell(45, 7, "SEGURO DE PENSIONES", 0, 0, 'L');
$pdf->Cell(50, 7, ": $seguro_pension", 0, 0, 'L');
$pdf->Cell(30, 7, "CUSPP", 0, 0, 'L');
$pdf->Cell(40, 7, ": $cuspp", 0, 1, 'L');

//datos familiares
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 15, "DATOS FAMILIARES", 1, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$x = 15;
//buscar empleados en esta empresa
$familia = "select dni, nombre_completo,  YEAR(CURDATE())-YEAR(fecha_nacimiento) as edad, fecha_nacimiento, direccion, telefono, sexo, parentesco from datos_familiares where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
$resultado = $conn->query($familia);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['sexo'] == "F") {
            $sexo = "FEMENINO";
        } else {
            $sexo = "MASCULINO";
        }
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "NRO DOC:", 0, 0, 'R');
        $pdf->Cell(100, 7, $fila['dni'], 0, 0, 'L');
        $pdf->Cell(45, 7, "SEXO: " . $sexo, 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "NOMBRES Y APELLIDOS:", 0, 0, 'R');
        $pdf->Cell(30, 7, $fila['nombre_completo'], 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "TELEFONO / CELULAR:", 0, 0, 'R');
        $pdf->Cell(30, 7, $fila['telefono'], 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "FECHA NACIMIENTO:", 0, 0, 'R');
        $pdf->Cell(30, 7, $varios->fecha_tabla($fila['fecha_nacimiento']), 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "DOMICILIO:", 0, 0, 'R');
        $pdf->Cell(30, 7, $fila['direccion'], 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "PARENTESCO:", 0, 0, 'R');
        $pdf->Cell(30, 7, $fila['parentesco'], 0, 1, 'L');
        $pdf->Ln(5);
    }
} else {
    $pdf->SetX($x);
    $pdf->Cell(45, 15, "NINGUNO", 0, 1, 'R');
}

//experiencia academica
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 15, "DATOS ACADEMICOS", 1, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$x = 15;
//buscar empleados en esta empresa
$estudios = "select id, institucion, tipo, grado from estudios where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
//echo $estudios;
$resultado = $conn->query($estudios);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "INSTITUCION:", 0, 0, 'R');
        $pdf->Cell(100, 7, $fila['institucion'], 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "TIPO:", 0, 0, 'R');
        $pdf->Cell(30, 7, $fila['tipo'], 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "GRADO:", 0, 0, 'R');
        $pdf->Cell(30, 7, $fila['grado'], 0, 1, 'L');
        $pdf->Ln(5);
    }
} else {
    $pdf->SetX($x);
    $pdf->Cell(45, 15, "NINGUNO", 0, 1, 'R');
}

//CURSOS DE ESPECIALIZACION
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 15, "CURSOS DE ESPECIALIZACION / OTROS", 1, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$x = 15;

$familia = "select id, institucion, descripcion, duracion, tipo_duracion from cursos where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
$resultado = $conn->query($familia);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "INSTITUCION:", 0, 0, 'R');
        $pdf->Cell(100, 7, $fila['institucion'], 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "DESCRIPCION:", 0, 0, 'R');
        $pdf->Cell(130, 7, $fila['descripcion'], 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "DURACION:", 0, 0, 'R');
        $pdf->Cell(30, 7, $fila['duracion'] . ' ' . $fila['tipo_duracion'], 0, 1, 'L');
        $pdf->Ln(5);
    }
} else {
    $pdf->SetX($x);
    $pdf->Cell(45, 15, "NINGUNO", 0, 1, 'R');
}

//EXPERIENCIA LABORAL
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 15, "EXPERIENCIA LABORAL", 1, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$x = 15;
$familia = "select id, empresa, cargo, fecha_inicio, fecha_fin, motivo_cese from experiencia_laboral where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
$resultado = $conn->query($familia);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $pdf->SetX($x);
        $pdf->Cell(25, 7, "EMPRESA:", 0, 0, 'L');
        $pdf->Cell(100, 7, $fila['empresa'], 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(25, 7, "CARGO:", 0, 0, 'L');
        $pdf->Cell(130, 7, $fila['cargo'], 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(25, 7, "DURACION:", 0, 0, 'L');
        $pdf->Cell(30, 7, 'Desde: ' . $varios->fecha_tabla($fila['fecha_inicio']) . ' - al: ' . $varios->fecha_tabla($fila['fecha_fin']), 0, 1, 'L');
        $pdf->Ln(5);
    }
} else {
    $pdf->SetX($x);
    $pdf->Cell(45, 15, "NINGUNO", 0, 1, 'R');
}

//CONTACTO EMERGENCIA
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 15, "CONTACTO EMERGENCIA", 1, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$x = 15;
$familia = "select nombre_completo, direccion, telefono, sexo, parentesco from contacto_emergencia where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
$resultado = $conn->query($familia);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['sexo'] == "F") {
            $sexo = "FEMENINO";
        } else {
            $sexo = "MASCULINO";
        }
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "NOMBRES Y APELLIDOS:", 0, 0, 'R');
        $pdf->Cell(30, 7, $fila['nombre_completo'], 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "TELEFONO / CELULAR:", 0, 0, 'R');
        $pdf->Cell(100, 7, $fila['telefono'], 0, 0, 'L');
        $pdf->Cell(45, 7, "SEXO: " . $sexo, 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "DOMICILIO:", 0, 0, 'R');
        $pdf->Cell(30, 7, $fila['direccion'], 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->Cell(45, 7, "PARENTESCO:", 0, 0, 'R');
        $pdf->Cell(30, 7, $fila['parentesco'], 0, 1, 'L');
        $pdf->Ln(5);
    }
} else {
    $pdf->SetX($x);
    $pdf->Cell(45, 15, "NINGUNO", 0, 1, 'R');
}
$pdf->Output();
ob_end_flush();
?>
