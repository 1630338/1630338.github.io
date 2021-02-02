<?php

require_once "../controllers/controller.php";
require_once "../models/crud.php";

class AjaxPrueba{

	/*=============================================
	
	=============================================*/	

	
    public $tienda;
    public $logo;
    public $nombre_empresa;
    public $correo;
    public $telefono;
    public $telefono_op;
    public $pagina;
    public $facebook;
    public $twitter;

    public $tienda_asig;
    public $depto;
    public $telefono_laboral;
    public $correo_laboral;

    public $rfc;
    public $razonSE;
    public $regimen_cap;
    public $dom_calle;
    public $dom_numero_exterior;
    public $dom_numero_interior;
    public $codigo_postal;
    public $colonia;
    public $localidad;
    public $municipio;
    public $estado;

    public $total;

	public function ajaxPrueba(){

        $datos = array(
            "tienda" => $this->tienda,
            "logo" => $this->logo,
            "nombre_empresa" => $this->nombre_empresa,
            "correo" => $this->correo,
            "telefono" => $this->telefono,
            "telefono_op" => $this->telefono_op,
            "pagina" => $this->pagina,
            "facebook" => $this->facebook,
            "twitter" => $this->twitter,

            "tienda_asig" => $this->tienda_asig,
            "depto" => $this->depto,
            "telefono_laboral" => $this->telefono_laboral,
            "correo_laboral" => $this->correo_laboral,

            "rfc" => $this->rfc,
            "razonSE" => $this->razonSE,
            "regimen_cap" => $this->regimen_cap,
            "dom_calle" => $this->dom_calle,
            "dom_numero_exterior" => $this->dom_numero_exterior,
            "dom_numero_interior" => $this->dom_numero_interior,
            "codigo_postal" => $this->codigo_postal,
            "colonia" => $this->colonia,
            "localidad" => $this->localidad,
            "municipio" => $this->municipio,
            "estado" => $this->estado,

            "total" => $this->total
         );



		$respuesta = MvcController::prueba($datos);

		echo json_encode($respuesta);

	}
}

/*=============================================

=============================================*/	
if(isset($_POST["estado"])){

	$prueba = new AjaxPrueba();
    $prueba -> tienda = $_POST["tienda"];
    $prueba -> logo = $_POST["logo"];
    $prueba -> nombre_empresa = $_POST["nombre_empresa"];
    $prueba -> correo = $_POST["correo"];
    $prueba -> telefono = $_POST["telefono"];
    $prueba -> telefono_op = $_POST["telefono_op"];
    $prueba -> pagina = $_POST["pagina"];
    $prueba -> facebook = $_POST["facebook"];
    $prueba -> twitter = $_POST["twitter"];

    $prueba -> tienda_asig = $_POST["tienda_asig"];
    $prueba -> depto = $_POST["depto"];
    $prueba -> telefono_laboral = $_POST["telefono_laboral"];
    $prueba -> correo_laboral = $_POST["correo_laboral"];

    $prueba -> rfc = $_POST["rfc"];
    $prueba -> razonSE = $_POST["razonSE"];
    $prueba -> regimen_cap = $_POST["regimen_cap"];
    $prueba -> dom_calle = $_POST["dom_calle"];
    $prueba -> dom_numero_exterior = $_POST["dom_numero_exterior"];
    $prueba -> dom_numero_interior = $_POST["dom_numero_interior"];
    $prueba -> codigo_postal = $_POST["codigo_postal"];
    $prueba -> colonia = $_POST["colonia"];
    $prueba -> localidad = $_POST["localidad"];
    $prueba -> municipio = $_POST["municipio"];
    $prueba -> estado = $_POST["estado"];

    $prueba -> total = $_POST["total"];


	$prueba -> ajaxPrueba();
}