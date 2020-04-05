<?php

include_once "config.php";
include_once "entidades/cliente.entidad.php";
include_once "entidades/producto.entidad.php";
include_once "entidades/venta.entidad.php";

if($_POST){
    $venta = new Venta();
    $venta->cargarDesdeFormulario($_REQUEST);

	if(isset($_POST["btnInsertar"])){
       $venta->insertar();

	} else if(isset($_POST["btnBorrar"])){
       $venta->borrar();

    } else if(isset($_POST["btnActualizar"])){
       $venta->actualizar();
    }
}

$cliente = new Cliente();
$aClientes = $cliente->obtenerTodos();

$producto = new Producto();
$aProductos = $producto->obtenerTodos();

$venta = new Venta();
$aVentas = $venta->obtenerTodos();

if(isset($_GET["id"])){
    $idVenta = $_GET["id"];
    $venta->obtenerUnoPorId($idVenta);
}

include_once "header.php";

?>

    <div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Registro de ventas</h1>
        </div>
    </div>
    <div class="row">
    <div class="col-6">
        <form action="" method="POST">
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtFecha">Fecha:</label>
                <input type="date" required class="form-control" name="txtFecha" id="txtNtxtFechaombre" value="<?php echo date_format(date_create($venta->fecha), 'Y-m-d'); ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="lstCliente">Cliente:</label>
                <select required class="form-control" name="lstCliente" id="lstCliente">
                    <option disabled selected value="">Seleccionar</option>
                    <?php foreach($aClientes as $cliente):  ?>
                            <?php if($cliente->idcliente == $venta->fk_idcliente): ?>
                                <option selected value="<?php echo $cliente->idcliente; ?>"><?php echo $cliente->nombre; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $cliente->idcliente; ?>"><?php echo $cliente->nombre; ?></option>
                            <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="lstProducto">Producto:</label>
                <select required class="form-control" name="lstProducto" id="lstProducto">
                    <option disabled selected value="">Seleccionar</option>
                     <?php 
                     foreach($aProductos as $producto){
                        if($producto->idproducto == $venta->fk_idproducto)
                            echo "<option selected value='$producto->idproducto'>$producto->nombre</option>";
                        else
                            echo "<option value='$producto->idproducto'>$producto->nombre</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtCorreo">Importe:</label>
                <input type="text" class="form-control" name="txtImporte" id="txtImporte" value="<?php echo $venta->importe; ?>" />
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
                    <th>Fecha</th>            
                    <th>Cliente</th>          
                    <th>Producto</th>          
                    <th>Precio</th>          
                </tr>
                </thead>
                <tbody>
                <?php foreach($aVentas as $index => $venta): ?>
                <tr>
                    <td><?php echo $index+1; ?></td>
                    <td><a href="abmventa.php?id=<?php echo $venta->idventa; ?>"><?php echo date_format(date_create($venta->fecha), 'd/m/Y'); ?></a></td>
                    <td><a target="_blank" href="abmcliente.php?pos=<?php echo $venta->fk_idcliente; ?>"><?php echo $venta->nombre_cliente; ?></a></td>
                    <td><a target="_blank" href="abmproducto.php?pos=<?php echo $venta->fk_idproducto; ?>"><?php echo $venta->nombre_producto; ?></a></td>
                    <td>$ <?php echo $venta->importe ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</body>
</html>