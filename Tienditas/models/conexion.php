<?php
//creamos nuestra conexion hacia la base de datos donde almacenaremos nuestros datos
class Conexion{

	public function conectar()
  {
		$link = new PDO("mysql:host=localhost;dbname=inventario2","root","");
		return $link;
	}
}
?>