<?php
foreach ($demandas as $demanda):
    
//Seccion 1
$fieldset = array('id' => 'fieldset', 'class' => 'fieldset');
 
echo form_open('actualizar_demanda/demanda/'.$demanda->Pk_Id_Demandas);
?>

<div class="container_12" id="form">
    <div class="titulos_formularios">Modificaci&oacute;n Demanda</div>
    
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

                <?php
                    //Con un campo oculto obtenemos el id de la demanda
                    echo form_hidden('id_demanda', $demanda->Pk_Id_Demandas);
                ?>
                <tr>
                    <td><?php echo form_label('Numero de Radicado*', 'radicado_proceso'); ?></td>
                    <td><?php echo form_input(array('name' => 'radicado_proceso', 'id' => 'radicado_proceso', 'style' => 'text-align: right', 'readonly' => 'readonly'), $demanda->radicado) ?></td>
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
                    <td><?php echo form_dropdown('tipoprocesos', $_tipoproceso, set_value('tipoprocesos', $demanda->Pk_Id_tipo_proceso)); ?></td>
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
                    <td><?php echo form_dropdown('juzgados', $_juzgados, set_value('juzgados', $demanda->Pk_Id_Terceros));?></td>

                </tr>
                <tr>
                    <td><?php echo form_label('Valor Pretenciones*', 'valor_pretenciones'); ?></td>
                    <td><?php echo form_input(array('name' => 'valor_pretenciones', 'id' => 'valor_pretenciones', 'style' => 'text-align: right', 'value' => set_value('valor_pretenciones', $demanda->valor_pretension))) ?></td>
                </tr>
                <tr>
                    <td><?php echo form_label('Observacion Pretenciones*', 'observacion'); ?></td>
                    <td></td>                    
                </tr>
                <tr>
                    <td colspan="3"><?php echo form_textarea (array('class' => 'textarea_actualizar2', 'name' => 'observacion', 'id' => 'observacion', 'value' => set_value('observacion', $demanda->observacion))); ?></td>
                </tr>

                <tr>
                    <td><?php echo form_label('Asunto*', 'asunto'); ?></td>
                </tr>
                <tr>
                    <td colspan="3"><?php echo form_textarea(array('class' => 'textarea_actualizar2','name' => 'asunto', 'id' => 'asunto', 'value' => set_value('asunto', $demanda->asunto))); ?></td>
                </tr>                
               
                <tr>
                    <td><?php echo form_label('Ultima Actuacion*', 'ultima_actuacion'); ?></td>
                    <td></td>                    
                </tr>
                <tr>
                    <td colspan="3"><?php echo form_textarea(array('class' => 'textarea_actualizar2','name' => 'ultima_actuacion', 'id' => 'asunto', 'value' => set_value('ultima_actuacion', $demanda->ultima_actuacion))); ?></td>
                </tr>
                <tr>
                    <td><?php echo form_label('Pendiente*', 'pendiente'); ?></td>
                    <td></td>                    
                </tr>
                <tr>
                    <td colspan="3"><?php echo form_textarea(array('class' => 'textarea_actualizar2','name' => 'pendiente', 'id' => 'pendiente', 'value' => set_value('pendiente', $demanda->pendiente))); ?></td>
                </tr>
                <tr>
                    <td><?php echo form_label('Pronostico*', 'pronostico'); ?></td>
                    <td></td>                    
                </tr>
                <tr>
                    <td colspan="3"><?php echo form_textarea(array('class' => 'textarea_actualizar2','name' => 'pronostico', 'id' => 'pronostico', 'value' => set_value('pronostico', $demanda->pronostico))); ?></td>
                </tr>       
            </table>
        </div> 
    </div><br>

    <div align="center">
        <?php
        echo form_submit($guardar = array('id' => 'guardar', 'name' => 'guardar'), 'Guardar');
        echo form_input($volver = array('type' => 'button', 'name' => 'volver', 'id' => 'volver', 'value' => 'Cancelar', 'onclick'=> 'history.back()'))
        ?>
    </div>
</div>
<?php endforeach; ?>
<?php echo form_close(); ?>
