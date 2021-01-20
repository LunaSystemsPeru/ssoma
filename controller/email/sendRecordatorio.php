<?php
require 'SendEmail.php';

$email = new SendEmail();

$email->enviarRecordatoriosCobros();
$email->enviarRecordatoriosPagos();





