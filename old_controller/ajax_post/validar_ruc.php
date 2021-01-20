<?php

$documento = filter_input(INPUT_POST, 'documento');

if (strlen($documento) == 11) {
    $data = array("ruc" => $documento);
    $ch = curl_init("http://www.lunasystemsperu.com/consultas_json/composer/consulta_sunat_JMP.php?ruc=" . $documento);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);
    if (!$response) {
        return false;
    } else {
        $json = json_decode($response, true);
        $json_success = $json['success'];
        $json_entity = $json['result'];
        if ($json_success == 'true') {
            if (trim($json_entity['RazonSocial']) != "") {
                $fila_cliente['ruc'] = $json_entity['RUC'];
                $fila_cliente['RazonSocial'] = $json_entity['RazonSocial'];
                $fila_cliente['NombreComercial'] = $json_entity['NombreComercial'];
                $fila_cliente['Direccion'] = $json_entity['Direccion'];
                $rpt = (object)array(
                    "success" => "sunat",
                    "entity" => $fila_cliente
                );
            } else {
                $rpt = (object)array(
                    "success" => false,
                    "entity" => ""
                );
            }
        } else {
            $rpt = (object)array(
                "success" => false,
                "entity" => ""
            );
        }
        echo json_encode($rpt);
    }
}