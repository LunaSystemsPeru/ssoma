<?php

$documento = filter_input(INPUT_POST, 'documento');

if (strlen($documento) == 8) {
    $data = array("documento" => $documento);
    $ch = curl_init("http://lunasystemsperu.com/consultas_json/cedula/index.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);
    if (!$response) {
        return false;
    } else {
        $json = json_decode($response, true);
        $json_success = $json['status'];
        $json_entity = $json['response'];
        if ($json_success == 200) {
                    $fila_cliente['documento'] = $json_entity['cedula'];
                    $fila_cliente['nombre'] = $json_entity['apellidos'] . ' ' . $json_entity['nombres'];
                    $rpt = (object) array(
                                "success" => "venezuela",
                                "entity" => $fila_cliente
                    );
        } else {
            $rpt = (object) array(
                        "success" => false,
                        "entity" => ""
            );
        }
        echo json_encode($rpt);
    }
}