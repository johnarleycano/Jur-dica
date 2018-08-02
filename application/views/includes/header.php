        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>  
        <title><?php echo $titulo;?></title>
        
        <!-- estilos -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/estilos.css" media="screen"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/smoothness/jquery-ui-1.8.24.custom.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.ui.timepicker.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/960.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/text.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/reset.css" media="screen"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/datatables.css" type="text/css" />

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->


        <!-- icono -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url(); ?>img/favicon.ico" type="image/x-icon">
        <link type="text/css" href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">

        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.0.min.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.form.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.core.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.button.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.accordion.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.timepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.mouse.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.draggable.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.position.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.dialog.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.resizable.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.effects.core.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.bgiframe-2.1.2.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/datatables.js"></script>
        <script src="<?php echo base_url(); ?>js/funciones.js"></script>

        <div class="container_12">
            <div id="titulo_logo">Sistema de <br>Administración Jurídica</div>

            <?php
            $proyecto = $this->auditoria_model->cargar_proyecto($this->session->userdata("Fk_Id_Proyecto"));
            ?>
            <center>
                <img src="<?php echo base_url().'img/'.$proyecto->Logo; ?>" style="width: 120px; float: right; margin-right: 20px;">
            </center>
            <div>
            <!-- Ventana de mensajes --> 
                <?php if (isset($mensaje_info)) { ?> 
                    <div class="info"> 
                        <?php echo $mensaje_info; ?> 
                    </div>
                <?php
                }
                if(isset($mensaje_exito)){ ?>
                    <div class="exito"> 
                        <?php echo $mensaje_exito; ?> 
                    </div>
                <?php
                }
                if(isset($mensaje_alerta)){ ?>
                    <div class="alerta"> 
                        <?php echo $mensaje_alerta; ?> 
                    </div>
                <?php
                }
                if(isset($mensaje_error)){ ?>
                    <div class="errores"> 
                        <?php echo $mensaje_error; ?> 
                    </div>
                <?php
                }
                ?>
            <!-- FIN Mensajes -->
            </div>
            <div class="clear" ></div>

            <?php
            //Si el usuario no est&aacute; logueado, no se activa el men&uacute;
            if ($this->session->userdata('Usuario') == TRUE){ ?>

            <!---Menu principal-->
            <div id="menu">
                <div id="menu-left"></div>
                <div id="menu">
                    <ul>
                        <li><a href="<?php echo site_url('inicio'); ?>"><span>Contratos</span></a>
                            <ul class="menuDrpDwn">
                                <!-- Si tiene permiso -->
                                <?php if (isset($permisos[1])) { ?>
                                    <li><a href="<?php echo site_url('contrato'); ?>">Nuevo</a></li>
                                <?php } ?>

                                <li><a href="<?php echo site_url('liquidacion'); ?>">Liquidar</a></li>
                            </ul>
                        </li>
                        <!-- <li><a href="<?php // echo site_url('inicio_demanda'); ?>"><span>Demandas</span></a>
                            <ul class="menuDrpDwn">
                                <li><a href="<?php // echo site_url('demanda'); ?>">Nuevo</a></li>
                            </ul>
                        </li>
                        <li><a href=""><span>Terceros</span></a>
                            <ul class="menuDrpDwn">
                                <li><a href="<?php // echo site_url('tercero'); ?>">Agregar</a></li>
                                <li><a href="<?php // echo site_url('tercero/ver'); ?>">Ver</a></li>                   
                            </ul>
                        </li>
                         -->

                        <!-- Si tiene permiso -->
                        <?php if (isset($permisos[31])) { ?>

                            <li><a href="<?php echo site_url('contrato/ver_solicitudes'); ?>"><span>Solicitudes</span></a>
                                <ul class="menuDrpDwn">
                                    <!-- Si tiene permiso -->
                                    <?php if (isset($permisos[30])) { ?>
                                        <li><a href="<?php echo site_url('contrato/solicitar'); ?>">Solicitar contrato</a></li>
                                    <?php } ?>

                                    <!-- Si tiene permiso -->
                                    <?php if (isset($permisos[31])) { ?>
                                        <li><a href="<?php echo site_url('contrato/ver_solicitudes'); ?>">ver solicitudes</a></li>
                                    <?php } ?>
                                </ul> 
                            </li>
                        <?php } ?>

                        <li>
                            <a href="#"><span>Administración</span></a>
                            <ul class="menuDrpDwn">
                                <!-- Si tiene permiso -->
                                <?php if (isset($permisos[13])) { ?>
                                    <li><a href="<?php echo site_url('auditoria'); ?>">Auditoría</a></li>
                                <?php } ?>

                                <!-- Si tiene permiso -->
                                <?php if (isset($permisos[15])) { ?>
                                    <li><a href="<?php echo site_url('tercero/ver'); ?>">Terceros</a></li>
                                <?php } ?>

                                <!-- Si tiene permiso -->
                                <?php if (isset($permisos[14])) { ?>
                                    <li><a href="<?php echo site_url('usuario/ver'); ?>">Usuarios</a></li>
                                    <!-- <li><a href="<?php // echo site_url('usuario'); ?>">Usuarios</a></li> -->
                                <?php } ?>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="<?php echo site_url('informes'); ?>"><span>Informes</span></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('sesion/cerrar_sesion'); ?>"><span>Cerrar sesi&oacute;n (<?php echo $this->session->userdata('Usuario'); ?>)</span></a>
                        </li>
                    </ul>
                </div>
                <div id="menu-left"></div>
                <div class="clear"></div>
            </div>
            <?php } ?>
        </div>
        <script type='text/javascript'>
            //Estas acciones se realizarán cuando el DOM esté listo
            $(document).ready(function(){
                /************************Scripts que permiten manejar el men&uacute;************************/
                $('#menu li').hover(function (){
                    $(this).addClass('selected');
                    $(this).find('ul:first').slideDown();
                },

                function (){
                    $(this).removeClass('selected');
                    $(this).find('ul.menuDrpDwn').hide();
                });

                $('.menuDrpDwn li').hover(function (){
                    $(this).find('ul:first').show('slide',{direction: 'left'}, 10000);
                },

                function (){
                    $(this).find('ul').hide();
                });
                /************************Fin men&uacute;************************/

                /************************Estilo de los botones************************/ 
                $( "#form input[type=submit], #form input[type=button], #form input[type=file] .boton, #volver").button();

                /************************Accordion************************/
                $( "#accordion" ).accordion ({
                    autoHeight: false,
                    navigation: true
                });

                /************************Fechas************************/
                $('#fecha_inicial, #vencimiento, #fecha_acta, #inicio_cumplimiento, #vencimiento_cumplimiento, #inicio_prestaciones, #vencimiento_prestaciones,\n\
                    #inicio_anticipos, #vencimiento_anticipos, #inicio_calidad, #vencimiento_calidad, #inicio_estabilidad, #vencimiento_estabilidad, #fecha_pago, #fecha_suspension, \n\
                    #inicio_rc, #vencimiento_rc, #fecha1, #fecha2, #fecha3, #fecha4').datepicker({
                    dateFormat : 'yy-mm-dd',
                    showAnim : 'slideDown',
                    showOn: "button",
                    buttonImage: "<?php  echo base_url()?>/img/calendario.png",
                    buttonImageOnly: true,
                    autoSize: false,

                    //Se modifican los nombres y abreviatura de los meses
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado'],
                    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                    dayNamesMin: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
                    weekHeader: 'Sm'
                });

                /************************Horario************************/
                $('#form input[name^=hora]').timepicker({
                    showLeadingZero: true,
                    showPeriod: true,
                    hourText: 'Hora',
                    minuteText: 'Minuto',
                    amPmText: ['AM', 'PM'],
                    showNowButton: true,
                    nowButtonText: 'En este momento',
                    showDeselectButton: false,
                    deselectButtonText: 'Borrar selección'
                });
                
                /************************Este script establece el efecto para los mensajes de error, de informacion, de alerta y de exito************************/
                setTimeout(function(){
                    $(".info, .errores, .exito, .alerta").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);
                }, 3000);
            });
        </script>