<div class="titulos_formularios">Listado de solicitudes de contratos</div><br>
<div id="form" class="container_11">
    <table cellpadding="0" cellspacing="0" border="" class="display" id="example" style="font-size: 13px;">
        <thead> 
            <tr> 
				<th class="text-center">Número</th>
				<th class="text-center">Tipo</th>
				<th class="text-center">Contratista</th>
				<th class="text-center">Solicitante</th>
				<th class="text-center">Fecha de inicio</th>
				<th class="text-center">Número contrato</th>
				<th class="text-center">Opciones</th>
			</tr> 
        </thead> 
        <tbody>
			<?php foreach ($solicitudes as $solicitud) {  ?>
			<tr>
				<td class="text-right"><?php echo $solicitud->Pk_Id_Contrato_Solicitud; ?></td>
				<td><?php echo $solicitud->Tipo_Contrato; ?></td>
				<td><?php echo $solicitud->Contratista; ?></td>
				<td><?php echo $solicitud->Solicitante; ?></td>
				<td><?php echo $solicitud->Fecha_Inicial; ?></td>
				<td><?php echo $solicitud->Numero_Contrato; ?></td>
				<td>
					<?php
					// Si no tiene número de contrato
					echo anchor(base_url()."archivos/solicitudes/Solicitud_$solicitud->Pk_Id_Contrato_Solicitud.xlsx", img(array('src' => 'img/excel.png', 'title' => 'Descargar archivo de ítems, cantidades y valores', 'width' => '25', 'height' => '25')));

					// Si tiene permiso de crear contrato y no se le ha asociado contrato
					if (isset($permisos[1]) && !$solicitud->Numero_Contrato) {
						echo anchor(site_url('contrato/index/nueva_solicitud/'.$solicitud->Pk_Id_Contrato_Solicitud), img(array('src' => 'img/modificar.png', 'title' => 'Crear nuevo contrato', 'width' => '25', 'height' => '25')));
					} else {
						echo anchor(site_url('contrato/ver/'.$solicitud->Fk_Id_Contrato), img(array('src' => 'img/ver.png', 'title' => 'Ver el contrato', 'width' => '25', 'height' => '25')));
					}
					?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
    </table>
</div>



<script type='text/javascript'>
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
        });
     });//Fin document.ready
</script>