<?php

require_once "conexion.php";

class Datos extends Conexion{


	#REGISTRO DE USUARIOS
	#-------------------------------------
	public function registroUsuarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, usuario, password, email) VALUES (:nombre, :usuario, :password, :email)");	
        $stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);		
		$stmt->bindParam(":password", $datosModel["password"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datosModel["email"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}

	#INGRESO USUARIO
	#-------------------------------------
	public function ingresoUsuarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT nombre, n_u, usuario,password, total_tienda FROM $tabla WHERE usuario = :usuario");	

		$stmt->bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);

		$stmt->execute();
 
		return $stmt->fetch();

		$stmt->close();

	}

	#VISTA USUARIOS
	#-------------------------------------

	public function vistaUsuariosModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT n_u, nombre, usuario, password, email FROM $tabla");	
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	#EDITAR USUARIO
	#-------------------------------------

	public function editarUsuarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT n_u, nombre, usuario, password, email FROM $tabla WHERE n_u = :n_u");

		$stmt->bindParam(":n_u", $datosModel, PDO::PARAM_INT);	

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#ACTUALIZAR USUARIO
	#-------------------------------------

	public function actualizarUsuarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET usuario = :usuario, nombre = :nombre, password = :password, email = :email WHERE n_u = :n_u");
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);		
		$stmt->bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);		
		$stmt->bindParam(":password", $datosModel["password"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datosModel["email"], PDO::PARAM_STR);
        $stmt->bindParam(":n_u", $datosModel["n_u"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}


	#BORRAR USUARIO
	#------------------------------------
	public function borrarUsuarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE n_u = :n_uBorrar");
		$stmt->bindParam(":n_uBorrar", $datosModel, PDO::PARAM_INT);

		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}

#-----------------Categoria-------------------------------
	//------Agregar Categoria-------
	public function registroCategoriaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre,descripcion) VALUES (:nombre, :descripcion)");	
        $stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}

	#VISTA Categorias
	#-------------------------------------

	public function vistaCategoriasModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id_categoria, nombre, descripcion, date FROM $tabla");	
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	#EDITAR categoria
	#-------------------------------------

	public function editarCategoriasModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id_categoria, nombre, descripcion FROM $tabla WHERE id_categoria = :id_categoria");

		$stmt->bindParam(":id_categoria", $datosModel, PDO::PARAM_INT);	

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#ACTUALIZAR categoria
	#-------------------------------------

	public function actualizarCategoriasModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, descripcion = :descripcion WHERE id_categoria = :id_categoria");
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);		
		$stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);        
		$stmt->bindParam(":id_categoria", $datosModel["id_categoria"], PDO::PARAM_INT);
		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}


	#BORRAR CATEGORIA
	#------------------------------------
	public function borrarCategoriasModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_categoria = :id_categoriaBorrar");
		$stmt->bindParam(":id_categoriaBorrar", $datosModel, PDO::PARAM_INT);

		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}

#---------------------------Sub-Categoria--------------------------------------
//---Agregar SubCategoria------------------------------------------------
public function registroSubCategoriaModel($datosModel, $tabla){
	$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, descripcion, id_categoria) VALUES  (:nombre, :descripcion,:categorias)");
	$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
	$stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);
	$stmt->bindParam(":categorias", $datosModel["categoria"], PDO::PARAM_STR);
	if($stmt->execute()){
		return "success";
	}
	else{
		return "error";
	}

	$stmt->close();

}

#Vista SubCategoria
public function vistaSubCategoriaModel($tabla, $tabla1){
	$stmt = Conexion::conectar()->prepare("SELECT A.id_subcategoria, A.nombre, A.descripcion, A.id_categoria, B.nombre as $tabla1 FROM $tabla A INNER JOIN $tabla1 AS B ON A.id_categoria=B.id_categoria");
	$stmt->execute();
	
	return $stmt->fetchAll();

	$stmt->close();
}

#Editar SubCategoria
public function editarSubCategoriaModel($datosModel, $tabla){
	$stmt = Conexion::conectar()->prepare("SELECT id_subcategoria, categoria, nombre, descripcion FROM $tabla WHERE id_subcategoria = :id_subcategoria");
	$stmt =bindParam(":id_subcategoria", $datosModel, PDO::PARAM_INT);
}

#Actualizar Subcategoria
public function actualizarSubCategoriaModel($datosModel, $tabla){
	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria = :categoria , nombre = :nombre , descripcion = :descripcion WHERE id_subcategoria = :id_subcategoria");
	$stmt->bindParam(":categoria", $datosModel["categoria"], PDO::PARAM_STR);
	$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
	$stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);
	$stmt->bindParam(":id_subcategoria", $datosModel["id_subcategoria"], PDO::PARAM_INT);

	if($stmt->execute()){

		return "success";
	}
	else{

		return "error";
	}

	$stmt->close();
}

#Borrar SubCategoria
public function borrarSubCategoriaModel($datosModel, $tabla){
	$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_subcategoria = :id_subcategoriaBorrar");
	$stmt->bindParam("id_subcategoria", $datosModel, PDO::PARAM_INT);

	if($stmt->execute()){

		return "success";

	}
	else{

		return "error";
	}

	$stmt->close();

}

#-----------------Marca-------------------------------
	//------Agregar Marca-------
	public function registroMarcaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre) VALUES (:nombre)");
        $stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}

	#VISTA Marca
	#-------------------------------------

	public function vistaMarcaModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id_marca, nombre FROM $tabla");	
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	#EDITAR Marca
	#-------------------------------------

	public function editarMarcaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id_marca, nombre FROM $tabla WHERE id_marca = :id_marca");

		$stmt->bindParam(":id_marca", $datosModel, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#ACTUALIZAR Marca
	#-------------------------------------

	public function actualizarMarcaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre WHERE id_marca = :id_marca");
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);		
		$stmt->bindParam(":id_marca", $datosModel["id_marca"], PDO::PARAM_INT);
		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}


	#BORRAR Marca
	#------------------------------------
	public function borrarMarcaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_marca = :id_marcaBorrar");
		$stmt->bindParam(":id_marcaBorrar", $datosModel, PDO::PARAM_INT);

		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}



#---------------------------Productos------------------------------
	//------Agregar producto-------
	public function registroProductoModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (foto, n_interno, id_categoria, id_subcategoria, sku, nombre, id_marca, modelo, precio, comision, stock, descripcion) VALUES (:foto, :n_interno, :categoria, :subcategoria, :sku, :nombre, :marca, :modelo, :precio, :comision, :stock, :descripcion)");
		$stmt->bindParam(":foto", $datosModel["foto"], PDO::PARAM_LOB);
		$stmt->bindParam(":n_interno", $datosModel["n_interno"], PDO::PARAM_INT);
		$stmt->bindParam(":categoria", $datosModel["categoria"], PDO::PARAM_STR);
		$stmt->bindParam(":subcategoria", $datosModel["subcategoria"], PDO::PARAM_STR);
		$stmt->bindParam(":sku", $datosModel["sku"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":marca", $datosmodel["marca"], PDO::PARAM_STR);
		$stmt->bindParam(":modelo", $datosModel["modelo"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datosModel["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":comision", $datosModel["comision"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datosModel["stock"], PDO::PARAM_INT);
		$stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);			
		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}

	#VISTA Producto
	#-------------------------------------

	public function vistaProductoModel($tabla, $tabla1, $tabla2, $tabla3){

	$stmt = Conexion::conectar()->prepare("SELECT A.id_producto, A.n_interno, A.foto, A.id_categoria, A.id_subcategoria, A.sku, A.nombre, A.id_marca, A.modelo, A.stock, B.id_categoria, B.nombre, C.id_subcategoria, C.nombre, D.id_marca, D.nombre FROM $tabla A INNER JOIN $tabla1 B ON A.id_categoria = B.id_categoria INNER JOIN $tabla2 C ON A.id_subcategoria = C.id_subcategoria INNER JOIN $tabla3 A.id_marca = D.id_marca");
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

	}
	
	#EDITAR Producto
	#-------------------------------------

	public function editarProductoModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id_producto, codigo_producto, nombre, date, precio, stock, id_categoria FROM $tabla WHERE id_producto = :id_producto");		
		$stmt->bindParam(":id_producto", $datosModel, PDO::PARAM_INT);	

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#ACTUALIZAR Producto
	#-------------------------------------

	public function actualizarProductoModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codigo_producto = :codigo_producto , nombre = :nombre, precio = :precio, stock = :stock, id_categoria= :categoria WHERE id_producto = :id_producto");
		$stmt->bindParam(":codigo_producto", $datosModel["codigo_producto"], PDO::PARAM_STR);		
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);				
		$stmt->bindParam(":precio", $datosModel["precio"], PDO::PARAM_STR);						
		$stmt->bindParam(":stock", $datosModel["stock"], PDO::PARAM_STR);						
		$stmt->bindParam(":id_producto", $datosModel["id_producto"], PDO::PARAM_INT);
		$stmt->bindParam(":categoria", $datosModel["categoria"], PDO::PARAM_STR);				

		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}


	#BORRAR Producto
	#------------------------------------
	public function borrarProductoModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_producto = :id_productoBorrar");
		$stmt->bindParam(":id_productoBorrar", $datosModel, PDO::PARAM_INT);

		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}
	#Extraer los datos de nuestra tabla producto
	public function ObtenerProducto($tabla1){
		$stmt = Conexion::conectar()->prepare("SELECT id_productos, nombre FROM $tabla1");	

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	#Extraer los datos de nuestra tabla subcategoria
	public function ObtenerSubCategoria($tabla2){
		$stmt = Conexion::conectar()->prepare("SELECT id_subcategoria, nombre FROM $tabla2");
		
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();
	}

	#Extraer los datos de nuestra tabla marca
	public function ObtenerMarca($tabla3){
		$stmt = Conexion::conectar()->prepare("SELECT id_marca, nombre FROM $tabla3");

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();
	}

	#Extraer los datos de nuestra tabla categoria

	public function ObtenerCategoria($tabla4){
		$stmt = Conexion::conectar()->prepare("SELECT id_categoria, nombre FROM $tabla4");
		
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();
	}
#-----------------------------------------------------
#--------------Unidades de medida-------------------------------
#Agregar Unidad de Medida
public function registroUMedidaModel($datosModel, $tabla){
	
	$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, prefijo) VALUES (:nombre, :prefijo)");	
	$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
	$stmt->bindParam(":prefijo", $datosModel["prefijo"], PDO::PARAM_STR);

	if($stmt->excute()){
		return "success";
	}

	else{

		return "error";

	}

	$stmt->close();
}

#Vista Unidad de Medida
public function vistaUMedidaModel($tabla){
	
	$stmt = Conexion::conectar()->prepare("SELECT id_umedida, nombre, prefijo, date FROM $tabla");
	$stmt->execute();

	return $stmt->fetchAll();

	$stmt->close();

}

#Editar Unidad de Medida
public function editarUMedidaModel($datosModel, $tabla){
	
	$stmt = Conexion::conectar()->prepare("SELECT id_umedida, nombre, prefijo FROM $tabla WHERE id_umedida = :id_umedida");
	$stmt->bindParam(":id_umedida", $datosModel, PDO::PARAM_INT);
	$stmt->execute();
	
	return $stmt->fetch();

	$stmt->close();
}

#Actualizar Unidad de Medida
public function actualizarUMedidaModel($datosModel, $tabla){
	
	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, prefijo = :prefijo WHERE id_umedida = :id_umedida");

	$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
	$stmt->bindParam(":prefijo", $datosModel["prefijo"], PDO::PARAM_STR);
	$stmt->bindParam(":id_umedida", $datosModel["id_umedida"], PDO::PARAM_INT);

	if($stmt->execute()){

		return "success";

	}

	else{

		return "error";

	}

	$stmt->close();
}

#Borrar Unidad de Medida
public function borrarUMedidaModel($datosModel, $tabla){
	
	$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_umedida = :id_umedidaBorrar");
	$stmt->bindParam(":id_umedidaBorrar", $datosModel, PDO::PARAM_INT);

	if($stmt->execute()){

		return "success";

	}

	else{

		return "error";
		
	}

	$stmt->close();
}

#---------------------------

	
#----------------------------------------------------
	#VISTA HISTORIAL

	public function vistaHistorialModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_producto = :id_producto");	

		$stmt->bindParam (":id_producto", $datosModel, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

	}


	public function vistaHistorialAllModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");	

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

	}



	#INSERTAR HISTORIAL
	public function insertarHistorialModel($datosModel, $tabla){

	$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_producto, n_u, fecha, nota, referencia, cantidad) VALUES (:id_producto, :n_u, :fecha, :nota, :referencia, :cantidad)");	
		
	$stmt->bindParam(":id_producto", $datosModel["id_producto"], PDO::PARAM_INT);
	$stmt->bindParam(":n_u", $datosModel["n_u"], PDO::PARAM_INT);		
	$stmt->bindParam(":fecha", $datosModel["fecha"], PDO::PARAM_STR);
	$stmt->bindParam(":nota", $datosModel["nota"], PDO::PARAM_STR);
	$stmt->bindParam(":referencia", $datosModel["referencia"], PDO::PARAM_STR);
	$stmt->bindParam(":cantidad", $datosModel["cantidad"], PDO::PARAM_INT);

	if($stmt->execute()){

		return "success";

	}

	else{

		return "error";

	}

	$stmt->close();

	}
	#----------------------
	#-------------------------------------------------------
	#REGRESAR VALOR DEL STOCK

	public function valorStockModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT stock FROM $tabla WHERE id_producto = :id_producto");
		
		$stmt->bindParam(":id_producto", $datosModel, PDO::PARAM_INT);


		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}



	#Editar Stock
	#-------------------------------------
	public function editarStockModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  stock = :cantidad WHERE id_producto = :id_producto");	
				
		$stmt->bindParam(":cantidad", $datosModel["cantidad"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datosModel["id_producto"], PDO::PARAM_INT);


		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}

#--------------------------------------------------
#-----------------Proveedores---------------------
//------Agregar Proveedores-------
public function registroProveedorModel($datosModel, $tabla){

	$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, id_categoria, id_subcategoria, id_productos, estado, municipio, calle, telefono, email, cuenta_bancaria) VALUES  (:nombre, :categoria, :subcategoria, :producto, :estado, :municipio, :calle, :telefono, :email, :cuenta_bancaria)");
	$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
	$stmt->bindParam(":categoria", $datosModel["categoria"], PDO::PARAM_STR);
	$stmt->bindParam(":subcategoria", $datosModel["subcategoria"], PDO::PARAM_STR);
	$stmt->bindParam(":producto", $datosModel["producto"], PDO::PARAM_STR);
	$stmt->bindParam(":estado", $datosModel["estado"], PDO::PARAM_STR);
	$stmt->bindParam(":municipio", $datosModel["municipio"], PDO::PARAM_STR);
	$stmt->bindParam(":calle", $datosModel["calle"], PDO::PARAM_STR);
	$stmt->bindParam(":telefono", $datosModel["telefono"], PDO::PARAM_INT);
	$stmt->bindParam(":email", $datosModel["email"], PDO::PARAM_STR);
	$stmt->bindParam(":cuenta_bancaria",$datosModel["cuenta_bancaria"], PDO::PARAM_INT);
	if($stmt->execute()){
		return "success";
	}
	else{
		return "error";
	}

	$stmt->close();

}

#VISTA Proveedores
#-------------------------------------
	public function vistaProveedorModel($tabla, $tabla1, $tabla2, $tabla3){

		$stmt = Conexion::conectar()->prepare("SELECT A.id_proveedor, A.nombre, A.id_categoria, A.id_subcategoria, A.id_productos, A.estado, A.municipio, A.calle, A.telefono, A.email, B.id_categoria, B.nombre, C.id_subcategoria, C.nombre , D.id_productos, D.nombre 
		FROM $tabla AS A 
		INNER JOIN $tabla1 AS B ON A.id_categoria = B.id_categoria 
		INNER JOIN $tabla2 AS C ON A.id_subcategoria = C.id_subcategoria 
		INNER JOIN $tabla3 AS D ON A.id_productos = D.id_productos;");
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

	}
	
	#EDITAR Proveedores
#-------------------------------------

public function editarProveedorModel($datosModel, $tabla){

	$stmt = Conexion::conectar()->prepare("SELECT id_proveedor, nombre, categoria, subcategoria, producto, estado, municipio, calle, telefono, email FROM $tabla WHERE id_proveedor = :id_proveedor");	

	$stmt->bindParam(":id_proveedor", $datosModel, PDO::PARAM_INT);


	$stmt->execute();

	return $stmt->fetch();

	$stmt->close();

}
	

	#ACTUALIZAR Proveedores
#-------------------------------------
	public function actualizarProveedorModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, id_categoria = :categoria, id_subcategoria = :subcategoria, id_producto = :producto, estado = :estado, municipio = :municipio, calle = :calle, telefono = :telefono, email = :email, cuenta_bancaria = :cuenta_bancaria WHERE id_producto = :id_producto");
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);		
		$stmt->bindParam(":categoria", $datosModel["categoria"], PDO::PARAM_STR);
		$stmt->bindParam(":subcategoria", $datosModel["subcategoria"], PDO::PARAM_STR);
		$stmt->bindParam(":producto", $datosModel["producto"], PDO::PARAM_STR);					
		$stmt->bindParam(":estado", $datosModel["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":municipio", $datosModel["municipio"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datosModel["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datosModel["email"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}


	#BORRAR Proveedores
	#------------------------------------
	public function borrarProveedorModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_proveedor = :id_proveedorBorrar");
		$stmt->bindParam(":id_proveedorBorrar", $datosModel, PDO::PARAM_INT);

		if($stmt->execute()){

			return "success";

		}

		else{

			return "error";

		}

		$stmt->close();

	}
	

	


#-----------------Termina proveedores----------------



#AGREGAR WIZARD FORMULARIO
#------------------------------

public function AgregarWizard($form1, $form2, $form3, $id_tienda){

	//var_dump($form1);
	try {  
		//$mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  
		$stmt = Conexion::conectar();
		$stmt->beginTransaction();

		$stmt1 = $stmt->prepare("INSERT INTO datosgenerales (tipo, logo, nombre, correo, telefono, telefono2, pagina_web, facebook, twitter, id_tienda) 
		                VALUES (:tienda, :logo, :nombre_empresa, :correo, :telefono, :telefono_op, :pagina, :facebook, :twitter, :id_tienda)");

		$stmt1 ->bindParam(":tienda", $form1["tienda"], PDO::PARAM_STR);
		$stmt1 ->bindParam(":logo", $form1["logo"], PDO::PARAM_STR);
		$stmt1 ->bindParam(":nombre_empresa", $form1["nombre_empresa"], PDO::PARAM_STR);
		$stmt1 ->bindParam(":correo", $form1["correo"], PDO::PARAM_STR);
		$stmt1 ->bindParam(":telefono", $form1["telefono"], PDO::PARAM_STR);
		$stmt1 ->bindParam(":telefono_op", $form1["telefono_op"], PDO::PARAM_STR);
		$stmt1 ->bindParam(":pagina", $form1["pagina"], PDO::PARAM_STR);
		$stmt1 ->bindParam(":facebook", $form1["facebook"], PDO::PARAM_STR);
		$stmt1 ->bindParam(":twitter", $form1["twitter"], PDO::PARAM_STR);
		$stmt1 ->bindParam(":id_tienda", $id_tienda, PDO::PARAM_INT);

		if($stmt1->execute()){
			$img = $form1["logo"];
			$ruta_carpeta = "";
			$nombre_archivo = "logo_".date("dHis") .".". pathinfo($_FILES[$img]["name"],PATHINFO_EXTENSION);
			$ruta_guardar_archivo = $ruta_carpeta . $nombre_archivo;

			if(move_uploaded_file($_FILES[$img]["tmp_name"],$ruta_guardar_archivo)){
				echo "guardado";
			}else{
				echo "no guardado";
			}
		}

		////////////////////

		$stmt2 = $stmt->prepare("INSERT INTO ubicacion (tienda_asignada, departamento, telefono, correo, id_tienda) 
		                VALUES (:tienda_asig, :depto, :telefono_laboral, :correo_laboral, :id_tienda)");

		$stmt2->bindParam(":tienda_asig", $form2["tienda_asig"], PDO::PARAM_STR);
		$stmt2->bindParam(":depto", $form2["depto"], PDO::PARAM_STR);
		$stmt2->bindParam(":telefono_laboral", $form2["telefono_laboral"], PDO::PARAM_STR);
		$stmt2->bindParam(":correo_laboral", $form2["correo_laboral"], PDO::PARAM_STR);
		$stmt2->bindParam(":id_tienda", $id_tienda, PDO::PARAM_INT);		
		
		$stmt2->execute();

		//////////////////////

		$stmt3 = $stmt->prepare("INSERT INTO datos_fiscales (rfc, razon_fiscal, regimen_capital, calle, num_exterior, num_interior, codigo_postal, colonia, localidad, municipio, estado, id_tienda) 
		                VALUES (:rfc, :razonSE, :regimen_cap, :dom_calle, :dom_numero_exterior, :dom_numero_interior, :codigo_postal, :colonia, :localidad, :municipio, :estado, :id_tienda)");

		$stmt3->bindParam(":rfc", $form3["rfc"], PDO::PARAM_STR);
		$stmt3->bindParam(":razonSE", $form3["razonSE"], PDO::PARAM_STR);
		$stmt3->bindParam(":regimen_cap", $form3["regimen_cap"], PDO::PARAM_STR);
		$stmt3->bindParam(":dom_calle", $form3["dom_calle"], PDO::PARAM_STR);
		$stmt3->bindParam(":dom_numero_exterior", $form3["dom_numero_exterior"], PDO::PARAM_STR);
		$stmt3->bindParam(":dom_numero_interior", $form3["dom_numero_interior"], PDO::PARAM_STR);
		$stmt3->bindParam(":codigo_postal", $form3["codigo_postal"], PDO::PARAM_STR);
		$stmt3->bindParam(":colonia", $form3["colonia"], PDO::PARAM_STR);
		$stmt3->bindParam(":localidad", $form3["localidad"], PDO::PARAM_STR);
		$stmt3->bindParam(":municipio", $form3["municipio"], PDO::PARAM_STR);
		$stmt3->bindParam(":estado", $form3["estado"], PDO::PARAM_STR);
		$stmt3->bindParam(":id_tienda", $id_tienda, PDO::PARAM_INT);

		$stmt3->execute();

		$stmt->commit();
		return "success";
		
	  } catch (Exception $e) {
		$stmt->rollBack();
	    echo "Fallo: " . $e->getMessage();
	  }

}



}
?>
