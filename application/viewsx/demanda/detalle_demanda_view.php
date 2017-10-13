<?php
//Atributos de los botones de la vista
$volver = array('type' => 'button', 'name' => 'volver', 'id' => 'volver', 'value' => 'Atrás', 'onclick'=> 'history.back()');
$modificar = array('src' => 'img/modificar.png', 'title' => 'Modificar contrato', 'width' => '40', 'height' => '40');
$pago = array('src' => 'img/pago.png', 'title' => 'Realizar pago', 'width' => '40', 'height' => '40');
$bitacora = array('src' => 'img/bitacora.png', 'title' => 'Agregar bit&aacute;cora', 'width' => '40', 'height' => '40');
$acta_inicio = array('src' => 'img/word.png', 'title' => 'Generar acta de inicio', 'width' => '40', 'height' => '40');

/*
 * Se hace el recorrido para traer el resultado, que realmente es solo una fila:
 * La correspondiente al n&uacute;mero de la demanda seleccionada
 */
foreach ($demandas as $demanda):

?>
    <center>
        <!-- <b>Contrato N&uacute;mero <?php echo $contrato->Numero; ?></b> -->
    </center><br>
    <div class="ver">
        <!--Informacion del contratista-->
        <div class="info_contrato">
            <h3>Datos del Proceso</h3>
            <div>
                <h4>No. Radicado: </h4>
                <p><?php echo $demanda->radicado; ?></p>
            </div>
            <div>
                <h4>Despacho: </h4>
                <p><?php echo $demanda->Nombre; ?></p>
            </div>
            <div>
                <h4>Proceso: </h4>
                <p><?php echo $demanda->tipo_proceso; ?></p>
            </div>
            <div>
                <h4>Valor Pretencion: </h4>
                <p><?php echo '$ '.number_format($demanda->valor_pretension,0,'','.'); ?></p>
            </div>
        </div>

        <!--Informaci&oacute;n general-->
        <div class="info_contrato">
            <h3>Observacion Pretenciones</h3>
            <div>
                <!-- <h4>Objeto:</h4> -->
                <p><?php echo $demanda->observacion; ?></p>
            </div>
        </div>

        <div class="info_contrato">
            <h3>Asunto</h3>
            <div>
                <!-- <h4>Objeto:</h4> -->
                <p><?php echo $demanda->asunto; ?></p>
            </div>
        </div>

        <div class="info_contrato">
            <h3>Ultima Actuacion</h3>
            <div>
                <!-- <h4>Objeto:</h4> -->
                <p><?php echo $demanda->ultima_actuacion; ?></p>
            </div>
        </div>
        <div>
            <table width="100%">
                <tr>
                    <td>
                        <div class="info_contrato">
                            <h3>Pendiente</h3>
                            <div>
                                <!-- <h4>Objeto:</h4> -->
                                <p><?php echo $demanda->pendiente; ?></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="info_contrato">
                            <h3>Pronostico</h3>
                            <div>
                                <!-- <h4>Objeto:</h4> -->
                                <p><?php echo $demanda->pronostico; ?></p>
                            </div>
                        </div> 
                    </td>
                </tr>
            </table>
        </div>

        
    </div>
<?php endforeach; ?>

<?php 
echo form_fieldset('', 'class="fieldset" style="text-align: center"');
echo form_fieldset_close(); 

if($this->session->userdata('Tipo') == true){
?>
    <table width="100%">
        <tr>
            <td><?php echo form_input($volver); ?></td>
            <td>
<!--                 <?php
                echo anchor(site_url('actualizar/index/'.$contrato->Pk_Id_Contrato), img($modificar));
                echo anchor(site_url('pago/index/'.$contrato->Pk_Id_Contrato), img($pago));
                echo anchor(site_url('bitacora/index/'.$contrato->Pk_Id_Contrato), img($bitacora));
                echo anchor(site_url('archivos/index/'.$contrato->Numero), img(array('src' => 'img/archivos.png', 'title' => 'Administrar archivos', 'width' => '30', 'height' => '30')));
                echo anchor(site_url('informes/acta_inicio/'.$contrato->Pk_Id_Contrato), img($acta_inicio));
                ?>
 -->
                <a href="<?php echo site_url('demanda/detalle_demanda/'.$demanda->Pk_Id_Demandas); ?>" title="Detalle Demanda"><i class="glyphicon glyphicon-search fa-lg"></i></a>
                <a href="<?php echo site_url('actualizar_demanda/index/'.$demanda->Pk_Id_Demandas); ?>" title="Modificar Demanda"><i class="glyphicon glyphicon-pencil fa-lg"></i></a>
                <a href="<?php echo site_url(); ?>" title="Agregar bit&aacute;cora"><i class="fa fa-book fa-lg"></i></a>
                <a href="<?php echo site_url(); ?>" title="Administrar archivos"><i class="glyphicon glyphicon-folder-open fa-lg"></i></a>
            </td>
        </tr>
    </table>
<?php } ?>