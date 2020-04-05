<?php

include_once "config.php";
include_once "entidades/cliente.entidad.php";
include_once "entidades/provincia.entidad.php";
include_once "entidades/localidad.entidad.php";
include_once "entidades/domicilio.entidad.php";

$cliente = new Cliente();

if($_GET){
    if(isset($_GET["id"]) && $_GET["id"]> 0){
        $id = $_GET["id"];
        $cliente->obtenerPorId($id);
    }

    if(isset($_GET["do"]) && $_GET["do"] == "buscarLocalidad"){
        $idProvincia = $_GET["id"];
        $localidad = new Localidad();
        $aLocalidad = $localidad->obtenerPorProvincia($idProvincia);
        echo json_encode($aLocalidad);
        exit;
    }
}

if($_POST){
    $cliente = new Cliente();
    $cliente->cargarDesdeRequest($_REQUEST);

	if(isset($_POST["btnInsertar"])){
       $cliente->insertar();
       
        for($i=0; $i < count($_POST["txtTipo"]); $i++){
            $domicilio = new Domicilio();
            $domicilio->fk_tipo = $_POST["txtTipo"][$i];
            $domicilio->fk_idcliente = $cliente->idcliente;
            $domicilio->fk_idlocalidad = $_POST["txtLocalidad"][$i];
            $domicilio->domicilio = $_POST["txtDomicilio"][$i];
            $domicilio->insertar();
        }

	} else if(isset($_POST["btnBorrar"])){
       $cliente->borrar();

    } else if(isset($_POST["btnActualizar"])){
       $cliente->actualizar();

    }
}

$provincia = new Provincia();
$aProvincias = $provincia->obtenerTodos();

include_once "header.php";

?>
<!-- Modal -->
<div class="modal fade" id="modalDomicilio" tabindex="-1" role="dialog" aria-labelledby="modalDomicilioLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDomicilioLabel">Domicilio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
            <div class="col-12 form-group">
                <label for="lstTipo">Tipo:</label>
                <select name="lstTipo" id="lstTipo" class="form-control">
                    <option value="" disabled selected>Seleccionar</option>
                    <option value="1">Personal</option>
                    <option value="2">Laboral</option>
                    <option value="3">Comercial</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="lstProvincia">Provincia:</label>
                <select name="lstProvincia" id="lstProvincia" onchange="fBuscarLocalidad();" class="form-control">
                    <option value="" disabled selected>Seleccionar</option>
                    <?php foreach($aProvincias as $prov): ?>
                        <option value="<?php echo $prov->idprovincia; ?>"><?php echo $prov->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="lstLocalidad">Localidad:</label>
                <select name="lstLocalidad" id="lstLocalidad" class="form-control">
                    <option value="" disabled selected>Seleccionar</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtDireccion">Dirección:</label>
                <input type="text" name="" id="txtDireccion" class="form-control">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="fAgregarDomicilio()">Agregar</button>
      </div>
    </div>
  </div>
</div>
    <div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Registro de clientes</h1>
        </div>
    </div>
    <div class="row">
    <div class="col-12">
        <form action="" method="POST">
        <div class="row">
            <div class="col-6 form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" required class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $cliente->nombre; ?>">
            </div>
            <div class="col-6 form-group">
                <label for="txtCantidad">CUIT:</label>
                <input type="number" required class="form-control" name="txtCuit" id="txtCuit" value="<?php echo $cliente->cuit; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6 form-group">
                <label for="txtPrecio">Teléfono:</label>
                <input type="text" class="form-control" name="txtTelefono" id="txtTelefono" value="<?php echo $cliente->telefono; ?>">
            </div>
            <div class="col-6 form-group">
                <label for="txtCorreo">Correo:</label>
                <input type="" class="form-control" name="txtEmail" id="txtEmail" required value="<?php echo $cliente->correo; ?>">
            </div>
        </div>
        <div class="row">
        <div class="col-12">  
        <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> Domicilios
                    <div class="pull-right">
                        <button type="button" class="btn btn-secondary fa fa-plus-circle" data-toggle="modal" data-target="#modalDomicilio">Agregar</button>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="grilla" class="display" style="width:98%">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Provincia</th>
                                <th>Localidad</th>
                                <th>Dirección</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table> 
                 </div>
            </div>          
        </div>
    </div>
        <div class="row">
            <div class="col-12 form-group">
                <input type="submit" class="btn btn-primary" name="btnInsertar" id="btnInsertar" value="Insertar">
                <a href="index.php" class="btn btn-secondary">Limpiar</a>
                <input type="submit" class="btn btn-danger" name="btnBorrar" id="btnBorrar" value="Borrar">
                <input type="submit" class="btn btn-success" name="btnActualizar" id="btnActualizar" value="Actualizar">
            </div>
        </div>
        </form>
        </div>
    </div>
</div>
    <script>

        $('#grilla').DataTable();
        
        function fBuscarLocalidad(){
            idProvincia = $("#lstProvincia option:selected").val();
            $.ajax({
	            type: "GET",
	            url: "abmcliente.php?do=buscarLocalidad",
	            data: { id:idProvincia },
	            async: true,
	            dataType: "json",
	            success: function (respuesta) {
                    $("#lstLocalidad option").remove();
                    $("<option>", {
                        value: 0,
                        text: "Seleccionar",
                        disabled: true,
                        selected: true
                    }).appendTo("#lstLocalidad");
                
                    for (i = 0; i < respuesta.length; i++) {
                        $("<option>", {
                            value: respuesta[i]["idlocalidad"],
                            text: respuesta[i]["nombre"]
                            }).appendTo("#lstLocalidad");
                        }
                    $("#lstLocalidad").prop("selectedIndex", "0");
	            }
	        });
        }

        function fAgregarDomicilio(){
            var grilla = $('#grilla').DataTable();
            grilla.row.add([
                $("#lstTipo option:selected").text() + "<input type='hidden' name='txtTipo[]' value='"+ $("#lstTipo option:selected").val() +"'>",
                $("#lstProvincia option:selected").text() + "<input type='hidden' name='txtProvincia[]' value='"+ $("#lstProvincia option:selected").val() +"'>",
                $("#lstLocalidad option:selected").text() + "<input type='hidden' name='txtLocalidad[]' value='"+ $("#lstLocalidad option:selected").val() +"'>",
                $("#txtDireccion").val() + "<input type='hidden' name='txtDomicilio[]' value='"+$("#txtDireccion").val()+"'>",
                ""
            ]).draw();
            $('#modalDomicilio').modal('toggle');
            limpiarFormulario();
        }

        function limpiarFormulario(){
            $("#lstTipo").val(0);
            $("#lstProvincia").val(0);
            $("#lstLocalidad").val(0);
            $("#txtDireccion").val("");
        }
    </script>
</body>
</html>