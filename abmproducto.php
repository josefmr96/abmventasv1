<?php

include_once "config.php";
include_once "entidades/producto.entidad.php";

if($_POST){
    $producto = new Producto();
    $producto->cargarDesdeFormulario($_REQUEST);

	if(isset($_POST["btnInsertar"])){
       $producto->insertar();

	} else if(isset($_POST["btnBorrar"])){
       $producto->borrar();

    } else if(isset($_POST["btnActualizar"])){
       $producto->actualizar();

    }
}

$producto = new Producto();

//Obtiene todos los productos
$aProductos = $producto->obtenerTodos();


if(isset($_GET["pos"])){
    $idProducto = $_GET["pos"];
    $producto->obtenerUnoPorId($idProducto);
}

include_once "header.php";

?>

    <div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Registro de productos</h1>
        </div>
    </div>
    <div class="row">
    <div class="col-6">
        <form action="" method="POST">
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" required class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $producto->nombre; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtCantidad">Cantidad:</label>
                <input type="number" required class="form-control" name="txtCantidad" id="txtCantidad" value="<?php echo $producto->cantidad; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtPrecio">Precio:</label>
                <input type="text" class="form-control" name="txtPrecio" id="txtPrecio" value="<?php echo $producto->precio; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtCorreo">Descripción:</label>
                <textarea class="form-control" name="txtDescripcion" id="txtDescripcion"><?php echo $producto->descripcion; ?></textarea>
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
                    <th>#</th>           
                    <th>Nombre</th>            
                    <th>Cantidad</th>          
                    <th>Precio</th>          
                </tr>
                </thead>
                <tbody>
                <?php foreach($aProductos as $index => $producto): ?>
                <tr>
                    <td><?php echo $index+1; ?></td>
                    <td><a href="producto.php?pos=<?php echo $producto->idproducto; ?>"><?php echo $producto->nombre; ?></a></td>
                    <td><?php echo $producto->cantidad ?></td>
                    <td><?php echo $producto->precio ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</body>
</html>