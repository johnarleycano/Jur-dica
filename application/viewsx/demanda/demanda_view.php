            <?php 
//Atributos para el fieldset
$fieldset = array('id' => 'fieldset', 'class' => 'fieldset');

//Se inicia el formulario
echo form_open('demanda/agregar_demanda');
?>

<div id="form" class="container_11">
    <div class="titulos_formularios">Registro de Demandas</div>
    
    <!--Errores de validaci&oacute;n-->
    <span class="error">
        <?php 
        echo form_error('radicado_proceso');
        echo form_error('tribunal_juzgado');
        echo form_error('tipo_proceso');
        echo form_error('asunto');
        echo form_error('valor_pretenciones');
        ?>
    </span>
    
    <div id="accordion">
        <!--Seccion 1-->
        <h3><a href="#seccion1">DATOS GENERALES</a></h3>
        <div>
            <table width="100%">
                <tr>
                    <td><?php echo form_label('Numero de Radicado*', 'radicado_proceso'); ?></td>
                    <td><?php echo form_input(array('name' => 'radicado_proceso', 'id' => 'radicado_proceso', 'style' => 'text-align: right', 'value' => set_value('radicado_proceso'))) ?></td>
                </tr>

                <?php 
                $_tipoproceso = array('' => null);
                //Recorrido para traer todos los estados de la base de datos y agregarlos en el dropdown
                foreach ($tipoprocesos as $tipoproceso):
                    $_tipoproceso[$tipoproceso->Pk_Id_tipo_proceso] = $tipoproceso->tipo_proceso;
                endforeach; 
                ?>      

                <tr>
                    <td><?php echo form_label('Tipo de Proceso*', 'tipoprocesos'); ?></td>
                    <td><?php echo form_dropdown('tipoprocesos', $_tipoproceso); ?></td>
                </tr>

                <?php 
                $_juzgados = array('' => null);
                //Recorrido para traer todos los estados de la base de datos y agregarlos en el dropdown
                foreach ($juzgados as $juzgado):
                    $_juzgados[$juzgado->Pk_Id_Terceros] = $juzgado->Nombre;
                endforeach; 
                ?>
                <tr>
                    <td><?php echo form_label('Tribunal - Juzgado*', 'juzgados'); ?></td>
                    <td><?php echo form_dropdown('juzgados', $_juzgados); ?></td>
                </tr>
                <tr>
                    <td><?php echo form_label('Valor Pretenciones*', 'valor_pretenciones'); ?></td>
                    <td><?php echo form_input(array('name' => 'valor_pretenciones', 'id' => 'valor_pretenciones', 'style' => 'text-align: right', 'value' => set_value('valor_pretenciones'))) ?></td>
                </tr>
                <tr>
                    <td><?php echo form_label('Observacion Pretenciones*', 'observacion'); ?></td>
                    <td></td>                    
                </tr>
                <tr>
                    <td colspan="3"><?php echo form_textarea(array('class' => 'textarea_actualizar2','name' => 'observacion', 'id' => 'observacion', 'value' => set_value('observacion'))); ?></td>
                </tr>                
                <tr>
                    <td><?php echo form_label('Asunto*', 'asunto'); ?></td>
                </tr>
                <tr>
                    <td colspan="3"><?php echo form_textarea(array('class' => 'textarea_actualizar2','name' => 'asunto', 'id' => 'asunto', 'value' => set_value('asunto'))); ?></td>
                </tr>
                
                
                <tr>
                    <td><?php echo form_label('Ultima Actuacion*', 'ultima_actuacion'); ?></td>
                    <td></td>                    
                </tr>
                <tr>
                    <td colspan="3"><?php echo form_textarea(array('class' => 'textarea_actualizar2', 'name' => 'ultima_actuacion', 'id' => 'asunto', 'value' => set_value('ultima_actuacion'))); ?></td>
                </tr>
                <tr>
                    <td><?php echo form_label('Pendiente*', 'pendiente'); ?></td>
                    <td></td>                    
                </tr>
                <tr>
                    <td colspan="3"><?php echo form_textarea(array('class' => 'textarea_actualizar2', 'name' => 'pendiente', 'id' => 'pendiente', 'value' => set_value('pendiente'))); ?></td>
                </tr>
                <tr>
                    <td><?php echo form_label('Pronostico*', 'pronostico'); ?></td>
                    <td></td>                    
                </tr>
                <tr>
                    <td colspan="3"><?php echo form_textarea(array('class' => 'textarea_actualizar2', 'name' => 'pronostico', 'id' => 'pronostico', 'value' => set_value('pronostico'))); ?></td>
                </tr>       
            </table>
        </div>
        <?php echo form_fieldset_close(); ?>
    </div><br>
    <div align="center">
        <?php
        echo form_submit(array( 'name' => 'guardar', 'id' => 'guardar', 'value' => 'Guardar'));
        echo form_input(array('type' => 'button', 'name' => 'volver', 'id' => 'volver', 'value' => 'Cancelar', 'onclick'=> "history.back()"));
        ?>
    </div>
    <?php 
    //Se cierra el formulario
    echo form_close();
    ?>
</div>