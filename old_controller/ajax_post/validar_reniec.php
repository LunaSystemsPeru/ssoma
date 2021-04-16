<?php

$documento = filter_input(INPUT_POST, 'documento');

if (strlen($documento) == 8) {


    $data = array("dni" => $documento);
    $ch = curl_init("http://chimbote.store/apis/peru-consult/public/consultaDNI.php?dni=" . $documento);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
        curl_close($ch);



    if (!$response) {
        return false;
    } else {
        $json = json_decode($response, true);
        if ($json != null) {
            $fila_cliente['documento'] = $json['dni'];
            $fila_cliente['nombre'] = $json['apellidoPaterno'] . ' ' . $json['apellidoMaterno'] . ' ' . $json['nombres'];
            $rpt = (object)array(
                "success" => "reniec",
                "entity" => $fila_cliente
            );
        } else {
            $rpt = (object)array(
                "success" => false,
                "entity" => ""
            );
        }
        echo json_encode($rpt);
    }
}