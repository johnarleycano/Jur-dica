<?php
// Se consultan los datos del usuario
$usuario = $this->usuario_model->listar_usuarios($id_usuario);

// Se consultan los tipos de acciones
$tipos = $this->usuario_model->cargar_acciones_tipos();

// Se consultan los módulos
$modulos = $this->usuario_model->cargar_modulos();

// Arreglo vacío con los permisos activos del usuario
$permisos = array();

// Se consultan y recorren los permisos del usuario
foreach ($this->usuario_model->cargar_permisos_usuario($id_usuario) as $permiso) {
	// Se agrega cada permiso en el arreglo de una dimensión
    array_push($permisos, $permiso->Fk_Id_Accion);
} // foreach
?>

<div id="form" class="container_12">
    <div class="grid_11">
        <div class="titulos_formularios">Permisos en el sistema para <?php echo "$usuario->Nombres $usuario->Apellidos"; ?></div><br>

        <table cellpadding="0" cellspacing="0" border="" class="display" id="example" style="font-size: 15px;">
            <thead>
	            <tr>
	            	<th class="center">Módulo</th>

	            	<!-- Se recorren los tipos de permisos -->
	            	<?php foreach ($tipos as $tipo) { ?>
	            		<th class="center"><?php echo $tipo->Nombre; ?></th>
	            	<?php } ?>
	            </tr>
            </thead>
			<tbody>
				<!-- Se recorren los módulos -->
				<?php foreach ($modulos as $modulo) { ?>
            		<tr class="center">
            			<td><?php echo $modulo->Nombre; ?></td>
            			
            			<!-- Se recorren los tipos de permisos -->
		            	<?php foreach ($tipos as $tipo) { ?>
		            		<!-- Se consultan las acciones de ese módulo y tipo -->
		            			<td class="left">
		            				<div class="checkbox">
		            					<?php foreach ($this->usuario_model->cargar_acciones($modulo->Pk_Id_Modulo, $tipo->Pk_Id_Accion_Tipo) as $accion) { ?>
		            						<label>
		                                    	<!-- Si el id del permiso está dentro del arreglo de permisos, lo chequea -->
		                                    	<?php if(in_array($accion->Pk_Id_Accion, $permisos)) {$check = "checked";} else {$check = "";} ?>
		            							<input type="checkbox" name="permiso[]" value="<?php echo $accion->Pk_Id_Accion; ?>" <?php echo $check ?> > <?php echo $accion->Nombre; ?>
		            						</label><br>
		            					<?php } ?>
		            				</div>
		            			</td>
		            	<?php } ?>
        			</tr>
            	<?php } ?>
			</tbody>            
        </table>
    </div>
    <center>	
	    <input type="button" value="Guardar permisos" onclick="javascript:guardar_permisos(<?php echo $id_usuario ?>)">
	    <input type="button" value="Regresar" onclick="javascript:regresar()">
	</center>
</div>

<script type='text/javascript'>
	function guardar_permisos(id_usuario) // guardar_permisos(id_usuario)
	{
	    // Se declara un arreglo para guardar los permisos
	    var permisos = new Array();

	    //Se recorren los permisos chequeados
        $("input[name='permiso[]']:checked").each(function() {
            //Se agrega el check al arreglo
            permisos.push(parseFloat($(this).val()));
        });//each
        // console.log(permisos);

        // Se actualizan los permisos
        actualizar = ajax("<?php echo site_url('usuario/actualizar_permisos'); ?>", {"id_usuario": id_usuario, "datos": permisos}, "html");
        
        // Se retorna al listado de usuarios
        regresar();
	} // guardar_permisos

	function regresar()
    {
        window.location = "<?php echo site_url('usuario/ver'); ?>";
    } // regresar

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