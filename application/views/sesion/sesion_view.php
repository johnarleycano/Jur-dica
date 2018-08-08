<?php
//Se inicia el formulario
echo form_open('sesion/validar_login');
?>
<div class="container_12"></div>

<div class="container_12">    
    <div class="grid_6" id="izquierda">
    <div class="titulos_formularios">Bienvenido</div><br>
        <div id="form" align="center">
            <table width="70%">
                <tr>
                    <th><?php echo form_label('Nombre de usuario'); ?></th>
                    <td>
                        <div style="alignment-adjust: right">
                            <?php echo form_input(array('name' => 'usuario', 'id' => 'usuario', 'value' => set_value('usuario'))); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="error"><?php echo form_error('usuario'); ?></td>
                </tr>
                <tr>
                    <th><?php echo form_label('Contrase&ntilde;a&nbsp;'); ?></th>
                    <td>
                        <div>
                            <?php echo form_password(array('name' => 'password', 'id' => 'password', 'value' => '')); ?>
                        </div>
                    </td>
                </tr>
                <tr class="error">
                    <td colspan="2"><?php echo form_error('password'); ?></td>
                </tr>
                <tr>
                    <th><?php echo form_label('Proyecto'); ?></th>
                    <td>
                        <div style="alignment-adjust: right">
                            <select id="select_proyecto" name="proyecto" class="form-control" style="width: 85%;">
                                <option value=""></option>
                                <?php foreach ($this->auditoria_model->cargar_proyectos() as $proyecto) { ?>
                                    <option value="<?php echo $proyecto->Pk_Id; ?>"><?php echo $proyecto->Nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="error"><?php echo form_error('proyecto'); ?></td>
                </tr>
                <tr style="alignment-adjust: center">  
                    <td colspan="2">
                        <center><?php echo form_submit(array('name' => 'submit', 'id' => 'submit', 'value' => 'Ingresar')); ?></center><br>
                    </td>
                </tr>
            </table>
            <?php
            //Se cierra o finaliza el formulario
            echo form_close();
            ?>
        </div>
    </div><!--lateral izquierdo-->
    <div class="grid_1"><hr class="vertical"/></div>
    <div class="grid_5, titulos_login" align="center">Sistema de Administración <br>Jurídica</div> 
    <center>
        <img style="width: 200px; text-align: center;">
    </center>
</div>
<script type="text/javascript">
    //Cuando el DOM este listo
    $(document).ready(function(){
        //Se establece el foco del campo
        $("#usuario").focus()

        $("#select_proyecto").on("change", function(){
            proyecto = ajax("<?php echo site_url('sesion/cargar_proyecto') ?>", {"id_proyecto": $(this).val()}, "JSON")
            
            $("img").attr("src", `<?php echo base_url(); ?>img/${proyecto.Logo}`)
        })
    })
</script>

