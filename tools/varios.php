<?php

Class Varios {

    public function __construct() {
        //vacio
    }

    function nombremes($mes) {
        setlocale(LC_TIME, 'spanish');
        $nombre = strftime("%B", mktime(0, 0, 0, $mes, 1, 2000));
        return $nombre;
    }

    function fecha_actual_completa() {
        $fecha_actual = strtotime(date("Y-m-d H:i:s", time()));
        return $fecha_actual;
    }

    function fecha_actual_corta() {
        $fecha_actual = strtotime(date("Y-m-d", time()));
        return $fecha_actual;
    }

    function fecha_tabla($date) {
        $to_format = 'd/m/Y';
        $from_format = 'Y-m-d';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function fecha_mysql($date) {
        $to_format = 'Y-m-d';
        $from_format = 'd/m/Y';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function fecha_tabla_hora($date) {
        $to_format = 'd/m/Y';
        $from_format = 'Y-m-d H:i:s';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function fecha_larga($date) {
        $to_format = 'Y-m-d H:i:s';
        $from_format = 'Y-m-d';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function fecha_hora_tabla($date) {
        $to_format = 'd/m/Y H:i';
        $from_format = 'Y-m-d H:i:s';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function fecha_hora_mysql($date) {
        $from_format = 'd/m/Y H:i';
        $to_format = 'Y-m-d H:i:s';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function fecha_hora_segundos_mysql($date) {
        $from_format = 'd/m/Y H:i:s';
        $to_format = 'Y-m-d H:i:s';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function fecha_hora_segundos_tabla($date) {
        $to_format = 'd/m/Y H:i:s';
        $from_format = 'Y-m-d H:i:s';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function fecha_periodo ($date) {
        $to_format = 'Ym';
        $from_format = 'Y-m-d';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    function zerofill($valor, $longitud) {
        $res = str_pad($valor, $longitud, '0', STR_PAD_LEFT);
        return $res;
    }

    function generarCodigo($longitud) {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++) {
            $key .= $pattern{mt_rand(0, $max)};
        }
        return $key;
    }

    function dias_restantes($fecha_final) {
        $fecha_actual = date("Y-m-d");
        $s = strtotime($fecha_final)-strtotime($fecha_actual);
        $d = intval($s/86400);
        $diferencia = $d;
        return $diferencia;
    }

    function compressImage($source, $destination, $quality) {
        // Obtenemos la información de la imagen
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];

        // Creamos una imagen
        switch($mime){
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                $image = imagecreatefromjpeg($source);
        }

        // Guardamos la imagen
        imagejpeg($image, $destination, $quality);

        // Devolvemos la imagen comprimida
        return $destination;
    }
}

?>
