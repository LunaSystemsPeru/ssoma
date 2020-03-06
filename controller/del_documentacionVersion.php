<?php

   require '../models/DocumentacionVersion.php';
  $documentacionVersion=new DocumentacionVersion();



$documentacionVersion->setIdVersion(filter_input(INPUT_GET, 'input_idVersion'));



 $documentacionVersion->eliminar();
