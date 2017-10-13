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
    <div class="grid_1"><hr class="vertical"/></div><!--div central-->
    <div class="grid_5, titulos_login" align="center">Sistema para la Administracion <br>Juridica</div><!--lateral derecho-->  
    <div id="logo-login"></div>  
</div>
<script type="text/javascript">
    //Cuando el DOM este listo
    $(document).ready(function(){
        //Se establece el foco del campo
        $("#usuario").focus();
    });//Fin document.ready
</script>

