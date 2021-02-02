<?php
class MvcController{
    #LLAMADA A LA PLANTILLA para visualizarlo
	#-------------------------------------
	public function pagina(){	
		
		include "views/modules/login.php";
	
	}

	#ENLACES de donde estaran mis direccionamientos
	#-------------------------------------
	public function enlacesPaginasController(){

		if(isset( $_GET['action'])){
			
			$enlaces = $_GET['action'];
		
		}

		else{

			$enlaces = "template";
		}

		$respuesta = Paginas::enlacesPaginasModel($enlaces);

		include $respuesta;

	}


    #---------------------------------------------------------------------------------------------------
	#REGISTRO DE USUARIOS EN LA BASE DE DATOS
	#---------------------------------------------------------------------------------------------------
	public function registroUsuarioController(){
		##En la condición pongo el dato en el isset para comprohar si la varaiable esta definida  tomare como referencia que este pero antes colocarle un $_POST de que si hubo un envio nombre que coloque en mi input
		#si es valida ya pondre los demas datos de mis campos en un array para que se vayan guradando para ello utilizare $_POST y el nombre que tenfo definido en mis inout para poder hacer que traiga los valores
		if(isset($_POST["nombreRegistro"])){

			$datosController = array( 
                
                "nombre"=>$_POST["nombreRegistro"],
                
				"usuario"=>$_POST["usuarioRegistro"],								

				"password"=>$_POST["passwordRegistro"],

				"email"=>$_POST["emailRegistro"]);
				
			#LLamo a la funcion de mi crud, especificando los datos del controller y la tabla de mi base datos en este caso es la de usuarios.
			$respuesta = Datos::registroUsuarioModel($datosController, "usuarios");
			#Se pondra una funcion para que responda con un mensaje de si se ha logrado el registro que pondre el nombre de mi variable que es repuesta 
			#en la cual ya tnego definida en otra funcion para poder llamar los enlaces de mi modelo
			if($respuesta == "success"){
				echo 'Registro exitoso';

			}
		}
	}

	#-----------------------------------------------
	#INGRESO DE USUARIOS A LA PAGINA EN LA CUAL SE ESPECIFICA CON UNA FUNCION QUE TIENE UNA VARIABLE LLAMADA RESPUESTA EN LA CUAL ESPEFICIFO SI EXISTEN LOS DATOS EN LA BASE DE DATOS
	#------------------------------------
	public function ingresoUsuarioController(){
		##En la condición pongo el dato en el isset para comprohar si la varaiable esta definida  tomare como referencia que este pero antes colocarle un $_POST de que si hubo un envio de usuario que coloque en mi input
		#si es valida ya pondre los demas datos de mis campos en un array para que se vayan guradando para ello utilizare $_POST y el nombre que tenfo definido en mis inout para poder hacer que traiga los valores
		if(isset($_POST["usuarioIngreso"])){

			$datosController = array( "usuario"=>$_POST["usuarioIngreso"], 
								      "password"=>$_POST["passwordIngreso"]);

			$respuesta = Datos::ingresoUsuarioModel($datosController, "usuarios");

			if($respuesta["usuario"] == $_POST["usuarioIngreso"] && $respuesta["password"] == $_POST["passwordIngreso"]){

				session_start();
				

				$_SESSION["total_tienda"] = $respuesta["total_tienda"];
				$_SESSION["validar"] = true;
				$_SESSION['nombre'] = $respuesta["nombre"];

				header("location:views/template.php?action=inicio");
				//ob_end_flush();
			}
			
			else{

				header("location:views/template.php?action=fallo");

			}
		}		
	}

	#----------------------------------------------
	#VISTA DE USUARIOS
	#------------------------------------
	public function vistaUsuariosController(){

		$respuesta = Datos::vistaUsuariosModel("usuarios");
	
		foreach($respuesta as $row => $item){
		echo'<tr>				
				<td>'.$item['n_u'].'</td>					
                <td>'.$item["nombre"].'</td>
                <td>'.$item["usuario"].'</td>
				<td>'.$item["password"].'</td>
				<td>'.$item["email"].'</td>
				<td><a href="template.php?action=editar&n_u='.$item["n_u"].'"><button class="btn btn-block btn-primary" ><i class="fas fa-user-edit">Editar</i></button></a></td>
				<td><a href="template.php?action=usuarios&n_uBorrar='.$item["n_u"].'"><button class="btn btn-block btn-danger"> <i class="fas fa-user-times">Borrar</i></button></a></td>
			</tr>';

		}
	}

	#EDITAR USUARIO
	#------------------------------------
	public function editarUsuarioController(){

		$datosController = $_GET["n_u"];
		$respuesta = Datos::editarUsuarioModel($datosController, "usuarios");

		echo'
		<div class="form-group">
			<label>N_U: </label> 
			<div class="col-sm-4">
				<input type="number" value="'.$respuesta["n_u"].'" name="n_uEditar">			
			</div>
		</div>

		<div class="form-group">
			 <label> Nombre: </label>
			<div class="col-sm-4">
			 	<input type="text" value="'.$respuesta["nombre"].'" name="nombreEditar" required>		
			</div>
		</div>
		
		<div class="form-group">
			 <label> Usuario: </label>
			 <div class="col-sm-4">
				 <input type="password" value="'.$respuesta["usuario"].'" name="usuarioEditar" required>
			</div>
		</div>

		<div class="form-group">
			 <label> Password: </label>
			 <div class="col-sm-4">
				 <input type="text" value="'.$respuesta["password"].'" name="passwordEditar" required>
			</div>
		</div>

		<div class="form-group">
			 <label> Email: </label>
			 <div class="col-sm-4">
				 <input type="email" value="'.$respuesta["email"].'" name="emailEditar" required>
			</div>
		</div>

		<div class="form-group">			
			 <input type="submit" class="btn btn-block btn-success" value="Actualizar">
		</div>';

	}

	#ACTUALIZAR USUARIO
	#------------------------------------
	public function actualizarUsuarioController(){

		if(isset($_POST["usuarioEditar"])){

			$datosController = array( 
			"n_u"=>$_POST["n_uEditar"],

            "nombre"=>$_POST["nombreEditar"],

			"usuario"=>$_POST["usuarioEditar"],						

			"password"=>$_POST["passwordEditar"],

			"email"=>$_POST["emailEditar"]);

			
			$respuesta = Datos::actualizarUsuarioModel($datosController, "usuarios");

			if($respuesta == "success"){
				header("location:template.php?action=usuarios");
				ob_end_flush();

			}

			else{

				echo "error";

			}

		}
	
	}

	#BORRAR USUARIO
	#------------------------------------
	public function borrarUsuarioController(){

		if(isset($_GET["n_uBorrar"])){

			$datosController = $_GET["n_uBorrar"];
			
			$respuesta = Datos::borrarUsuarioModel($datosController, "usuarios");

			if($respuesta == "success"){

				header("location:template.php?action=usuarios");
				ob_end_flush();		
			}
			else{
				echo "error";
			}
		}
	}

#---------Categoria----------------------------------

 //Controlador de Registrar categoria
	public function registroCategoriaController(){
		if(isset($_POST["NombreCategoria"])){

			$datosController = array( 
                
                "nombre"=>$_POST["NombreCategoria"],
                
				"descripcion"=>$_POST["DescripcionCategoria"]);
						
			$respuesta = Datos::registroCategoriaModel($datosController, "Categorias");

			if($respuesta == "success"){
				echo 'Registro exitoso';

			}
		}	
	}

	#VISTA DE  Categorias
	#------------------------------------
	public function vistaCategoriasController(){

		$respuesta = Datos::vistaCategoriasModel("Categorias");
	
		foreach($respuesta as $row => $item){
		echo'<tr>				
				<td>'.$item['id_categoria'].'</td>					
                <td>'.$item["nombre"].'</td>
                <td>'.$item["descripcion"].'</td>
				<td>'.$item["date"].'</td>
				<td>
				<a href="template.php?action=EditarCategoria&id_categoria='.$item["id_categoria"].'"><button type="button" class="btn btn-success btn-sm" title="Editar" data-toggle="modal" data-target="#MCategoriaEditar"><i class="fa fa-edit"></i></button></a>
				<a href="template.php?action=categorias&id_categoriaBorrar='.$item["id_categoria"].'"><button class="btn btn-danger btn-sm"> <i class="fa fa-unlock-alt"></i></button></a>
				</td>				
			</tr>';
		}
	}

	#EDITAR CATEGORIA
	#------------------------------------
	public function editarCategoriasController(){

		$datosController = $_GET["id_categoria"];
		$respuesta = Datos::editarCategoriasModel($datosController, "Categorias");

		echo'
			<div class="form-group row">
				<label class="col-from-label col-md-3 col-sm-3 label-align">id_categoria: </label> 
				<div class="col-md-6 col-sm-6">
					<input type="number" class="form-control" value="'.$respuesta["id_categoria"].'" disabled>
				</div>
			</div>

			<div class="form-group row">
			 	<label class="col-from-label col-md-3 col-sm-3 label-align">Nombre: </label>
			 	<div class="col-md-6 col-sm-6">
					 <input type="text" class="form-control" value="'.$respuesta["nombre"].'" >
				</div>
			</div>
             
			<div class="form-group row>
				<label class="col-from-label col-md-3 col-sm-3 label-align">Descripcion: </label>
				<div class="col-md-6 col-sm-6">
					<textarea rows="3" class="form-control" value="'.$respuesta["descripcion"].'" name="descripcionEditar"></textarea>
				</div>
			</div>

			<div class="form-group row">			 				 
					<input type="submit" class="btn btn-block btn-success" value="Actualizar">					
			</div>';				

	}

	#ACTUALIZAR CATEGORIA
	#------------------------------------
	public function actualizarCategoriasController(){

		if(isset($_POST["nombreEditar"])){

			$datosController = array( 
			"id_categoria"=>$_POST["id_categoriaEditar"],

            "nombre"=>$_POST["nombreEditar"],

			"descripcion"=>$_POST["descripcionEditar"]);

			
			$respuesta = Datos::actualizarCategoriasModel($datosController, "Categorias");

			if($respuesta == "success"){

				header("location:template.php?action=Categorias");
				ob_end_flush();

			}

			else{

				echo "error";

			}

		}
	
	}

	#BORRAR CATEGORIA
	#------------------------------------
	public function borrarCategoriasController(){

		if(isset($_GET["id_categoriaBorrar"])){

			$datosController = $_GET["id_categoriaBorrar"];
			
			$respuesta = Datos::borrarCategoriasModel($datosController, "Categorias");

			if($respuesta == "success"){

				header("location:template.php?action=categorias");
				ob_end_flush();		
			}
		}
	}

#-----------------------------SubCategoria--------------------------------------------------
//Controlador registro SubCategoria
public function registroSubCategoriaController(){
	if(isset($_POST["nombresubcategoria"])){

		$datosController = array(			
			"nombre"=>$_POST["nombresubcategoria"],			
			"descripcion"=>$_POST["descripcion"],
			"categoria"=>$_POST["categoria"]);
		
		$respuesta = Datos::registroSubCategoriaModel($datosController, "SubCategoria");

		if($respuesta == "success"){
			echo 'Registro exitoso';
		}
	}
}

//Controlador vista SubCategoria
public function vistaSubCategoriaController(){

	$respuesta = Datos::vistaSubCategoriaModel("subcategoria", "categorias");

	foreach($respuesta as $row => $item){
		echo '<tr>
				<td>'.$item["id_subcategoria"].'</td>
				<td>'.$item["nombre"].'</td>
				<td>'.$item["id_categoria"].''.$item["nombre"].'</td>				
				<td>'.$item["descripcion"].'</td>
				<td><a><button></button></a></td>
				<td><a><button class="btn btn-primary">Editar</button></a></td>
			</tr>';
	}
}

//Controlador editar SubCategoria
public function editarSubCategoriaController(){
	$datosController = $_GET["id_subcategoria"];
	$respuesta = Datos::editarSubCategoriaModel($datosController, "SubCategoria");

	echo '
		<div class="form-group">
			<label>id_subcategoria</label>
			<div class="col-sm-4">
				<input type="number" value="'.$respuesta["id_subcategoria"].'" name="id_subcategoriaEditar">
			</div>
		</div>';
}

//Controlador actualizar SubCategoria
public function actualizarSubCategoriaController(){
	if(isset($_POST["nombreEditar"])){
		$datosController = array (
			"id_subcategoria"=>$_POST["id_subcategoriaEditar"]
		);

		$respuesta = Datos::actualizarSubCategoriaModel($datosController, "SubCategoria");

		if($respuesta == "success"){
			header("location:template.php?action=SubCategoria");
			ob_end_flush();
		}

		else{
			echo "error";
		}
		
	}
}

//Controlador borrar SubCategoria
public function borrarSubCategoriaController(){
	if(isset($_GET["id_subcategoriaBorrrar"])){
		$datosController = $_GET["id_subcategoriaBorrar"];

		$respuesta = Datos::borrarProductoModel($datosController, "SubCategoria");

		if($respuesta == "success"){
			header("location:template.php?action=SubCategoria");
			ob_end_flush();
		}
	}
}
#----------------------------Marca--------------------------------------------
//Controlador de Registrar Marca
public function registroMarcaController(){
	if(isset($_POST["NombreMarca"])){

		$datosController = array( 
			
			"nombre"=>$_POST["NombreMarca"]);
					
		$respuesta = Datos::registroMarcaModel($datosController, "marca");

		if($respuesta == "success"){
			echo 'Registro exitoso';

		}
	}	
}

#VISTA DE  Marca
#------------------------------------
public function vistaMarcaController(){

	$respuesta = Datos::vistaMarcaModel("marca");

	foreach($respuesta as $row => $item){
	echo'<tr>				
			<td>'.$item['id_marca'].'</td>					
			<td>'.$item["nombre"].'</td>			
			<td>
			<a href="template.php?action=EditarCategoria&id_categoria='.$item["id_categoria"].'"><button type="button" class="btn btn-success btn-sm" title="Editar" data-toggle="modal" data-target="#MCategoriaEditar"><i class="fa fa-edit"></i></button></a>
			<a href="template.php?action=marca&id_categoriaBorrar='.$item["id_categoria"].'"><button class="btn btn-danger btn-sm"> <i class="fa fa-unlock-alt"></i></button></a>
			</td>				
		</tr>';
	}
}

#EDITAR Marca
#------------------------------------
public function editarMarcaController(){

	$datosController = $_GET["id_marca"];
	$respuesta = Datos::editarMarcaModel($datosController, "marca");

	echo'
		<div class="form-group row">
			<label class="col-from-label col-md-3 col-sm-3 label-align">id_marca: </label> 
			<div class="col-md-6 col-sm-6">
				<input type="number" class="form-control" value="'.$respuesta["id_marca"].'" disabled>
			</div>
		</div>

		<div class="form-group row">
			 <label class="col-from-label col-md-3 col-sm-3 label-align">Nombre: </label>
			 <div class="col-md-6 col-sm-6">
				 <input type="text" class="form-control" value="'.$respuesta["nombre"].'" >
			</div>
		</div>
		 		

		<div class="form-group row">			 				 
				<input type="submit" class="btn btn-block btn-success" value="Actualizar">					
		</div>';				

}

#ACTUALIZAR Marcas
#------------------------------------
public function actualizarMarcaCategoriasController(){

	if(isset($_POST["nombreEditar"])){

		$datosController = array( 
		"id_categoria"=>$_POST["id_marcaEditar"],

		"nombre"=>$_POST["nombreEditar"]);

		
		$respuesta = Datos::actualizarMarcaModel($datosController, "marca");

		if($respuesta == "success"){

			header("location:template.php?action=Marca");
			ob_end_flush();

		}

		else{

			echo "error";

		}

	}

}

#BORRAR Marca
#------------------------------------
public function borrarMarcaController(){

	if(isset($_GET["id_marcaBorrar"])){

		$datosController = $_GET["id_marcaBorrar"];
		
		$respuesta = Datos::borrarMarcaModel($datosController, "marca");

		if($respuesta == "success"){

			header("location:template.php?action=marca");
			ob_end_flush();
		}
	}
}

#-----------------------------------------------------------------------------

#----------------------------Producto----------------------------------------------

//Controlador de Registrar Producto
public function registroProductoController(){
	if(isset($_POST["codigoRegistro"])){

		$datosController = array(
			"codigo_producto"=>$_POST["codigoRegistro"],

			"nombre"=>$_POST["nombreRegistro"],

			"date"=>$_POST["dateRegistro"],

			"precio"=>$_POST["precioRegistro"],

			"stock"=>$_POST["stockRegistro"],					
			
			"categoria"=>$_POST["categoria"]);
					
		$respuesta = Datos::registroProductoModel($datosController, "producto");

		if($respuesta == "success"){
			echo 'Registro exitoso';

		}
	}	
}

#VISTA DE  PRODUCTO
#------------------------------------
public function vistaProductoController(){

	$respuesta = Datos::vistaProductoModel("producto","categorias","subcategoria","marca");

	foreach($respuesta as $row => $item){
	echo'<tr>				
			<td>'.$item["id_producto"].'</td>
			<td><img src="'.$item["foto"].'"></td>
			<td>'.$item['n_interno'].'</td>
			<td>'.$item["id_categoria"].''.$item["nombre"].'</td>
			<td>'.$item["id_subcategoria"].''.$item["nombre"].'</td>
			<td>'.$item["sku"].'</td>
			<td>'.$item["nombre"].'</td>
			<td>'.$item["id_marca"].''.$item["nombre"].'</td>
			<td>'.$item["modelo"].'</td>
			<td>'.$item["stock"].'</td>
			<td><a href="template.php?action=editarproducto&id_producto='.$item["id_producto"].'"><button class="btn btn-block btn-primary" ><i class="fas fa-user-edit"></i></button></a></td>			
		</tr>';

	}
}


#EDITAR PRODUCTO
#------------------------------------
public function editarProductoController(){

	$datosController = $_GET["id_producto"];
	$respuesta = Datos::editarProductoModel($datosController, "producto");

	echo'
	<div class="form-group">
		<label>id_producto: </label> 
		<div class="col-sm-4">
			<input type="number" value="'.$respuesta["id_producto"].'" name="id_productoEditar">			
		</div>
	</div>

	<div class="form-group">
		<label> Codigo_producto:</label>
		<div class="col-sm-4">
			<input type="text" value="'.$respuesta["codigo_producto"].'" name="codigo_productoEditar" required>		
		</div>
	</div>

	<div class="form-group">
		<label> Nombre: </label>
		<div class="col-sm-4">
			<input type="text" value="'.$respuesta["nombre"].'" name="nombreEditar" required>		
		</div>
	</div>
	
	<div class="form-group">		 
		<label> Precio: </label>
		<div class="col-sm-4">
			<input type="number" value="'.$respuesta["precio"].'" name="precioEditar" required>			 			 
		</div>
	</div>

	<div class="form-group">		 
		<label> Stock: </label>
		<div class="col-sm-4">
			<input type="number" value="'.$respuesta["stock"].'" name="stockEditar" required>			 			 
		</div>
	</div>

	<div class="form-group">
			 <label>Selecciona Cageoria</label>
			 <div class="col-sm-4">  
			 <select name="categoria" class="form-control">';
				  
					   $categorias = Datos::ObtenerCategoria("categorias");
				   
					   foreach ($categorias as $a): 
						 echo ' <option value="'. $a['id_categoria'].'">'. $a['nombre'].'</option>';
				 endforeach; 			  
			echo'
		   </select>															  
		   </div>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-block btn-success" value="Actualizar">
	</div>'
	;

}


#ACTUALIZAR PRODUCTO
#------------------------------------
public function actualizarProductoController(){

	if(isset($_POST["nombreEditar"])){

		$datosController = array( 
		"id_producto"=>$_POST["id_productoEditar"],

		"codigo_producto"=>$_POST["codigo_productoEditar"],

		"nombre"=>$_POST["nombreEditar"],

		"precio"=>$_POST["precioEditar"],
		
		"stock"=>$_POST["stockEditar"],

		"categoria"=>$_POST["categoria"]);

		
		$respuesta = Datos::actualizarProductoModel($datosController, "producto");

		if($respuesta == "success"){

			header("location:template.php?action=producto");
			ob_end_flush();

		}

		else{

			echo "error";

		}

	}

}


#-----------------------------Unidades de medida-----------------------------------------------
//Registro de unidades de medida
public function registroUMedidaController(){
	if(isset($_POST["NombreUMedida"])){

		$datosController = array( 
			
			"nombre"=>$_POST["NombreUMedida"],
			
			"prefijo"=>$_POST["PrefijoUMedida"]);
					
		$respuesta = Datos::registroUMedidaModel($datosController, "unidadesmedida");

		if($respuesta == "success"){
			echo 'Registro exitoso';

		}
	}	
}


//Vista de Unidades de medida
public function vistaUMedidaController(){

	$respuesta = Datos::vistaUMedidaModel("unidadesmedida");

	foreach($respuesta as $row => $item){
		echo '<tr>
				<td>'.$item['id_umedida'].'</td>
				<td>'.$item["nombre"].'</td>
				<td>'.$item["prefijo"].'</td>
				<td>'.$item['date'].'</td>
				<td><a href="template.php?action=EditarUMedida&id_umedida='.$item["id_umedida"].'><button type="button" class="btn btn-success btn-sm" title="Editar" data-toggle="modal" data-target="#UMedidaEditar"><i class="fa fa-edit"></i></button></a></td>
			  </tr>';
	}
}

//Editar Unidades de medida
public function editarUMedidaController(){
	
	$datosController = $_GET["id_umedida"];
	$respuesta = Datos::editarUMedidaModel($datosController, "UnidadesMedida");

	echo '
		<div class="form-group row">
			<label class="col-from-label col-md-3 col-sm-3 label-align">Nombre</label>
			<div class="col-md-6 col-sm-6">
				<input type="text" class="form-control" value="'.$respuesta['nombre'].'">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-from-label col-md-3 col-sm-3 label-align">Prefijo</label>
			<div class="col-md-6 col-sm-6">
				<input type="text" class="form-control" value="'.$respuesta['prefijo'].'">
			</div>
		</div>';
}

//Actualizar Unidades de medida
public function actualizarUMedidaController(){

	if(isset($_POST["nombreEditar"])){
		$datosController = array(
			"id_umedida"=>$_POST["i_umedidaEdiar"],
			"nombre"=>$_POST["nombreEdiar"],
			"prefijo"=>$_POST["prefijoEditar"]);
		
			$respuesta = Datos::actualizarUMedidaModel($datosController, "UnidadesMedida");

			if($respuesta == "success"){
				header("location:template.php?action=UnidadesMedida");
				ob_end_flush();
			}

			else{
				echo "error";
			}
	}
}

//Borrar Unidades de medida
public function borrarUMedidaController(){
	
	if(isset($_GET["id_umedidaBorrar"])){
		
		$datosController = $_GET["id_umedidaBorrar"];

		$respuesta = Datos::borrarUMedidaModel($datosController, "UnidadesMedida");

		if($respuesta == "success"){
			header("location:template.php?action=UMedida");
			ob_end_flush();
		}
	}
}

#-----------------------------Ingreso historial------------------------------------------------

	#------------------------------------------------

	#VISTA HISTORIAL
	public function vistaHistorialController(){

		$datosController = $_GET["id_producto"];
		$respuesta = Datos::vistaHistorialModel($datosController, "historial");


		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["fecha"].'</td>
				<td>'.$item["nota"].'</td>
				<td>'.$item["referencia"].'</td>
				<td>'.$item["cantidad"].'</td>
			</tr>';

		}
	}


	public function vistaHistorialAllController(){

		$respuesta = Datos::vistaHistorialAllModel("historial");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["fecha"].'</td>
				<td>'.$item["nota"].'</td>
				<td>'.$item["referencia"].'</td>
				<td>'.$item["cantidad"].'</td>
			</tr>';

		}
	}



#----------------------------------
public function obtenerStockController(){
	
	$datosController = $_GET["id_producto"];
	$obtener = Datos::valorStockModel($datosController, "productos");

	$actual=$obtener["stock"];

	 echo'
			<div class="form-group">
				<label for="stockEditar">Valor actual</label>
				<input type="number" disabled class="form-control"  value="'.$actual.'" name="actual" required>
			</div>';		
			
			if(isset($_POST["cantidad"])){
				$nuevo=intval($_POST["cantidad"]);
				
				if($_POST["Radio"]=="+"){
					$stock=$actual+$nuevo;
					$nota=$_SESSION['nombre'] . " " .
					"agrego " . $nuevo . " producto(S) al inventario.";
				}else {
					$stock=$actual-$nuevo;
					$nota=$_SESSION['nombre'] . " " .
					"elimino " . $nuevo . " producto(S) al inventario.";
				}
				

				$datosController2 = array(
					"id_producto"=>$datosController,
					"cantidad"=>$stock);
	
				$datosController3 = array(
					"id_producto"=>$datosController,
					"n_u"=>$_SESSION['n_u'],
					"fecha"=>$fecha_actual,
					"nota"=>$nota,
					"referencia"=>$_POST["referencia"],
					"cantidad"=>$nuevo
					);

					
				$respuesta = Datos:: editarStockModel($datosController2, "productos");
				$respuesta2 = Datos::insertarHistorialModel($datosController3, "historial");	
				if($respuesta == "success" || $respuesta2 == "success"){
	
					header("location:template.php?action=producto");
					ob_end_flush();
				}
	
				else{
	
					header("location:index.php");
				}
	
			}
		
}
#-----------------------Proveedores-------------------------
//Controlador de Registrar Proveedores
public function registroProveedoresController(){
	if(isset($_POST["nombreP"])){

		$datosController = array(

			"nombre"=>$_POST["nombreP"],

			"categoria"=>$_POST["categoria"],

			"subcategoria"=>$_POST["subcategoria"],

			"productos"=>$_POST["productos"],

			"estado"=>$_POST["estadoP"],			
			
			"municipio"=>$_POST["municipioP"],

			"calle"=>$_POST["calleP"],
			
			"telefono"=>$_POST["telefonoP"],
			
			"email"=>$_POST["emailP"],
			
			"cuenta_bancaria"=>$_POST["cuentaBP"]);
					
		$respuesta = Datos::registroProveedorModel($datosController, "Proveedores");

		if($respuesta == "success"){
			echo 'Registro exitoso';

		}
	}	
}

#VISTA DE  Proveedores
#------------------------------------
public function vistaProveedoresController(){

	$respuesta = Datos::vistaProveedorModel("Proveedores","Categorias", "SubCategoria" ,"Producto");

	foreach($respuesta as $row => $item){
	echo'<tr>				
			<td>'.$item['id_proveedor'].'</td>					
			<td>'.$item['nombre'].'</td>
			<td>'.$item['id_categoria'].'</td>
			<td>'.$item['id_subcategoria'].'</td>
			<td>'.$item['id_productos'].'</td>
			<td>'.$item['estado'].'</td>
			<td>'.$item['municipio'].'</td>
			<td>'.$item['calle'].'</td>
			<td>'.$item['telefono'].'</td>
			<td>'.$item['email'].'</td>
					
		</tr>';

	}
}


#EDITAR proveedor
#------------------------------------
public function editarProveedoresController(){

	$datosController = $_GET["id_proveedor"];
	$respuesta = Datos::editarProveedorModel($datosController, "proveedores");

	echo'
	<div class="form-group row">
		<label class="col-from-label col-md-3 col-sm-3 label-align" for="id_producto">Id_proveedor: </label> 
		<div class="col-md-6 col-sm-6">
			<input type="number" class="form-control" value="'.$respuesta["id_producto"].'" name="id_proveedorEditar" disabled>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-from-label col-md-3 col-sm-3 label-align" for="nombre">Nombre:</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" value="'.$respuesta["nombre"].'" name="nombreEditar" required>		
		</div>
	</div>

	<div class="form-group row">
                  <label class="col-from-label col-md-3 col-sm-3 label-align" for="categoria">Categoría *</label>
                  <div class="col-md-6 col-sm-6">
                    <select class="form-control" name="categoria">
					  <option selected disabled>Selecciona una opción</option>';
					
					  $categorias = Datos::ObtenerCategoria("categorias");
					  	foreach($categorias as $a):
					   		echo '<option value="'.$a['id_categoria'].'"> '.$a['nombre'].'</option>';
						endforeach;
					  echo'
						
            </select>
    	</div>
    </div>
	
	<div class="form-group row">		 
		<label class="col-from-label col-md-3 col-sm-3 label-align" for="subcategoria">Subcategoria: </label>
		<div class="col-md-6 col-sm-6">
			<select class="form-control" name="subcategoria">
				<option select disabled>Selecciona una opcion</option>';

				$subcategoria = Datos::ObtenerSubCtaegoria("subcategoria");

				foreach($subcategoria as $b):
					echo '<option value="'.$b['id_subcategoria'].'"> ' .$b[nombre].' </option>';
				endforeach;
				echo'
			</select>
		</div>
	</div>


	<div class="form-group row">
			<label class="col-form-label col-md-3 col-sm-3 label-align" for="producto">Producto:</label>
			<div class="col-md-6 col-sm-6">
				<select class="form-control" name="producto">
					<option select disabled>Selecciona una opcion</option>';

						$producto = Datos::ObtenerProducto("producto");

						foreach ($producto as $c) :
							echo '<option value="'.$c['id_productos'].'"> ' .$c[nombre]. ' </option>';
						endforeach;
					echo'
				</select>
			</div>
	</div>

	<div class="form-group row">
			<label class="col-form-label col-md-3 col-sm-3 label-align" for="estado">Estado:</label>
			<div class="col-md-6 col-sm-6">
				<input type="text" class="form-control" value="'.$respuesta["estado"].'" name="estadoEditar" >				
			</div>
	</div>
	
	<div class="form-group row">
			<label class="col-from-label col-md-3 col-sm-3 label-align" for="municipio">Municipio:</label>
			<div class="col-md-6 col-sm-6">
					<input type="text" class="form-control" value="'.$respuesta["municipio"].'" name="municipioEditar">
			</div>
	</div>

	<div class="form-group row">
			<label class="col-from-label col-md-3 col-sm-3 label-align" for="calle">Calle:</label>
			<div class="col-md-6 col-sm-6">
					<input type="text" class="form-control" value="'.$respusta["calle"].'" name="calleEditar">
			</div>
	</div>

	<div class="form-group row">
			<label class="col-from-label col-md-3 col-sm-3 label-align" for="telefono">Teléfono:</label>
			<div class="col-md-6 col-sm-6">
					<input type="number" class="form-control" value="'.$respuesta["telefono"].'" name="telefonoEditar">
			</div>
	</div>

	<div class="form-group row">
			<label class="col-from-label col-md-3 col-sm-3 label-align" for="email">Correo electrónico:</label>
			<div class="col-md-6 col-sm-6">
					<input type="email" class="form-control" value="'.$respuesta["email"].'" name="emailEditar">
			</div>
	</div>

	<div class="form-group row">
			<label class="col-from-label col-md-3 col-sm-3 label-align" for="cuentaBP">Cuenta bancaria:</label>
			<div class="col-md-6 col-sm-6">
					<input type="number" class="form-control" value="'.$respuesta["cuenta_bancaria"].'">
			</div>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-block btn-success" value="Actualizar">
	</div>'
	;

}


#ACTUALIZAR Proveedor
#------------------------------------
public function actualizarProveedoresController(){

	if(isset($_POST["nombreEditar"])){

		$datosController = array( 
		"id_proveedor"=>$_POST["id_proveedorEditar"],

		"nombre"=>$_POST["nombreEditar"],

		"categoria"=>$_POST["categoria"],

		"subcategoria"=>$_POST["subcategoria"],
		
		"producto"=>$_POST["producto"],

		"estado"=>$_POST["estadoEditar"],
		
		"municipio"=>$_POST["municipioEditar"],
	
		"calle"=>$_POST["calleEditar"],
	
		"telefono"=> $_POST["telefonoEditar"],
	
		"email"=> $_POST["emailEditar"],
	
		"cuenta_bancaria"=> $_POST["cuentaBP"]);

		
		$respuesta = Datos::actualizarProveedorModel($datosController, "proveedores");

		if($respuesta == "success"){

			header("location:template.php?action=Proveedores");
			ob_end_flush();

		}

		else{

			echo "error";

		}

	}

}

#BORRAR Proveedor
#-----------------------------------
public function borrarProveedoresController(){

	if(isset($_GET["id_proveedorBorrar"])){

		$datosController = $_GET["id_proveedorBorrar"];
		
		$respuesta = Datos::borrarProveedorModel($datosController, "proveedores");

		if($respuesta == "success"){

			header("location:template.php?action=Proveedores");
			ob_end_flush();		
		}
	}
}

#---------------------------------------------------

#AGREGAR FORMULARIO WIZARD
public function prueba($datos){

	//$id_tienda = $_SESSION['total_tienda']; //+

	$form1 = array(
		"tienda" => $datos['tienda'],
		"logo" => $datos['logo'],
		"nombre_empresa" => $datos['nombre_empresa'],
		"correo" => $datos['correo'],
		"telefono" => $datos['telefono'],
		"telefono_op" => $datos['telefono_op'],
		"pagina" => $datos['pagina'],
		"facebook" => $datos['facebook'],
		"twitter" => $datos['twitter']
	);

	$form2 = array(
		"tienda_asig" => $datos['tienda_asig'],
		"depto" => $datos['depto'],
		"telefono_laboral" => $datos['telefono_laboral'],
		"correo_laboral" => $datos['correo_laboral']
	);

	$form3 = array(
		"rfc" => $datos['rfc'],
		"razonSE" => $datos['razonSE'],
		"regimen_cap" => $datos['regimen_cap'],
		"dom_calle" => $datos['dom_calle'],
		"dom_numero_exterior" => $datos['dom_numero_exterior'],
		"dom_numero_interior" => $datos['dom_numero_interior'],
		"codigo_postal" => $datos['codigo_postal'],
		"colonia" => $datos['colonia'],
		"localidad" => $datos['localidad'],
		"municipio" => $datos['municipio'],
		"estado" => $datos['estado']
	);

	$total = $datos['total'];

	$respuesta = Datos::AgregarWizard($form1, $form2, $form3, 1);

		if($respuesta == "success"){

			header("location:template.php?action=Proveedores");
			ob_end_flush();		
	}

}


}
?>