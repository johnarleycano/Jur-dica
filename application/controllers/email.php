<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Controlador del m&oacute;dulo que env&iacute;a  correos electr&oacute;nicos.
 * @author 		John Arley Cano Salinas
 * @copyright	&copy; HATOVIAL S.A.S.
 */
Class Email extends CI_Controller{
    /**
    * Funci&oacute;n constructora de la clase email. 
    * 
    * Se hereda el mismo constructor de la clase Controller para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access	public
    */
    function __construct() {
        //con esta linea se hereda el constructor de la clase Controller
        parent::__construct();
        
        //Se cargan los modelos y librerías
        $this->load->model(array('email_model', 'contrato_model', 'pago_model', 'auditoria_model'));
        $this->load->library(array('email'));
    }//Fin construct()
    
    /**
     * Ejecuta los m&eacute;todos que env&iacute;n los correos.
     * 
     * @access	public
     */
    function index(){
        /*
         * Se llaman todos los métodos para que se invoque automáticamente
         * todos los correos desde solo un lugar
         */
        // $this->contratos_en_vencimiento();
        // $this->contratos_vencidos();
        // $this->polizas_en_vencimiento();
        // $this->polizas_vencidas();
        // $this->pagos_excedidos();
        // $this->no_acta_inicio();
    }//Fin index
    
    /**
     * Verifica los contratos que est&aacute;n a punto de vencerse.
     * 
     * @access	private
     */
    function contratos_en_vencimiento(){
        //Se carga el modelo que lista los contratos en vencimiento
        $contratos = $this->email_model->contratos_en_vencimiento();

        // Cuerpo
        $cuerpo = "";

        // Se recorren los contratos
        foreach($contratos as $contrato):
            $cuerpo .= "<fieldset style='border-color: #9FCB79'><legend style='border-color: #9FCB79'><b>Contrato $contrato->Numero ($contrato->Contratista)</b></legend>";
            $cuerpo .= "$contrato->Objeto<br>";
            $cuerpo .= "<b>Vence:</b> $contrato->Fecha_Vencimiento (faltan $contrato->Dias_Restantes días)<br>";
            $cuerpo .= "</fieldset><br>";
        endforeach;

        //Se define el asunto
        $asunto = "Contratos por vencerse";
        
        //Se verifica, si hay datos se env&iacute;a la tabla
        if(count($contratos) > 0){
            $mensaje = "Este es el listado de los contratos que están a punto de vencerse (próximos cinco días):<br> <p>$cuerpo</p>";
        }else{
            $mensaje = "A la fecha no hay contratos por vencerse dentro de los siguientes cinco días.<br>";
        } // if

        // Se consultan los usuarios a los que se le enviará el correo
        $usuarios = $this->auditoria_model->cargar_usuarios_correo(1);

        //Se ejecuta el modelo que envía el correo
        $this->email_model->enviar($usuarios, $asunto, $mensaje);

        //Mensaje de éxito
        echo 'El mensaje de contratos por vencerse se ha enviado correctamente<br/>';
    }//Fin contratos_en_vencimiento

    /**
     * Verifica los contratos que est&aacute;n vencidos.
     * 
     * @access	private
     */
    function contratos_vencidos(){
        //Se carga el modelo que trae los contratos vencidos
        $contratos = $this->email_model->contratos_vencidos();

        // Cuerpo
        $cuerpo = "";

        // Se recorren los contratos
        foreach($contratos as $contrato):
            $cuerpo .= "<fieldset style='border-color: #9FCB79'><legend style='border-color: #9FCB79'><b>Contrato $contrato->Numero ($contrato->Contratista)</b></legend>";
            $cuerpo .= "$contrato->Objeto<br>";
            $cuerpo .= "<b>Vencido desde:</b> $contrato->Fecha_Vencimiento ($contrato->Dias_Vencidos días)<br>";
            $cuerpo .= "</fieldset><br>";
        endforeach;

        //Se define el asunto
        $asunto = "Contratos vencidos";
        
        //Se verifica, si hay datos se env&iacute;a la tabla
        if(count($contratos) > 0){
            $mensaje = "Este es el listado de los contratos que están vencidos a la fecha:<br> <p>$cuerpo</p>";
        }else{
            $mensaje =  "A la fecha no hay contratos vencidos.<br>";
        }
        
        // Se consultan los usuarios a los que se le enviará el correo
        $usuarios = $this->auditoria_model->cargar_usuarios_correo(2);

        //Se ejecuta el modelo que envía el correo
        $this->email_model->enviar($usuarios, $asunto, $mensaje);
        
        //Mensaje de éxito
        echo 'El mensaje de contratos vencidos se ha enviado correctamente<br/>';
    }//Fin contratos_vencidos()
    
    /**
     * Verifica las p&oacute;lizas que est&eacute;n a punto de vencerse.
     * 
     * @access	private
     */
    function polizas_en_vencimiento(){
        //Se carga el modelo que se utilizar&aacute;
        $polizas = $this->email_model->polizas_en_vencimiento();

        // Cuerpo
        $cuerpo = "";
        
        // Recorrido de las pólizas
        foreach ($polizas as $poliza):
            $cuerpo .= "<fieldset style='border-color: #9FCB79'><legend style='border-color: #9FCB79'><b>Póliza de $poliza->Poliza_Tipo del contrato $poliza->Numero_Contrato ($poliza->Contratista)</b></legend>";
            $cuerpo .= "$poliza->Objeto<br>";
            $cuerpo .= "<b>Vence:</b> $poliza->Fecha_Vencimiento (faltan $poliza->Dias_Restantes días)<br>";
            $cuerpo .= "</fieldset><br>";
        endforeach;

        //Se define el asunto
        $asunto = "Pólizas por vencerse";
        
        //Se verifica, si hay datos se env&iacute;a la tabla
        if(count($polizas) > 0){
            $mensaje = "Este es el listado de las pólizas que están a punto de vencerse (próximos cinco días):<br> <p>$cuerpo</p>";
        }else{
            $mensaje = "A la fecha no hay pólizas por vencerse dentro de los siguientes cinco días.<br>";
        } // if
        
        // Se consultan los usuarios a los que se le enviará el correo
        $usuarios = $this->auditoria_model->cargar_usuarios_correo(3);

        //Se ejecuta el modelo que envía el correo
        $this->email_model->enviar($usuarios, $asunto, $mensaje);
        
        //Mensaje de &eacute;xito
        echo 'El mensaje de p&oacute;lizas por vencerse se ha enviado correctamente<br/>';
    }//Fin polizas_en_vencimiento()
    
    /**
     * Verifica las p&oacute;lizas que est&eacute;n vencidas.
     * 
     * @access	private
     */
    function polizas_vencidas(){
        //Se carga el modelo que se utilizar&aacute;
        $polizas = $this->email_model->polizas_vencidas();
        
        // Cuerpo
        $cuerpo = "";

        // Recorrido de las pólizas
        foreach ($polizas as $poliza):
            $cuerpo .= "<fieldset style='border-color: #9FCB79'><legend style='border-color: #9FCB79'><b>Póliza de $poliza->Poliza_Tipo del contrato $poliza->Numero_Contrato ($poliza->Contratista)</b></legend>";
            $cuerpo .= "$poliza->Objeto<br>";
            $cuerpo .= "<b>Vencido desde:</b> $poliza->Fecha_Vencimiento ($poliza->Dias_Vencidos días)<br>";
            $cuerpo .= "</fieldset><br>";
        endforeach;

        //Se define el asunto
        $asunto = "Pólizas vencidas";

        //Se verifica, si hay datos se env&iacute;a la tabla
        if(count($polizas) > 0){
            $mensaje = "Este es el listado de las pólizas que están vencidas a la fecha:<br> <p>$cuerpo</p>";
        }else{
            $mensaje =  "A la fecha no hay pólizas vencidas.<br>";
        }

        // Se consultan los usuarios a los que se le enviará el correo
        $usuarios = $this->auditoria_model->cargar_usuarios_correo(4);

        //Se ejecuta el modelo que envía el correo
        $this->email_model->enviar($usuarios, $asunto, $mensaje);
        
        //Mensaje de &eacute;xito
        echo 'El mensaje de p&oacute;lizas vencidas se ha enviado correctamente<br/>';
    }//Fin polizas_vencidas()
    
    /**
     * Verifica los contratos que tengan pagos mayores al valor del contrato.
     * 
     * @access	private
     */
    function pagos_excedidos(){
        //Se carga el modelo
        $pagos = $this->pago_model->pagos_excedidos();

        // Cuerpo
        $cuerpo = "";

        // Se recorren los pagos
        foreach ($pagos as $pago):
            // Si el pago es excedido
            if($pago->Excedido > 0){
                $cuerpo .= "<fieldset style='border-color: #9FCB79'><legend style='border-color: #9FCB79'><b>Contrato $pago->Numero_Contrato ($pago->Contratista)</b> </legend>";
                $cuerpo .= "$pago->Objeto<br>";
                $cuerpo .= "<b>Total:</b> $".number_format($pago->Valor_Total, 0, '', '.')." | <b>Pagado:</b> $".number_format($pago->Pagado, 0, '', '.')." | <span style='color: red;'>Excedido en <b>$".number_format($pago->Excedido, 0, '', '.')."</b></span><br>";
                $cuerpo .= "</fieldset><br>";
            } // if
        endforeach;

        //Se define el asunto
        $asunto = "Pagos excedidos a contratos";

        //Se verifica, si hay datos se envían
        if(count($pagos) > 0){
            $mensaje = "Este es el listado de los contratos que tienen pagos que van por encima de su valor y aun no han sido liquidados:<br> <p>$cuerpo</p>";
        }else{
            $mensaje = "A la fecha no hay ningún pago que exceda el valor de un contrato.<br>";
        } // if

        // Se consultan los usuarios a los que se le enviará el correo
        $usuarios = $this->auditoria_model->cargar_usuarios_correo(5);

        //Se ejecuta el modelo que envía el correo
        $this->email_model->enviar($usuarios, $asunto, $mensaje);

        //Mensaje de &eacute;xito
        echo 'El mensaje de pagos excedidos a contratos se ha enviado correctamente<br/>';
    }//Fin pagos_excedidos
    
    /**
     * Verifica los contratos que No tienen acta de inicio
     * 
     * @access	public
     */
    function no_acta_inicio(){
        //Se carga el modelo
        $contratos = $this->email_model->no_acta_inicio();

        // Cuerpo
        $cuerpo = "";

        // Se recorren los contratos
        foreach($contratos as $contrato):
            $cuerpo .= "<fieldset style='border-color: #9FCB79'><legend style='border-color: #9FCB79'><b>Contrato $contrato->Numero ($contrato->Contratista)</b></legend>";
            $cuerpo .= "$contrato->Objeto<br>";
            $cuerpo .= "<b>Inicia:</b> $contrato->Fecha_Inicial | <b>Finaliza:</b> $contrato->Fecha_Vencimiento";
            $cuerpo .= "</fieldset><br><br>";
        endforeach;

        //Se define el asunto
        $asunto = "Contratos sin acta de inicio";

        //Se verifica, si hay datos se env&iacute;a la tabla
        if(count($contratos) > 0){
            $mensaje = "Este es el listado de los contratos que no tienen acta de inicio:<br> <p>$cuerpo</p>";
        }else{
            $mensaje = "A la fecha no hay contratos sin acta de inicio.<br>";
        } // if

        // Se consultan los usuarios a los que se le enviará el correo
        $usuarios = $this->auditoria_model->cargar_usuarios_correo(6);

        //Se ejecuta el modelo que envía el correo
        $this->email_model->enviar($usuarios, $asunto, $mensaje);
        
        //Mensaje de &eacute;xito
        echo 'El mensaje de contratos sin acta de inicio se ha enviado correctamente<br/>';
    }//Fin no_acta_inicio
}//Fin email
/* End of file email.php */
/* Location: ./contratos/application/controllers/email.php */