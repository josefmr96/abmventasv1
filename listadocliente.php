<?php

include_once "config.php";
include_once "entidades/cliente.entidad.php";

$cliente = new Cliente();
$aClientes = $cliente->obtenerTodos();

include_once "header.php";

?>
<!-- Modal -->
    <div class="container">
    <div class="row">
        <div class="col-12 text-center">
        <h1>Listado de clientes</h1>
        </div>
        <div class="col-12">
        <table class="table table-hover">
                <thead>
                <tr>
                    <th>CUIT</th>            
                    <th>Nombre</th>            
                    <th>Correo</th>          
                    <th>Domicilio</th>          
                </tr>
                </thead>
                <tbody>
                <?php foreach($aClientes as $cliente): ?>
                <tr>
                    <td><a href="abmcliente.php?id=<?php echo $cliente->idcliente; ?>"><?php echo $cliente->cuit; ?></a></td>
                    <td><?php echo $cliente->nombre; ?></td>
                    <td><a href="mailto:<?php echo $cliente->correo; ?>"><?php echo $cliente->correo; ?></a></td>
                    <td><?php echo $cliente->domicilio; ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
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