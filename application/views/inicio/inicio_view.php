<div class="titulos_formularios">Listado de contratos</div><br>
<div id="form" class="container_11">
    <table cellpadding="0" cellspacing="0" border="" class="display" id="example" style="font-size: 13px;">
        <thead> 
            <tr style="text-align: center;"> 
                <th class="primero">Contrato</th> 
                <th>Estado</th> 
                <th>Valor</th> 
                <th>Contratista</th> 
                <th>Contratante</th> 
                <th>Centro de Costos</th> 
                <th>Fecha Inicial</th> 
                <th class="ultimo" >Opciones</th>
            </tr> 
        </thead> 
        <tbody>
            <?php
            /*
             * Se hace el recorrido para ubicar los datos de los contratos 
             * en la tabla
             */
            foreach ($contratos as $contrato):
                // print_r($contrato);
            ?>

            <tr>
                <td style="text-align: right"><?php echo $contrato->Numero; ?></td>
                <td><?php echo $contrato->Estado; ?></td>
                <td style="text-align: right"><?php echo '$ '.number_format($contrato->Valor_Inicial + $contrato->Valor_Adiciones,0,'','.'); ?></td>
                <td><?php echo substr($contrato->Contratista, 0, 22) ; ?></td>
                <td><?php echo substr($contrato->Contratante, 0, 22) ; ?></td>
                <td><?php echo substr($contrato->CentroCosto, 0, 22) ; ?></td>
                <td style="text-align: right;"><?php echo $contrato->Fecha_Inicial; ?></td>
                <td style="text-align: right">
                    <!-- Si tiene permiso -->
                    <?php if (isset($permisos[5])) { ?>
                        <a href="<?php echo site_url("contrato/ver/".$contrato->Pk_Id_Contrato); ?>" title="Ver contrato"><i class="glyphicon glyphicon-search fa-lg"></i></a>
                    <?php } ?>

                    <!-- Si tiene permiso -->
                    <?php if (isset($permisos[9])) { ?>
                        <a href="<?php echo site_url('actualizar/index/'.$contrato->Pk_Id_Contrato); ?>" title="Modificar contrato"><i class="glyphicon glyphicon-pencil fa-lg"></i></a>
                    <?php } ?>

                    <!-- Si tiene permiso -->
                    <?php if (isset($permisos[6])) { ?>
                        <a href="<?php echo site_url('bitacora/index/'.$contrato->Pk_Id_Contrato); ?>" title="Agregar bitácora"><i class="fa fa-book fa-lg"></i></a>
                    <?php } ?>

                    <!-- Si tiene permiso -->
                    <?php if (isset($permisos[7])) { ?>
                        <a href="<?php echo site_url('archivos/index/'.$contrato->Numero); ?>" title="Administrar archivos"><i class="glyphicon glyphicon-folder-open fa-lg"></i></a> 
                    <?php } ?>
                    <!-- Si tiene permiso -->
                    <?php if (isset($permisos[8])) { ?>
                        <a href="<?php echo site_url('pago/index/'.$contrato->Pk_Id_Contrato); ?>" title="Realizar pago"><i class="glyphicon glyphicon-usd fa-lg"></i></a>
                    <?php } ?>
                    
                    <!-- Si tiene permiso -->
                    <?php if (isset($permisos[17])) {
                        echo anchor(site_url('informes/acta_inicio/'.$contrato->Pk_Id_Contrato), img(array('src' => 'img/word.png', 'title' => 'Generar acta de inicio', 'width' => '25', 'height' => '25')));
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
            "stateSave": true,
        });
     });//Fin document.ready
</script>