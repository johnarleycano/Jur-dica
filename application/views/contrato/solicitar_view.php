<?php
//Atributos para el fieldset
$fieldset = array('id' => 'fieldset', 'class' => 'fieldset');

// echo form_open('contrato/agregar_solicitud');

?>
<?php echo form_open_multipart('contrato/agregar_solicitud', array('name' => 'f1')); ?>

<div id="form" class="container_11">
    <fieldset>
        <legend><b>Paso 1 |</b> Diligenciar formato de solicitud de contrato</legend>
    </fieldset>
    
    <!-- Errores de validación -->
    <span class="error">
        <?php 
        echo form_error('tipo_contrato');
        echo form_error('contratista');
        echo form_error('centro_costo');
        echo form_error('objeto_contrato');
        echo form_error('fecha_inicial');
        echo form_error('plazo');
        echo form_error('valor_inicial');
        ?>
    </span>
    <div>
        <table width="100%">
            <tr>
                <?php 
                $_tipo_contrato = array('' => null);
                //Recorrido para traer todos los tipos de contratos de la base de datos y agregarlos en el dropdown
                foreach ($tipos_contratos as $tipo_contrato):
                    $_tipo_contrato[$tipo_contrato->Pk_Id_Tipo_Contrato] = $tipo_contrato->Nombre;
                endforeach; 
                ?>
                <td><?php echo form_label('Tipo de contrato *', 'tipo_contrato'); ?></td>
                <td>
                    <?php
                    echo form_dropdown('tipo_contrato', $_tipo_contrato, set_value('tipo_contrato'));
                    echo form_label('Obra o proyecto (si aplica)', 'nombre_obra');
                    echo form_input(array('name' => 'nombre_obra', 'id' => 'nombre_obra', 'value' => set_value('nombre_obra')));
                    ?>
                </td>
            </tr>
            <tr>
                <?php 
                $_contratista = array('' => null);
                //Recorrido para traer todos los estados de la base de datos y agregarlos en el dropdown
                foreach ($contratistas as $contratista):
                    $_contratista[$contratista->Pk_Id_Terceros] = $contratista->Nombre;
                endforeach; 
                ?>
                <td><?php echo form_label('Contratista *', 'contratista'); ?></td>
                <td><?php echo form_dropdown('contratista', $_contratista, set_value('contratista')); ?></td>
            </tr>
            <tr>
                <?php 
                    $_centrocostos = array('' => null);
                    //Recorrido para traer todos los estados de la base de datos y agregarlos en el dropdown
                    foreach ($centro_costos as $centro_costo):
                        $_centrocostos[$centro_costo->Pk_Id_Terceros] = $centro_costo->Nombre;
                    endforeach;
                ?>
                <td><?php echo form_label('Centro de Costos *', 'centro_costo'); ?></td>
                <td><?php echo form_dropdown('centro_costo', $_centrocostos); ?></td>
            </tr>
            <tr>
                <td><?php echo form_label('Objeto del contrato *', 'objeto_contrato'); ?></td>
                <td>
                    <?php echo form_textarea(array('class' => 'textarea_actualizar1', /*'style' => 'height: 200px;',*/ 'name' => 'objeto_contrato', 'id' => 'objeto_contrato', 'value' => set_value('objeto_contrato'))); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo form_label('Fecha Inicial *', 'fecha_inicial'); ?></td>
                <td><?php echo form_input(array('name' => 'fecha_inicial', 'id' => 'fecha_inicial', 'readonly' => 'readonly', 'value' => set_value('fecha_inicial'))); ?></td>
            </tr>
            <tr>
                <td><?php echo form_label('Plazo (días) *', 'plazo'); ?></td>
                <td><?php echo form_input(array('name' => 'plazo', 'id' => 'plazo', 'style' => 'text-align:right', 'value' => set_value('plazo'))); ?></td>
            </tr>
            <tr>
                <td><?php echo form_label('Valor Inicial *', 'valor_inicial'); ?></td>
                <td><?php echo form_input(array('name' => 'valor_inicial', 'id' => 'valor_inicial', 'style' => 'text-align: right', 'value' => set_value('valor_inicial'))); ?></td>
            </tr>
            <tr>
                <td><?php echo form_label('Observaciones', 'observaciones'); ?></td>
                <td>
                    <?php echo form_textarea(array('class' => 'textarea_actualizar1', /*'style' => 'height: 200px;',*/ 'name' => 'observaciones', 'id' => 'observaciones', 'value' => set_value('observaciones'))); ?>
                </td>
            </tr>
        </table>    
    </div>
    <br><br>

    <fieldset>
        <legend><b>Paso 2 |</b> Descargar cuadro de ítems, cantidades y valores</legend>
    </fieldset>

    <center>
        <input type="button" value="Descargar archivo" style="background: green; color: white" onCLick="javascript:descargar()">
    </center>
    <br><br>

    <fieldset>
        <legend><b>Paso 3 |</b> Subir cuadro de ítems, cantidades y valores, diligenciado</legend>
    </fieldset>

    <p>
        <?php echo form_input(array('type' => 'file', 'name' => 'userfile', 'style' => 'width: 400px')); ?>
    </p>

    <div align="center">
        <?php echo form_submit(array('id' => 'guardar', 'name' => 'guardar', 'style' => 'vertical-align: middle'), 'Guardar y subir'); ?>
        <?php echo form_input(array('type' => 'button', 'name' => 'volver', 'id' => 'volver', 'value' => 'Cancelar', 'onclick'=> "history.back()")); ?>
    </div>




</div>
<!-- Se cierra el formulario -->
<?php echo form_close(); ?>

<script type='text/javascript'>
    function descargar()
    {
        // Se ejecuta el informe
        window.location = "<?php echo base_url().'plantillas/items_cantidades_valores.xlsx'; ?>";
    } // generar_informe
</script>