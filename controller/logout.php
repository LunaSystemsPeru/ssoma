<?php
require_once '../models/Conectar.php';
require '../tools/Zebra_Session.php';

$conectar = Conectar::getInstancia();

$link = $conectar->getLink();
/*
if (isset($_SESSION)) {
    session_destroy();
}-*/
$zebra = new Zebra_Session($link, 'sEcUr1tY_c0dE');

$zebra->stop();
header("Location: ../contents/login.php");
