<?php 

class Paginas{
public function enlacesPaginasModel($enlaces){
	//creamos nuestro enlace para cada una de nuestras paginas en el colocamos hacia donde se dirigira y encasa de un cambio tambien
	//todo comienza con una condicion if y despues con else if dependiendo de nuestras paginas, asi como tambien se deben de registrar
	//si tenemos paginas donde se realizan cambios
	if($enlaces == "login" ||	$enlaces=="AgregarCliente" || $enlaces=="AgregarEmpleado" || $enlaces == "AgregarReparacion" || $enlaces == "AgregarTienda" || 
	   $enlaces == "Caja"  || $enlaces=="Categorias" || $enlaces == "Clientes"	 || $enlaces == "Empleados" || 
	   $enlaces=="EditarPerfil" || $enlaces=="EditarTienda" || $enlaces == "inicio" || $enlaces=="Ingreso" ||
	   $enlaces == "Mantenimiento" || $enlaces == "PerfilTienda" || $enlaces == "Producto" || $enlaces == "Perfil" || $enlaces == "salir" ||
	   $enlaces == "Proveedores" || $enlaces == "RealizarVenta" || $enlaces == "Reparacion" || $enlaces == "SubCategoria" || $enlaces == "Tiendas" ||
	   $enlaces == "TipoDocumento" || $enlaces == "UnidadesMedida" || $enlaces == "Ventas" || $enlaces == "VerMantenimiento" || $enlaces == "VistaIngreso" || 
	   $enlaces == "PagoCaja" || $enlaces == "Marca"){

		$module =  "../views/modules/".$enlaces.".php";
	
	}
	//Para vizualizar nuestro inicio


	else if($enlaces == "ACliente"){
		$module = "views/modules/AgregarCliente.php";
	}
	else if($enlaces == "AEmpleado"){
		$module = "views/modules/AgregarEmpleado.php";
	}
	else if($enlaces == "AReparacion"){
		$module = "views/modules/AgregarReparacion.php";

	}
	else if($enlaces == "ATienda"){
		$module = "views/modules/AgregarTienda.php";
	}


	else if($enlaces == "fallo"){

		$module =  "views/modules/login.php";
	
	}	
	else if($enlaces == "Caja"){

		$module =  "views/modules/Caja.php";
	
	}

	else if($enlaces == "Categorias"){

		$module =  "views/modules/Categorias.php";
	
	}
	else if($enlaces == "Clientes"){

		$module = "views/modules/Clientes.php";

	}
	else if($enlaces == "Empleados"){

		$module = "views/modules/Empleados.php";

	}

	else if($enlaces == "EPerfil"){
		$module ="views/modules/EditarPerfil.php";
	}

	else if($enlaces == "ETienda"){
		$module = "views/modules/EditarPerfil.php";
	}

	else if($enlaces == "Ingreso"){
		$module = "views/modules/Ingreso.php";
	}

	else if($enlaces == "Mantenimiento"){
		$module = "views/modules/Mantenimiento.php";
	}

	else if($enlaces == "PTienda"){
		$module = "views/modules/PerfilTienda.php";
	}

	else if($enlaces == "Producto"){
		$module = "views/modules/Producto.php";
	}

	else if($enlaces == "Perfil"){
		$module = "views/modules/Perfil.php";
	}

	else if($enlaces == "Proveedores"){
		$module = "views/modules/Proveedores.php";
	}

	else if($enlaces == "RVenta"){
		$module = "views/modules/RealizarVenta.php";
	}

	else if($enlaces == "Reparacion"){
		$module = "views/modules/Reparacion.php";
	}

	else if($enlaces == "SubCategoria"){
		$module = "views/modules/SubCategorias.php";
	}

	else if($enlaces == "Tiendas"){
		$module = "views/modules/Tiendas.php";
	}

	else if($enlaces == "TDocumento"){
		$module = "views/modules/TipoDocumento.php";
	}

	else if($enlaces == "UnidadesMedida"){
		$module = "views/modules/UnidadesMedida.php";
	}

	else if($enlaces == "Ventas"){
		$module = "views/modules/Ventas.php";
	}

	else if($enlaces == "VMantenimiento"){
		$module = "views/modules/VerMantenimiento.php";
	}

	else if($enlaces == "VIngreso"){
		$module = "views/modules/VistaIngreso.php";
	}

	else if($enlaces == "PagoCaja"){
		$module = "views/modules/PagoCaja.php";
	}

	else if($enlaces == "Marca"){
		$module = "views/modules/Marca.php";
	}

	else{

		$module =  "../views/modules/login.php";

	}
	
	return $module;

}

}

?>