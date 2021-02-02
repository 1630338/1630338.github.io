<?php

//mandamos llamar a nuestros controladores, modelos
require_once "models/enlaces.php";
require_once "models/crud.php";
require_once "controllers/controller.php";



$mvc = new MvcController();
$mvc -> pagina();



?>