<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
require 'class/cl_archivos_empleados.php';

include_once 'includes/conectar.php';
require("includes/varios.php");


$c_archivos = new cl_archivos_empleados();
$varios = new Varios();

$codigo = filter_input(INPUT_GET, 'id');
$empresa = $_SESSION['empresa'];

$c_archivos->setId_empleado($codigo);
$c_archivos->setId_empresa($empresa);

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

$ver_empleado = "select e.codigo, e.dni, e.nombres, e.direccion, e.renta_5ta, e.fecha_nacimiento, ec.nombre as estado_civil, e.email, ca.nombre as cargo, e.telefono, sp.nombre as seguro_pension, gs.nombre as grupo_sanguineo, fs.nombre as factor_sanguineo, e.fecha_ingreso, e.estado, e.imagen, e.provincia, e.departamento, e.distrito, e.cuspp, cat.nombres as categoria "
        . "from empleado as e "
        . "inner join estado_civil as ec on e.estado_civil = ec.id "
        . "inner join cargo as ca on e.cargo = ca.id "
        . "inner join seguro_pension as sp on e.seguro_pension = sp.id "
        . "inner join grupo_sanguineo as gs on e.grupo_sanguineo = gs.id "
        . "inner join factor_sanguineo as fs on e.factor_sanguineo = fs.id "
        . "inner join categoria as cat on e.categoria = cat.id "
        . "where e.empresa = '" . $_SESSION['empresa'] . "' and e.codigo = '" . $codigo . "'";
$resultado = $conn->query($ver_empleado);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $codigo_empleado = $fila['codigo'];
        $dni = $fila['dni'];
        $nombres = $fila['nombres'];
        $cargo = $fila['cargo'];
        $id_departamento = $fila['departamento'];
        $estado_civil = $fila['estado_civil'];
        $id_provincia = $fila['provincia'];
        $id_distrito = $fila['distrito'];
        $imagen = $fila['imagen'];
        $direccion = $fila['direccion'];
        $email = $fila['email'];
        $fecha_nacimiento = $varios->fecha_tabla($fila['fecha_nacimiento']);
        $fecha_ingreso = $varios->fecha_tabla($fila['fecha_ingreso']);
        $sangre = $fila['grupo_sanguineo'] . ' ' . $fila['factor_sanguineo'];
        $categoria = $fila['categoria'];
        $telefono = $fila['telefono'];
        $cuspp = $fila['cuspp'];
        $seguro_pension = $fila['seguro_pension'];
        $renta_5ta = $fila['renta_5ta'];
    }
    $departamento = ver_departamento($id_departamento);
    $provincia = ver_provincia($id_provincia, $id_departamento);
    $distrito = ver_distrito($id_distrito, $id_provincia, $id_departamento);
}
?>
<!DOCTYPE html>
<html lang="es">


    <!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Empleados | Software Gestion de Seguridad Industrial</title>


        <!--STYLESHEET-->
        <!--=================================================-->



        <!--Bootstrap Stylesheet [ REQUIRED ]-->
        <link href="css/bootstrap.min.css" rel="stylesheet">


        <!--Nifty Stylesheet [ REQUIRED ]-->
        <link href="css/nifty.min.css" rel="stylesheet">


        <!--Font Awesome [ OPTIONAL ]-->
        <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">


        <!--Switchery [ OPTIONAL ]-->
        <link href="plugins/switchery/switchery.min.css" rel="stylesheet">


        <!--Bootstrap Select [ OPTIONAL ]-->
        <link href="plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">


        <!--Bootstrap Table [ OPTIONAL ]-->
        <link href="plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">


        <!--Demo [ DEMONSTRATION ]-->
        <link href="css/demo/nifty-demo.min.css" rel="stylesheet">


        <script type="text/javascript">
            function add_empleado() {
                document.location.href = "registra_empleado.php";
            }
            function ver_galeria() {
                document.location.href = "galeria_empleados.php";
            }
        </script>


        <!--SCRIPT-->
        <!--=================================================-->

        <!--Page Load Progress Bar [ OPTIONAL ]-->
        <link href="plugins/pace/pace.min.css" rel="stylesheet">
        <script src="plugins/pace/pace.min.js"></script>



        <!--
                
                REQUIRED
                You must include this in your project.
                
                RECOMMENDED
                This category must be included but you may modify which plugins or components which should be included in your project.
                
                OPTIONAL
                Optional plugins. You may choose whether to include it in your project or not.
                
                DEMONSTRATION
                This is to be removed, used for demonstration purposes only. This category must not be included in your project.
                
                SAMPLE
                Some script samples which explain how to initialize plugins or components. This category should not be included in your project.
                
                
                Detailed information and more samples can be found in the document.
                
        -->


    </head>

    <!--TIPS-->
    <!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

    <body>
        <div id="container" class="effect mainnav-lg">

            <!--NAVBAR-->
            <!--===================================================-->
            <?php include("includes/header.php"); ?>
            <!--===================================================-->
            <!--END NAVBAR-->

            <div class="boxed">

                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">
                    <div id="page-content">
                        <div class="row">
                            <div class="row col-lg-3">
                                <div  class="panel">

                                    <!-- Simple profile -->
                                    <div class="text-center pad-all">
                                        <div class="pad-ver" >
                                            <img src="<?php echo 'upload/' . $empresa . '/perfil/' . $imagen; ?>" class="img-lg img-border img-lg" alt="Profile Picture">
                                        </div>
                                    </div>
                                    <hr>
                                    <ul class="list-group bg-trans">
                                        <div class="pad-hor">
                                            <h5>Documentos Asociados</h5>
                                        </div>
                                        <!-- Profile Details -->
                                        <li class="list-group-item list-item-sm">
                                            <a href="reportes/ficha_personal.php?id=<?php echo $codigo; ?>" ><i class="fa fa-file-text-o fa-fw"></i> Ficha Personal</a>
                                        </li>
                                        <?php
                                        $ver_datos = "select id, fecha, medio, tipo, antecedentes from antecedentes where empresa = '" . $_SESSION['empresa'] . "' and empleado = '" . $codigo . "' and medio like '%DECLARACION%' and antecedentes = 'NO'";
                                        $resultado = $conn->query($ver_datos);
                                        if ($resultado->num_rows > 0) {
                                            while ($fila = $resultado->fetch_assoc()) {
                                                echo '<li class="list-group-item list-item-sm">
													<a href="reportes/antecedentes.php?codigo=' . $fila['id'] . '&empleado=' . $codigo . '&empresa=' . $empresa . '" ><i class="fa fa-file-text-o fa-fw"></i> Declaracion Jurada Antecedentes ' . ucwords(strtolower(($fila['tipo']))) . '</a>
													</li>';
                                            }
                                        }
                                        ?>
                                        <li class="list-group-item list-item-sm">
                                            <a href="reportes/domicilio.php?empleado=<?php echo $codigo ?>&empresa=<?php echo $empresa ?>" ><i class="fa fa-file-text-o fa-fw"></i> Declaracion Jurada de Domiclio</a>
                                        </li>
                                        <?php if ($renta_5ta == "0") { ?>
                                            <li class="list-group-item list-item-sm">
                                                <a href="reportes/renta_5ta.php?empleado=<?php echo $codigo ?>&empresa=<?php echo $empresa ?>" ><i class="fa fa-file-text-o fa-fw"></i> Declaracion Jurada Renta de 5ta Categoria</a>
                                            </li>
                                        <?php } ?>
                                        <?php if ($seguro_pension != "ONP") { ?>
                                            <li class="list-group-item list-item-sm">
                                                <a href="reportes/afp.php?empleado=<?php echo $codigo ?>&empresa=<?php echo $empresa ?>" ><i class="fa fa-file-text-o fa-fw"></i> Declaracion Jurada AFP</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <hr>
                                    <ul class="list-group bg-trans">
                                        <div class="pad-hor">
                                            <h5>Documentos Asociados</h5>
                                        </div>
                                        <!-- Profile Details -->
                                        <li class="list-group-item list-item-sm">
                                            <a href="reportes/historial_epp.php?empleado=<?php echo $codigo?>" target="_blank"><i class="fa fa-file-text-o fa-fw"></i> Historial de Entrega EPP</a>
                                        </li>
                                    </ul>
                                    <hr>
                                    <div class="text-center clearfix">
                                        <div class="col-xs-6">
                                            <p class="h3">100%</p>
                                            <small class="text-muted">Asistencia</small>
                                        </div>
                                        <div class="col-xs-6">
                                            <p class="h3">0</p>
                                            <small class="text-muted">Sansiones</small>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <!--Page content-->
                                <!--===================================================-->

                                <div class="panel">

                                    <!--Panel heading-->
                                    <div class="panel-heading">
                                        <div class="panel-control">
                                            <button onclick="agregar_documento()" class="demo-panel-ref-btn btn btn-purple"> 
                                                <i class="demo-psi-repeat-2 icon-fw"></i> Agregar
                                            </button>
                                        </div>
                                        <h3 class="panel-title">Ver Documentos Adjuntos</h3>
                                    </div>

                                    <!--Panel body-->
                                    <div class="panel-body">
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $a_archivos = $c_archivos->ver_archivos();
                                                foreach ($a_archivos as $value) {
                                                    $directorio = "upload/" . $empresa . "/perfil/" . $value['id_empleado'] . "/documentos/" . $value['archivo'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $value['nombre'] ?></td>
                                                        <td>
                                                            <a href="<?php echo $directorio ?>" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal fade" id="modal_archivo">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Agregar Archivo</h4>
                                            </div>
                                            <form class="form-horizontal" id="frm_registrar" method="post" action="inserts/reg_archivos_empleado.php" enctype="multipart/form-data">
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Descripcion</label>
                                                        <div class="col-md-10">
                                                            <input type="text" name="input_descripcion" class="form-control" required="true" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Seleccionar Archivo</label>
                                                        <div class="col-md-10">
                                                            <input class="form-control" type="file" name="file" id="file" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="input_empleado" value="<?php echo $codigo ?>">
                                                    <input type="hidden" name="input_empresa" value="<?php echo $empresa ?>">
                                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                                    <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!--Page content-->
                                <!--===================================================-->
                            </div>

                            <div class="row col-lg-9">
                                <div class="panel ">
                                    <div class="panel-heading">
                                        <div class="panel-control">
                                            <button onclick="edita_empleado('<?php echo $codigo; ?>', '<?php echo $empresa; ?>')" class="demo-panel-ref-btn btn btn-purple" data-target="#demo-panel-ref" data-toggle="panel-overlay">
                                                <i class="demo-psi-repeat-2 icon-fw"></i> Editar
                                            </button>
                                        </div>
                                        <h3 class="panel-title">Datos Generales</h3>
                                    </div>
                                    <div class="panel-body">
                                        <form class="form-horizontal" id="graba_familiar" action="inserts/add_familiar.php" method="post">
                                            <!--Modal body-->
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Codigo</label>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $codigo_empleado; ?></label>
                                                    </div>
                                                    <label class="col-lg-3 control-label">DNI</label>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $dni; ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Apellidos y Nombres</label>
                                                    <div class="col-lg-7">
                                                        <label class="form-control"><?php echo $nombres; ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Domilicio</label>
                                                    <div class="col-lg-7">
                                                        <label class="form-control"><?php echo $direccion; ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label"></label>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $departamento; ?></label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $provincia; ?></label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $distrito; ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">E-mail</label>
                                                    <div class="col-lg-7">
                                                        <label class="form-control"><?php echo $email; ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Estado Civil</label>
                                                    <div class="col-lg-7">
                                                        <label class="form-control"><?php echo $estado_civil; ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Fecha Nacimiento</label>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $fecha_nacimiento; ?></label>
                                                    </div>
                                                    <label class="col-lg-3 control-label">Tipo Sangre</label>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $sangre; ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Telefono</label>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $telefono; ?></label>
                                                    </div>
                                                    <label class="col-lg-3 control-label">Fecha Ingreso</label>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $fecha_ingreso; ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Categoria</label>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $categoria; ?></label>
                                                    </div>
                                                    <label class="col-lg-3 control-label">Cargo</label>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $cargo; ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Seguro de Pensiones</label>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $seguro_pension; ?></label>
                                                    </div>
                                                    <label class="col-lg-3 control-label">CUSPP</label>
                                                    <div class="col-lg-2">
                                                        <label class="form-control"><?php echo $cuspp; ?></label>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="panel">

                                <div class="panel-heading">
                                    <a href="familia_empleado.php?id=<?php echo $codigo; ?>"><h3 class="panel-title"><b>Datos Familiares</b></h3></a>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Item.</th>
                                                    <th>Apellidos y Nombres</th>
                                                    <th class="text-center">Edad</th>
                                                    <th class="text-center">Sexo</th>
                                                    <th class="text-center">Parentesco</th>
                                                    <th>Direccion</th>
                                                    <th class="text-center">Telefono</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
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
                                                        echo '<tr>
																<td class="text-center">' . $fila['dni'] . '</a></td>
																<td>' . $fila['nombre_completo'] . '</td>
																<td>' . $fila['edad'] . ' años</td>
																<td class="text-center">' . $sexo . '</td>
																<td class="text-center">' . strtoupper($fila['parentesco']) . '</td>
																<td>' . strtoupper($fila['direccion']) . '</td>
																<td class="text-center">' . $fila['telefono'] . '</td>
																</tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="panel">

                                <div class="panel-heading">
                                    <a href="familia_empleado.php?id=<?php echo $codigo; ?>"><h3 class="panel-title"><b>Contactos de Emergencia</b></h3></a>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Cod.</th>
                                                    <th>Apellidos y Nombres</th>
                                                    <th class="text-center">Sexo</th>
                                                    <th class="text-center">Parentesco / Relacion</th>
                                                    <th>Direccion</th>
                                                    <th class="text-center">Telefono</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //buscar datos_de emergencia de este empleado
                                                $familia = "select nombre_completo, direccion, telefono, sexo, parentesco from contacto_emergencia where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
                                                $resultado = $conn->query($familia);
                                                $fila_nro = 1;
                                                if ($resultado->num_rows > 0) {
                                                    while ($fila = $resultado->fetch_assoc()) {
                                                        if ($fila['sexo'] == "F") {
                                                            $sexo = "FEMENINO";
                                                        } else {
                                                            $sexo = "MASCULINO";
                                                        }
                                                        echo '<tr>
																<td class="text-center">' . $fila_nro . '</a></td>
																<td>' . $fila['nombre_completo'] . '</td>
																<td class="text-center">' . $sexo . '</td>
																<td class="text-center">' . strtoupper($fila['parentesco']) . '</td>
																<td>' . strtoupper($fila['direccion']) . '</td>
																<td class="text-center">' . $fila['telefono'] . '</td>
																</tr>';
                                                        $fila_nro ++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="panel">

                                <div class="panel-heading">
                                    <a href="academico_empleado.php?id=<?php echo $codigo; ?>"><h3 class="panel-title"><b>Experiencia Academica</b></h3></a>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Cod.</th>
                                                    <th>Institucion</th>
                                                    <th class="text-center">Tipo</th>
                                                    <th class="text-center">Grado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //buscar empleados en esta empresa
                                                $familia = "select id, institucion, tipo, grado from estudios where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
                                                $resultado = $conn->query($familia);
                                                if ($resultado->num_rows > 0) {
                                                    while ($fila = $resultado->fetch_assoc()) {
                                                        echo '<tr>
																<td class="text-center">' . $fila['id'] . '</a></td>
																<td>' . $fila['institucion'] . '</td>
																<td class="text-center">' . $fila['tipo'] . '</td>
																<td class="text-center">' . $fila['grado'] . '</td>
																</tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="panel">

                                <div class="panel-heading">
                                    <a href="academico_empleado.php?id=<?php echo $codigo; ?>"><h3 class="panel-title"><b>Cursos y Capacitaciones</b></h3></a>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Cod.</th>
                                                    <th>Institucion</th>
                                                    <th class="text-center">Descripcion</th>
                                                    <th class="text-center">Duracion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //buscar empleados en esta empresa
                                                $familia = "select id, institucion, descripcion, duracion, tipo_duracion from cursos where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
                                                $resultado = $conn->query($familia);
                                                if ($resultado->num_rows > 0) {
                                                    while ($fila = $resultado->fetch_assoc()) {
                                                        echo '<tr>
																<td class="text-center">' . $fila['id'] . '</a></td>
																<td>' . $fila['institucion'] . '</a></td>
																<td>' . $fila['descripcion'] . '</td>
																<td class="text-center">' . $fila['duracion'] . ' ' . $fila['tipo_duracion'] . '</td>
																</tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="panel">

                                <div class="panel-heading">
                                    <a href="laboral_empleado.php?id=<?php echo $codigo; ?>"><h3 class="panel-title"><b>Experiencia Laboral</b></h3></a>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Cod.</th>
                                                    <th>Empresa</th>
                                                    <th class="text-center">Cargo</th>
                                                    <th class="text-center">Duracion</th>
                                                    <th class="text-center">Motivo de Cese</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //buscar empleados en esta empresa
                                                $familia = "select id, empresa, cargo, fecha_inicio, fecha_fin, motivo_cese from experiencia_laboral where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
                                                $resultado = $conn->query($familia);
                                                if ($resultado->num_rows > 0) {
                                                    while ($fila = $resultado->fetch_assoc()) {
                                                        echo '<tr>
																<td class="text-center">' . $fila['id'] . '</a></td>
																<td>' . $fila['empresa'] . '</td>
																<td class="text-center">' . $fila['cargo'] . '</td>
																<td class="text-center">Desde: ' . $varios->fecha_tabla($fila['fecha_inicio']) . ' - al: ' . $varios->fecha_tabla($fila['fecha_fin']) . '</td>
																<td class="text-center">' . $fila['motivo_cese'] . '</td>
																</tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="panel">

                                <div class="panel-heading">
                                    <a href="laboral_empleado.php?id=<?php echo $codigo; ?>"><h3 class="panel-title"><b>Examen Medico</b></h3></a>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Cod.</th>
                                                    <th class="text-center">Evaluador</th>
                                                    <th class="text-center">Resultado</th>
                                                    <th class="text-center">Fec. Evaluacion</th>
                                                    <th class="text-center">Fec. Renovacion</th>
                                                    <th class="text-center">Estado</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ver_examenes = "select id, current_date() as fecha_actual, fecha_evaluacion, date_add(fecha_evaluacion, INTERVAL 2 YEAR) as fecha_renovacion, resultado, evaluador from examen_medico where empleado = '" . $codigo . "' and empresa = '" . $empresa . "' order by id asc";
                                                $resultado = $conn->query($ver_examenes);
                                                if ($resultado->num_rows > 0) {
                                                    while ($fila = $resultado->fetch_assoc()) {
                                                        $fecha_renovacion_larga = strtotime($varios->fecha_larga($fila['fecha_renovacion']));
                                                        $fecha_actual_larga = strtotime($varios->fecha_larga($fila['fecha_actual']));
                                                        if ($fecha_renovacion_larga > $fecha_actual_larga) {
                                                            $estado = '<span class="label label-success">VIGENTE</span>';
                                                        } else {
                                                            $estado = '<span class="label label-danger">POR RENOVAR</span>';
                                                        }
                                                        echo '<tr>
														<td>' . $fila['id'] . '</a></td>
														<td class="text-center">' . $fila['evaluador'] . '</td>
                                                        <td class="text-center">' . $fila['resultado'] . '</td>
														<td class="text-center">' . $varios->fecha_tabla($fila['fecha_evaluacion']) . '</td>
														<td class="text-center">' . $varios->fecha_tabla($fila['fecha_renovacion']) . '</td>
														<td class="text-center">' . $estado . '</td>
														</tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!--===================================================-->
                        <!--End page content-->


                    </div>
                    <!--===================================================-->
                    <!--END CONTENT CONTAINER-->



                    <!--MAIN NAVIGATION-->
                    <!--===================================================-->
                    <?php include ("includes/main_navigation.php"); ?>
                    <!--===================================================-->
                    <!--END MAIN NAVIGATION-->



                    <!-- TAB DE LA DERECHA -->
                    <!--ASIDE-->
                    <!--===================================================-->
                    <?php include ("includes/aside_rigth.php"); ?>
                    <!--===================================================-->
                    <!--END ASIDE-->
                </div>



                <!-- FOOTER -->
                <!--===================================================-->
                <?php include ("includes/footer.php"); ?>
                <!--===================================================-->
                <!-- END FOOTER -->


                <!-- SCROLL TOP BUTTON -->
                <!--===================================================-->
                <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
                <!--===================================================-->



            </div>
            <!--===================================================-->
            <!-- END OF CONTAINER -->


            <!--JAVASCRIPT-->
            <!--=================================================-->

            <!--jQuery [ REQUIRED ]-->
            <script src="js/jquery-2.1.1.min.js"></script>


            <!--BootstrapJS [ RECOMMENDED ]-->
            <script src="js/bootstrap.min.js"></script>


            <!--Fast Click [ OPTIONAL ]-->
            <script src="plugins/fast-click/fastclick.min.js"></script>


            <!--Nifty Admin [ RECOMMENDED ]-->
            <script src="js/nifty.min.js"></script>


            <!--Switchery [ OPTIONAL ]-->
            <script src="plugins/switchery/switchery.min.js"></script>


            <!--Bootstrap Select [ OPTIONAL ]-->
            <script src="plugins/bootstrap-select/bootstrap-select.min.js"></script>


            <!--DataTables [ OPTIONAL ]-->
            <script src="plugins/datatables/media/js/jquery.dataTables.js"></script>
            <script src="plugins/datatables/media/js/dataTables.bootstrap.js"></script>
            <script src="plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>


            <!--Demo script [ DEMONSTRATION ]-->
            <script src="js/demo/nifty-demo.min.js"></script>


            <!--DataTables Sample [ SAMPLE ]-->
            <script src="js/demo/tables-datatables.js"></script>

            <script type="text/javascript">
                                                function edita_empleado(empleado, empresa) {
                                                    document.location.href = "modificar_empleado.php?empleado=" + empleado + "&empresa=" + empresa;
                                                }

                                                function agregar_documento() {
                                                    $('#modal_archivo').modal('show');
                                                }
            </script>


            <!--
                    
                    REQUIRED
                    You must include this in your project.
                    
                    RECOMMENDED
                    This category must be included but you may modify which plugins or components which should be included in your project.
                    
                    OPTIONAL
                    Optional plugins. You may choose whether to include it in your project or not.
                    
                    DEMONSTRATION
                    This is to be removed, used for demonstration purposes only. This category must not be included in your project.
                    
                    SAMPLE
                    Some script samples which explain how to initialize plugins or components. This category should not be included in your project.
                    
                    
                    Detailed information and more samples can be found in the document.
                    
            -->


    </body>

    <!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:57 GMT -->
</html>

