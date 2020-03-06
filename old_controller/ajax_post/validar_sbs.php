<?php

$documento = filter_input(INPUT_POST, 'documento');

if (strlen($documento) == 8) {
    $data = array("dni" => $documento);
    $ch = curl_init("http://lunasystemsperu.com/consultas_json/sbs/ejemplo.php");
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
        if ($json_success == true) {
            $json_entity = $json['result'];

            $fila_cliente['CUSPP'] = $json_entity['CUSPP'];
            $fila_cliente['FechaSPP'] = $json_entity['FechaSPP'];
            $fila_cliente['NombAFP'] = $json_entity['NombAFP'];
            $fila_cliente['Situacion'] = $json_entity['Situacion'];
            $fila_cliente['TipoComision'] = $json_entity['TipoComision'];
            $rpt = (object) array(
                        "success" => "sbs",
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