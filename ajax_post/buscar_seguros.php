<?php
session_start();

include '../includes/conectar.php';
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));
global $conn;
$query = "select * "
        . "from seguro_pension "
        . "where (nombre like '%" . $searchTerm . "%' ) ";
$resultado = $conn->query($query);
$a_cliente = $resultado->fetch_all(MYSQLI_ASSOC);
$array_cliente = array();
$fila_cliente = array();
foreach ($a_cliente as $value) {
    $fila_cliente['value'] = $value['nombre'] ;
    $fila_cliente['id'] = $value['id'];
    $fila_cliente['nombre'] = $value['nombre'];
    array_push($array_cliente, $fila_cliente);
}
echo json_encode($array_cliente);
