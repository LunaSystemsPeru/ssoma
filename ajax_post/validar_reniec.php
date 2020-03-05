<?php

$documento = filter_input(INPUT_POST, 'documento');

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
        $json_success = $json['success'];
        $json_source = $json['source'];
        $json_entity = $json['result'];
        if ($json_success == 'true') {
            if (trim($json_entity['Nombres']) != "") {
                if ($json_source == 'padron_jne') {
                    $fila_cliente['documento'] = $json_entity['DNI'];
                    $fila_cliente['nombre'] = $json_entity['apellidos'] . ' ' . $json_entity['Nombres'];
                    $rpt = (object) array(
                                "success" => "reniec",
                                "entity" => $fila_cliente
                    );
                }

                if ($json_source == 'essalud') {
                    $fila_cliente['documento'] = $json_entity['DNI'];
                    $fila_cliente['nombre'] = $json_entity['ApellidoPaterno'] . ' ' . $json_entity['ApellidoMaterno'] . ' ' . $json_entity['Nombres'];
                    $rpt = (object) array(
                                "success" => "reniec",
                                "entity" => $fila_cliente
                    );
                }

                if ($json_source == 'reniec') {

                    $fila_cliente['documento'] = $json_entity['DNI'];
                    $fila_cliente['nombre'] = $json_entity['apellidos'] . ' ' . $json_entity['Nombres'];
                    $rpt = (object) array(
                                "success" => "reniec",
                                "entity" => $fila_cliente
                    );
                }
            } else {
                $rpt = (object) array(
                            "success" => false,
                            "entity" => ""
                );
            }
        } else {
            $rpt = (object) array(
                        "success" => false,
                        "entity" => ""
            );
        }
        echo json_encode($rpt);
    }
}