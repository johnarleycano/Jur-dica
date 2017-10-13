<div id="form" class="container_11">
    <div class="titulos_formularios">Listado de Demandas</div><br>
    <table cellpadding="0" cellspacing="0" border="" class="display" id="example" style="font-size: 13px;">
          
        <thead> 
            <tr style="text-align: center;"> 
                <th class="primero">Radicado</th> 
                <th>Proceso</th> 
                <th>Despacho</th> 
                <!-- <th>Asunto</th>  -->
                <th>Vr. Pretencion</th> 
                <!-- <th>Ultima Actuacion</th>  -->
                <!-- <th>Pendiente</th>  -->
                <!-- <th>Pronostico</th>  -->
                <th class="ultimo" >Acciones</th>
<!--                 <th class="ultimo" >.</th>
                <th class="ultimo" >.</th> -->


            </tr> 
        </thead> 
        <tbody>
            <?php
            /*
             * Se hace el recorrido para ubicar los datos de los contratos 
             * en la tabla
             */
            foreach ($demandas as $demanda):
            ?>
            <tr>
                <td style="text-align: right"><?php echo $demanda->radicado; ?></td>
                <td><?php echo $demanda->Proceso; ?></td>
                <td><?php echo $demanda->Juzgado; ?></td>
                <!-- <td><?php echo $demanda->asunto; ?></td> -->
                <td style="text-align: right"><?php echo '$ '.number_format($demanda->Pretencion,0,'','.'); ?></td>
                <!-- <td><?php echo $demanda->Actuacion; ?></td> -->
                <!-- <td><?php echo $demanda->pendiente; ?></td> -->
                <!-- <td><?php echo $demanda->pronostico; ?></td> -->
                <td style="text-align: right">

                    <a href="<?php echo site_url('demanda/detalle_demanda/'.$demanda->Pk_Id_Demandas); ?>" title="Detalle Demanda"><i class="glyphicon glyphicon-search fa-lg"></i></a>
                    <?php
                        if($this->session->userdata('Tipo') == 1){?>

                            <a href="<?php echo site_url('actualizar_demanda/index/'.$demanda->Pk_Id_Demandas); ?>" title="Modificar Demanda"><i class="glyphicon glyphicon-pencil fa-lg"></i></a>
                            <a href="<?php echo site_url('bitacora_demanda/index/'.$demanda->Pk_Id_Demandas); ?>" title="Agregar bit&aacute;cora"><i class="fa fa-book fa-lg"></i></a>
                            <a href="<?php ?>" title="Administrar archivos"><i class="glyphicon glyphicon-folder-open fa-lg"></i></a>

                            <?php
                        }
                    ?>
                    
                    
                </td>
            </tr>
            <?php endforeach; ?>
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

            //Este script establece un orden por cierta columna
            "aaSorting": [[ 0, "asc" ]]
        });
     });//Fin document.ready
</script>