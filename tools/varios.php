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

}

?>
