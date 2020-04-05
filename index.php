<?php


//Preguntar si existe el archivo para generar la tabla html mas abajo
 if(file_exists("archivo.txt")){
     //Leer el archivo.txt y lo guardamos en una variable $json_clientes
    $json_datos = file_get_contents("archivo.txt");

    //Pasar el json a un array $aClientes
    $aClientes = json_decode($json_datos, true);
 
} else {
    //Si no existe el archivo inicializa el array vacio
    $aClientes = [];
}

//Leo la posicion a visualizar
$pos = isset($_GET["pos"])? $_GET["pos"]:"";

if($_POST){
	if(isset($_POST["btnInsertar"])){
        //Incializa un array para los clientes en vacio
        $aClientes = [];

        //Si existe el archivo cargo el array con los clientes
        if(file_exists("archivo.txt")){
            $json_datos = file_get_contents("archivo.txt");
            $aClientes = json_decode($json_datos, true);
        }

        //Insertamos el nuevo cliente en la primer posicion disponible en el array
        $aClientes[] = array("dni" => trim($_POST["txtDNI"]),
                            "nombre" => trim($_POST["txtNombre"]),
                            "telefono" => trim($_POST["txtTelefono"]),
                            "correo" => trim($_POST["txtCorreo"]));

		//Convierte el array en json
		$json_datos = json_encode($aClientes);

		//Agregar el json en un archivo
        file_put_contents("archivo.txt", $json_datos);
        
	} else if(isset($_POST["btnBorrar"])){
        //Elimina del array la posicion indicada en la URL
        unset($aClientes[$pos]);

        $json_datos = json_encode($aNuevo);
        file_put_contents("archivo.txt", $json_datos);

    } else if(isset($_POST["btnActualizar"])){

        //Insertamos el nuevo cliente en la posicion deseada en el array
        $aClientes[$pos] = array("dni" => trim($_POST["txtDNI"]),
                            "nombre" => trim($_POST["txtNombre"]),
                            "telefono" => trim($_POST["txtTelefono"]),
                            "correo" => trim($_POST["txtCorreo"]));

		//Convierte el array en json
		$json_datos = json_encode($aClientes);

		//Agregar el json en un archivo
        file_put_contents("archivo.txt", $json_datos);

    }
}

include_once "header.php"
?>

    <div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Registro de clientes</h1>
        </div>
    </div>
    <div class="row">
    <div class="col-6">
        <form action="" method="POST">
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtDNI">DNI:</label>
                <input type="text" required class="form-control" name="txtDNI" id="txtDNI" value="<?php echo isset($aClientes[$pos])?$aClientes[$pos]["dni"]:""; ?>">
                <input type="hidden" class="form-control" name="txtPos" id="txtPos" value="<?php echo isset($pos)? $pos:""; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtNombre">Nombre y apellido:</label>
                <input type="text" required class="form-control" name="txtNombre" id="txtNombre" value="<?php echo (isset($aClientes[$pos]) ? $aClientes[$pos]["nombre"]:""); ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtTelefono">Teléfono:</label>
                <input type="text" class="form-control" name="txtTelefono" id="txtTelefono" value="<?php echo isset($aClientes[$pos])?$aClientes[$pos]["telefono"]:""; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtCorreo">Correo:</label>
                <input type="text" class="form-control" name="txtCorreo" id="txtCorreo" value="<?php echo isset($aClientes[$pos])?$aClientes[$pos]["correo"]:""; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="fileCV">Archivos:</label>
                <input type="file" class="form-control" name="archivos[]" id="fileCV" multiple>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <input type="submit" class="btn btn-primary" name="btnInsertar" id="btnInsertar" value="Insertar">
                <a href="index.php" class="btn btn-secondary">Limpiar</a>
                <input type="submit" class="btn btn-danger" name="btnBorrar" id="btnInsertar" value="Borrar">
                <input type="submit" class="btn btn-success" name="btnActualizar" id="btnInsertar" value="Actualizar">
            </div>
        </div>
        </form>
        </div>
        <div class="col-6">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>DNI</th>            
                    <th>Nombre</th>            
                    <th>Correo</th>          
                </tr>
                </thead>
                <tbody>
                <?php foreach($aClientes as $indice => $cliente): ?>
                <tr>
                    <td><a href="index.php?pos=<?php echo $indice; ?>"><?php echo $cliente["dni"]; ?></a></td>
                    <td><?php echo $cliente["nombre"]; ?></td>
                    <td><a href="mailto:<?php echo $cliente["correo"]; ?>"><?php echo $cliente["correo"]; ?></a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</body>
</html>