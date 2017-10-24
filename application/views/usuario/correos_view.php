<?php 
// Se consultan los datos del usuario
$usuario = $this->usuario_model->listar_usuarios($id_usuario);

// Se consultan los correos del sistema
$correos = $this->usuario_model->cargar_correos();

// Arreglo vacío con los correos activos del usuario
$correos_activos = array();

// Se consultan y recorren los correos del usuario
foreach ($this->usuario_model->cargar_correos_usuario($id_usuario) as $correo_usuario) {
	// Se agrega cada correo en el arreglo de una dimensión
    array_push($correos_activos, $correo_usuario->Fk_Id_Correo);
} // foreach
?>

<div id="form" class="container_12">
    <div class="grid_11">
        <div class="titulos_formularios">Correos electrónicos activados para  <?php echo "$usuario->Nombres $usuario->Apellidos"; ?></div><br>

		<div class="checkbox">
			<!-- Se recorren los correos -->
			<?php foreach ($correos as $correo) { ?>
				<label>
					<!-- Si el id del correo está dentro del arreglo de correos activos, lo chequea -->
                	<?php if(in_array($correo->Pk_Id_Correo, $correos_activos)) {$check = "checked";} else {$check = "";} ?>
					<input type="checkbox" name="correo[]" value="<?php echo $correo->Pk_Id_Correo; ?>" <?php echo $check ?> > <?php echo $correo->Nombre; ?>
				</label><br>
			<?php } ?>
		</div>

	    <input type="button" value="Guardar" onclick="javascript:guardar(<?php echo $id_usuario ?>)">
	    <input type="button" value="Regresar" onclick="javascript:regresar()">
	</div>
</div>

<script type='text/javascript'>
	function guardar(id_usuario)
	{
	    // Se declara un arreglo para guardar los permisos
	    var correos = new Array();

	    //Se recorren los correos chequeados
        $("input[name='correo[]']:checked").each(function() {
            //Se agrega el check al arreglo
            correos.push(parseFloat($(this).val()));
        });//each
        // console.log(correos);

        // Se actualizan los permisos
        actualizar = ajax("<?php echo site_url('usuario/actualizar_correos'); ?>", {"id_usuario": id_usuario, "datos": correos}, "html");
        
        // Se retorna al listado de usuarios
        regresar();
	} // guardar

	function regresar()
    {
        window.location = "<?php echo site_url('usuario/ver'); ?>";
    } // regresar

 //     $(document).ready(function(){
 //         /************************Scripts para las tablas************************/
 //        $('#example').dataTable({
 //            "bPaginate": true,
 //            "bLengthChange": true,
 //            "bFilter": true,
 //            "bSort": true,
 //            "bInfo": true,
 //            'fillSpace': true,
 //            "bAutoWidth": true,
 //            "stateSave": true,

 //            //Este script establece un orden por cierta columna
 //            "aaSorting": [[ 0, "asc" ]]
 //        });
 //     })
</script>