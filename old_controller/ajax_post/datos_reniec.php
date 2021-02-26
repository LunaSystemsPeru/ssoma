<?php
$url = 'http://wsvmin.minsa.gob.pe/wsreniecmq/serviciomq.asmx?WSDL';
/*
$parametros=array('app' => "HCALETA",
    'usuario' => '32854234',
    'clave'=>'H0$CA%L@ctA');
*/

$generales = array(
    'trace' => 1,
    'exceptions' => 0,
    'keep_alive' => true
);

$params = new StdClass();
$params->nrodoc = filter_input(INPUT_GET, 'dni');

$dato = array("ns1:nrodoc" => $params);

$soapClient = new SoapClient($url, $generales);
$auth = new SoapVar(array('ns1:app' => 'HCALETA', 'ns1:usuario' => '32854234', 'ns1:clave' => 'H0$CA%L@ctA'), SOAP_ENC_OBJECT);
$header = new SoapHeader('http://tempuri.org/', 'Credencialmq', $auth);

$soapClient->__setSoapHeaders($header);

$result = $soapClient->obtenerDatosCompletos($params);


/*
echo "====== REQUEST HEADERS =====" . PHP_EOL;
echo "<br>";
echo "<pre>" ;
var_dump($soapClient->__getLastRequestHeaders());
echo "</pre>";
echo "<br>";

echo "========= REQUEST ==========" . PHP_EOL;
echo "<br>";
//echo "<pre>" ;
//var_dump($soapClient->__getLastRequest());
echo htmlentities($soapClient->__getLastRequest()) ;
//echo "</pre>";
echo "<br>";
*/

$resultado = get_object_vars($result);

$valores = get_object_vars($resultado["obtenerDatosCompletosResult"]);

$valores =  json_decode(json_encode($valores), true);

$item = $valores["string"];

echo json_encode($item);
?>



