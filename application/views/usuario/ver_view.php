<div id="form" class="container_12">
    <div class="grid_11">
        <div class="titulos_formularios">Listado de usuarios del sistema</div><br>

        <!-- Si tiene permisos -->
        <?php if (isset($permisos[11])) { ?>
            <input type="button" value="Agregar usuario" style="float:right; margin-top: -50px;" onClick="javascript:crear_usuario()">
        <?php } ?>

        <table cellpadding="0" cellspacing="0" border="" class="display" id="example" style="font-size: 15px;">
            <thead>
                <tr>
                	<th class="center">Nombre</th>
                	<th class="center">Tipo</th>
                	<th class="center">Teléfono</th>
                	<th class="center">Correo</th>
                	<th class="center">Estado</th>
                	<th class="center">Login</th>
                	<th class="center">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                	<td><?php echo "$usuario->Nombres $usuario->Apellidos"; ?></td>
                	<td></td>
                	<td><?php echo $usuario->Telefono; ?></td>
                	<td><?php echo $usuario->Email; ?></td>
                	<td><?php echo $retVal = ($usuario->Estado == 1) ? "Activo" : "Inactivo" ; ?></td>
                	<td><?php echo $usuario->Login; ?></td>
                	<td>
                        <!-- Si tiene permiso -->
                        <?php if (isset($permisos[27])) { ?>
                            <a href="<?php echo site_url('usuario/permisos/'.$usuario->Pk_Id_Usuario); ?>" title="Permisos al usuario"><i class="fa fa-lock fa-lg"></i></a>
                        <?php } ?>

                		<!-- Si tiene permiso -->
                		<?php if (isset($permisos[28])) { ?>
                        	<a href="<?php echo site_url('usuario/correos/'.$usuario->Pk_Id_Usuario); ?>" title="Correos configurados al usuario"><i class="fa fa-envelope fa-lg"></i></a>
                    	<?php } ?>
                	</td>
                </tr>
                <?php endforeach; ?>
        </table>
    </div>
</div>

<script type='text/javascript'>
    function crear_usuario()
    {
        // Se ejecuta el informe
        window.location = "<?php echo site_url('usuario'); ?>";
    } // crear_tercero

    $(document).ready(function(){
         /************************Scripts para las tablas************************/
        $('#example').dataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            'fillSpace': true,
            "bAutoWidth": true,
            "stateSave": true,

            //Este script establece un orden por cierta columna
            "aaSorting": [[ 0, "asc" ]]
        });
     })
</script>