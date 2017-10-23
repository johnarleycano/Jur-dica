<div id="form" class="container_12">
    <div class="grid_11">
        <div class="titulos_formularios">Listado de terceros</div><br>
        
        <!-- Si tiene permisos -->
        <?php if (isset($permisos[12])) { ?>
            <input type="button" value="Agregar tercero" style="float:right; margin-top: -50px;" onClick="javascript:crear_tercero()">
        <?php } ?>

        <table cellpadding="0" cellspacing="0" border="" class="display" id="example" style="font-size: 15px;">
            <thead>
                <tr>
                    <th class="primero">Tipo</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Tel&eacute;fono</th>
                    <th>Direcci&oacute;n</th>
                    <th>Representante legal</th>
                    <th class="ultimo">Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($terceros as $tercero): ?>
                <tr>
                    <td><?php echo $tercero->Tipo; ?></td>
                    <td><?php echo $tercero->Nombre; ?></td>
                    <td><?php echo $tercero->Documento; ?></td>
                    <td><?php echo $tercero->Telefono; ?></td>
                    <td><?php echo $tercero->Direccion; ?></td>
                    <td><?php echo $tercero->Representante_Legal; ?></td>
                    <td>
                        <?php
                        // Si tiene permiso
                        if (isset($permisos[16])) {
                            echo form_open('tercero/actualizar');
                            echo form_hidden('id_tercero', $tercero->Pk_Id_Terceros);
                            echo form_submit(array('type' => 'image', 'src' => base_url().'img/modificar.png', 'width' => '25', 'height' => '25'));
                            echo form_close();
                        }
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type='text/javascript'>
    function crear_tercero()
    {
        // Se ejecuta el informe
        window.location = "<?php echo site_url('tercero'); ?>";
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