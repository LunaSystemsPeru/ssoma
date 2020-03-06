<?php
session_start();

include '../class/cl_empleado.php';
$c_cliente = new cl_cliente();

$documento = filter_input(INPUT_POST, 'documento');

//validar si existe cliente
$c_cliente->setDocumento($documento);
$c_cliente->setId_tienda($_SESSION['id_empresa']);
$existe_cliente = $c_cliente->datos_cliente_documento();

if ($existe_cliente) {
    $c_cliente->validar_cliente();
    $fila_cliente['id_cliente'] = $c_cliente->getId();
    $fila_cliente['documento'] = $c_cliente->getDocumento();
    $fila_cliente['nombre'] = $c_cliente->getCliente();
    $fila_cliente['direccion'] = $c_cliente->getDireccion();
    $rpt = (object) array(
                "success" => "existe",
                "entity" => $fila_cliente
    );
    echo json_encode($rpt);
} else {

    if (strlen($documento) == 8) {
        $data = array("dni" => $documento);
        $ch = curl_init("http://localhost/consultas_json/datos_peru_dni/consultas_dni.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);
        if (!$response) {
            return false;
        } else {
            $json = json_decode($response, true);
            $json_entity = $json['result'];

            $fila_cliente['documento'] = $json_entity['DNI'];
            $fila_cliente['nombre'] = $json_entity['ApellidoPaterno'] . ' ' . $json_entity['ApellidoMaterno'] . ' ' . $json_entity['Nombres'];
            $fila_cliente['direccion'] = "";
            $rpt = (object) array(
                        "success" => "reniec",
                        "entity" => $fila_cliente
            );
            echo json_encode($rpt);
        }
    }

    if (strlen($documento) == 8) {
        $data = array("dni" => $documento);
        $ch = curl_init("http://localhost/consultas_json/AFP/ejemplo.php?");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);
        if (!$response) {
            return false;
        } else {
            $json = json_decode($response, true);
            $json_entity = $json['entity'];

            $fila_cliente['documento'] = $json_entity['ruc'];
            $fila_cliente['nombre'] = $json_entity['nombre_o_razon_social'];
            $fila_cliente['direccion'] = $json_entity['direccion_completa'];
            $fila_cliente['estado'] = $json_entity['estado_del_contribuyente'];
            $fila_cliente['condicion'] = $json_entity['condicion_de_domicilio'];
            $rpt = (object) array(
                        "success" => "sunat",
                        "entity" => $fila_cliente
            );
            echo json_encode($rpt);
        }
    }
}    