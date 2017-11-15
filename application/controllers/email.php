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
        $this->contratos_pendientes_por_crearse();
        // $this->contratos_pendientes_devolucion_retenido();
        // $this->polizas_en_vencimiento();
        // $this->polizas_vencidas();
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
    function contratos_pendientes_devolucion_retenido(){
        //Se carga el modelo que trae los contratos pendientes por devolución de retenido
        $contratos = $this->email_model->contratos_pendientes_devolucion_retenido();

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
        $asunto = "Contratos pendientes por devolución de retenido";
        
        //Se verifica, si hay datos se env&iacute;a la tabla
        if(count($contratos) > 0){
            $mensaje = "Este es el listado de los contratos que están pendientes por devolución de retenido a la fecha:<br> <p>$cuerpo</p>";
        }else{
            $mensaje =  "A la fecha no hay contratos pendientes por devolución de retenido.<br>";
        }
        
        // Se consultan los usuarios a los que se le enviará el correo
        $usuarios = $this->auditoria_model->cargar_usuarios_correo(2);

        //Se ejecuta el modelo que envía el correo
        $this->email_model->enviar($usuarios, $asunto, $mensaje);
        
        //Mensaje de éxito
        echo 'El mensaje de contratos pendientes por devolución de retenido se ha enviado correctamente<br/>';
    }//Fin contratos_pendientes_devolucion_retenido()
    
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
     * Verifica las solicitudes de contratos que aún no están
     * asociadas a ningún contrato.
     * 
     * @access  private
     */
    function contratos_pendientes_por_crearse(){
        $solicitudes = $this->email_model->solicitudes_pendientes();

        // Cuerpo
        $cuerpo = "";

        // Se recorren las solicitudes
        foreach($solicitudes as $solicitud):
            $cuerpo .= "<fieldset style='border-color: #9FCB79'><legend style='border-color: #9FCB79'><b>Solicitud $solicitud->Pk_Id_Contrato_Solicitud (Por $solicitud->Solicitante)</b></legend>";
            $cuerpo .= "<b>Contratista:</b> $solicitud->Contratista<br>";
            $cuerpo .= "$solicitud->Objeto<br>";
            $cuerpo .= "<b>Inicia:</b> $solicitud->Fecha_Inicial | <b>Valor:</b> $".number_format($solicitud->Valor_Inicial, 0, '', '.')."<br>";
            $cuerpo .= "</fieldset><br>";
        endforeach;
        
        // Se define el asunto
        $asunto = "Contratos pendientes por crearse";

        // Se verifica, si hay datos se envía la tabla
        if(count($solicitudes) > 0){
            $mensaje = "Este es el listado de solicitudes que aún no han sido creadas como contratos en el sistema:<br> <p>$cuerpo</p>";
        }else{
            $mensaje = "A la fecha no hay contratos pendientes por crearse.<br>";
        } // if

        // Se consultan los usuarios a los que se le enviará el correo
        $usuarios = $this->auditoria_model->cargar_usuarios_correo(9);

        //Se ejecuta el modelo que envía el correo
        $this->email_model->enviar($usuarios, $asunto, $mensaje);

        //Mensaje de éxito
        echo 'El mensaje de contratos pendientes por crearse se ha enviado correctamente<br/>';
    } // contratos_pendientes_por_crearse
}//Fin email
/* End of file email.php */
/* Location: ./contratos/application/controllers/email.php */