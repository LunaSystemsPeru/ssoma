<?php

$servidor = "192.168.1.248";
$bd = "ssoma_db";
$usu = "root_lsp";
$pass = "root/*123";
$puerto = "3306";
$conn = new mysqli($servidor, $usu, $pass, $bd, $puerto);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}