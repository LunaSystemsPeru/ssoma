<?php

session_start();
ob_start();
include ('../includes/conectar.php');
require('../includes/varios.php');
require ('../class/Cl_Eventos.php');
$varios = new Varios();
$eventos = new Eventos();

$empresa = $_SESSION['empresa'];

$id = $_POST['id'];
$anio = $_POST['anio'];
$tipo = $_POST['tipo'];
global $conn;

switch ($tipo) {
    case "EPP":
        $tabla = "inspeccion_epp";
        $pagina = "inspeccion_epp";
        break;
    case "ALMACEN":
        $tabla = "inspeccion_almacen";
        $pagina = "inspeccion_almacen";
        break;
    case "BOTIQUIN":
        $tabla = "inspeccion_botiquin";
        $pagina = "inspeccion_botiquin";
        break;
    case "EXTINTORES":
        $tabla = "inspeccion_extintores";
        $pagina = "inspeccion_extintor";
        break;
    case "OFICINAS":
        $tabla = "inspeccion_oficina";
        $pagina = "inspeccion_oficina";
        break;
    case "ORDEN Y LIMPIEZA":
        $tabla = "inspeccion_limpieza";
        $pagina = "inspeccion_limpieza";
        break;
    case "TRABAJO":
        $tabla = "inspeccion_trabajo";
        $pagina = "inspeccion_trabajo";
        break;
    case "SSHH":
        $tabla = "inspeccion_sshh";
        $pagina = "inspeccion_sshh";
        break;
}

$fecha = obtener_ultima_fecha($empresa, $tabla, $id, $anio, $tipo);
actualizar_inspeccion($empresa, $id, $anio, $tipo, $fecha);
$nuevo_id = obtener_id($empresa, $anio, $tipo);
$nueva_fecha = obtener_nueva_fecha($empresa, $id, $anio, $tipo);

$datos = "select * from programa_inspecciones where empresa = '" . $empresa . "' and anio = '" . $anio . "' and tipo = '" . $tipo . "' and id = '" . $id . "'";
echo $datos;
$r_datos = $conn->query($datos);
if ($r_datos->num_rows > 0) {
    while ($fila = $r_datos->fetch_assoc()) {
        $frecuencia = $fila['frecuencia'];
        $web = $fila['pagina_web'];
    }
}

//registrar evento 
$eventos->setId($eventos->obtener_id($anio, $empresa));
echo "mostrar id evento: " . $eventos->obtener_id($anio, $empresa);
$eventos->setAnio($anio);
$eventos->setTipo_evento(5);
$eventos->setFecha_inicio($nueva_fecha);
$eventos->setFecha_final($nueva_fecha);
$eventos->setEmpresa($empresa);
$eventos->setDescripcion("INSPECCION DE " . $tipo);
$evento_grabado = $eventos->grabar_evento();

if ($evento_grabado) {
    $modificar_inspeccion = "insert into programa_inspecciones values ('" . $nuevo_id . "', '" . $anio . "', '" . $empresa . "', '" . $tipo . "', '" . $frecuencia . "', '" . $web . "', '7000-01-01','" . $nueva_fecha . "', '0')";
    echo $modificar_inspeccion;
    $resultado = $conn->query($modificar_inspeccion);
    if (!$resultado) {
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        echo "Entered data successfully";
        header("Location: ../programa_inspecciones.php");
    }
}

function obtener_ultima_fecha($empresa, $tabla, $id, $anio) {
    $fecha = "";
    global $conn;
    $inspecciones = "select fecha from " . $tabla . " where empresa = '" . $empresa . "' and id = '" . $id . "' and anio = '" . $anio . "' order by fecha desc limit 1";
    echo $inspecciones;
    $r_inspecciones = $conn->query($inspecciones);
    if ($r_inspecciones->num_rows > 0) {
        while ($fila = $r_inspecciones->fetch_assoc()) {
            $fecha = $fila['fecha'];
        }
    } else {
        $fecha = date("Y-m-d");
    }
    return $fecha;
}

function obtener_nueva_fecha($empresa, $id, $anio, $tipo) {
    $fecha = "";
    global $conn;
    $inspecciones = "select frecuencia, date_add(fecha_programa, interval 1 month) as mensual, date_add(fecha_programa, interval 1 week) as semanal, date_add(fecha_programa, interval 2 week) as quincenal from programa_inspecciones where empresa = '" . $empresa . "' and id = '" . $id . "' and anio = '" . $anio . "' and tipo = '" . $tipo . "'";
    echo $inspecciones;
    $r_inspecciones = $conn->query($inspecciones);
    if ($r_inspecciones->num_rows > 0) {
        while ($fila = $r_inspecciones->fetch_assoc()) {
            if ($fila['frecuencia'] == "MENSUAL") {
                $fecha = $fila['mensual'];
            }
            if ($fila['frecuencia'] == "SEMANAL") {
                $fecha = $fila['semanal'];
            }
            if ($fila['frecuencia'] == "QUINCENAL") {
                $fecha = $fila['quincenal'];
            }
        }
    }
    return $fecha;
}

function actualizar_inspeccion($empresa, $id, $anio, $tipo, $fecha) {
    global $conn;
    $modificar_inspeccion = "update programa_inspecciones set fecha_inspeccion = '" . $fecha . "', estado = '1' where id='" . $id . "' and  anio='" . $anio . "' and empresa ='" . $empresa . "' and tipo = '" . $tipo . "'";
    echo $modificar_inspeccion;
    $resultado = $conn->query($modificar_inspeccion);
    if (!$resultado) {
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        echo "Entered data successfully";
    }
}

function obtener_id($empresa, $anio, $tipo) {
    $id_nuevo = 1;
    global $conn;
    $inspecciones = "select id from programa_inspecciones where empresa = '" . $empresa . "' and anio = '" . $anio . "' and tipo = '" . $tipo . "' order by id desc limit 1";
    echo $inspecciones;
    $r_inspecciones = $conn->query($inspecciones);
    if ($r_inspecciones->num_rows > 0) {
        while ($fila = $r_inspecciones->fetch_assoc()) {
            $id_nuevo = $fila['id'] + 1;
        }
    }
    return $id_nuevo;
}

ob_end_flush();
?>
