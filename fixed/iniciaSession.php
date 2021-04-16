<?php
require '../tools/Zebra_Session.php';
require_once '../models/Conectar.php';
$conectar = Conectar::getInstancia();
$link = $conectar->getLink();
try {
    $zebra = new Zebra_Session($link, 'sEcUr1tY_c0dE');
    /*
    print_r($zebra->get_settings());
    echo "<br>";
    echo time();
    echo "<br>";
    echo ini_get('session.gc_maxlifetime');
    echo "<br>";
    print_r($_SESSION);
    echo "<br>";
    echo "sesiones activas " . $zebra->get_active_sessions();
    */
    if (!isset($_SESSION["usuario"])) {
        $zebra->stop();
        header("location:login.php");
    }

} catch (Exception $e) {
    echo $e;
}