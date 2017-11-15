<?php
/**
 * Modelo que se encarga de enviar los correos electr&oacute;nicos
 * @author 		John Arley Cano Salinas
 * @copyright	&copy;  HATOVIAL S.A.S.
 */
Class Email_model extends CI_Model{
    var $configuracion_web = array(
        'protocol' => 'smtp',
        'smtp_host' => 'mail.devimed.com.co',
        // 'smtp_port' => 465,
        'smtp_user' => 'notificacion.contratos',
        'smtp_pass' => 'd3v1m3d*',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
    );

    var $nombre = 'Notificación - Devimed S.A.';

    /**
     * Envío de correo electrónico
     * previamente formateado
     */
    function enviar($destinatarios, $asunto, $cuerpo, $opciones = Null)
    {
        // Si estamos en la app web
        if ($this->config->item("id_aplicacion") == "web") {
            //cargamos la configuración local para enviar con gmail
            $this->email->initialize($this->configuracion_web);

            $correo_sistema = 'notificacion.contratos@devimed.com.co';

            // Destinatarios
            $usuarios = $destinatarios;
        } // if

        // Si estamos en la app local
        if ($this->config->item("id_aplicacion") == "local") {
            //cargamos la configuración local para enviar con gmail
            $this->email->initialize($this->configuracion_web);

            $correo_sistema = 'notificacion.contratos@devimed.com.co';

            // Destinatarios
            $usuarios = "johnarleycano@hotmail.com";
        } // if

        // Preparando el mensaje
        $this->email->from($correo_sistema, $this->nombre); // Cabecera
        $this->email->to($usuarios); // Destinatarios
        $this->email->subject($asunto); // Asunto
        $this->email->bcc(array('john.cano@devimed.com.co')); // Copia oculta

        // Si trae adjunto
        if ($opciones["adjunto"]) {
            $this->email->attach($opciones["adjunto"]); // Adjunto
        }

        //Se organiza la plantilla
        $mensaje = file_get_contents('application/views/email/plantilla.html');
        $mensaje = str_replace('{MENSAJE}', $cuerpo, $mensaje);
        $this->email->message($mensaje);

        // Envío del mensaje
        return $this->email->send();
    } // enviar

    /**
    * Env&iacute;a los correos electr&oacute;nicos
    * 
    * @access	private
    */
    function contratos_en_vencimiento(){
        $sql = 
        "SELECT
            c.Numero,
            t.Nombre AS Contratista,
            c.Objeto,
            c.Fecha_Vencimiento,
            c.Fecha_Vencimiento - CURDATE( ) AS Dias_Restantes 
        FROM
            contratos AS c
            INNER JOIN tbl_terceros AS t ON c.Fk_Id_Terceros = t.Pk_Id_Terceros 
        WHERE
            ( ( c.Fecha_Vencimiento - CURDATE( ) ) BETWEEN 0 AND 15 ) 
        ORDER BY
            c.Fecha_Vencimiento ASC";
        
        //Se retorna la consulta
        return $this->db->query($sql)->result(); 
    }//Fin contratos_en_vencimiento

    /**
    * Env&iacute;a los correos electr&oacute;nicos
    * 
    * @access	private
    */
    function contratos_pendientes_devolucion_retenido(){
        $sql = 
        'SELECT
            c.Numero,
            c.Objeto,
            t.Nombre AS Contratista,
            c.Fecha_Vencimiento,
            DATEDIFF( CURDATE( ), c.Fecha_Vencimiento ) AS Dias_Vencidos 
        FROM
            contratos AS c
            INNER JOIN tbl_terceros AS t ON c.Fk_Id_Terceros = t.Pk_Id_Terceros 
        WHERE
            c.Fecha_Vencimiento < CURDATE( ) 
            AND c.Fk_Id_Estado != 2 
        ORDER BY
            c.Fecha_Vencimiento DESC';
        
        //Se retorna la consulta
        return $this->db->query($sql)->result(); 
    }//Fin contratos_pendientes_devolucion_retenido
    
    /**
    * Envía los correos electrónicos
    * 
    * @access	private
    */
    function polizas_en_vencimiento(){
        $sql = 
        "SELECT
            c.Numero Numero_Contrato,
            c.Objeto,
            t.Nombre AS Contratista,
            pt.Poliza_Tipo,
            cp.Fecha_Final Fecha_Vencimiento,
            DATEDIFF( cp.Fecha_Final, CURDATE( ) ) AS Dias_Restantes 
        FROM
            contratos_polizas AS cp
            INNER JOIN poliza_tipo AS pt ON pt.Pk_Id_Poliza_Tipo = cp.Fk_Id_Poliza_Tipo
            INNER JOIN contratos AS c ON cp.Fk_Id_Contratos = c.Pk_Id_Contrato
            INNER JOIN tbl_terceros AS t ON t.Pk_Id_Terceros = c.Fk_Id_Terceros 
        WHERE
            ( ( cp.Fecha_Final - CURDATE( ) ) BETWEEN 0 AND 5 ) 
        ORDER BY
            c.Numero ASC,
            pt.Pk_Id_Poliza_Tipo ASC";
        
        //Se retorna la consulta
        return $this->db->query($sql)->result(); 
    }//Fin polizas_en_vencimiento
    
    /**
    * Env&iacute;a los correos electr&oacute;nicos
    * 
    * @access	private
    */
    function polizas_vencidas(){
        $sql = 
        "SELECT
            c.Numero Numero_Contrato,
            c.Objeto,
            t.Nombre AS Contratista,
            pt.Poliza_Tipo,
            cp.Fecha_Final Fecha_Vencimiento,
            DATEDIFF( CURDATE( ), cp.Fecha_Final ) AS Dias_Vencidos 
        FROM
            contratos_polizas AS cp
            INNER JOIN poliza_tipo AS pt ON pt.Pk_Id_Poliza_Tipo = cp.Fk_Id_Poliza_Tipo
            INNER JOIN contratos AS c ON cp.Fk_Id_Contratos = c.Pk_Id_Contrato
            INNER JOIN tbl_terceros AS t ON t.Pk_Id_Terceros = c.Fk_Id_Terceros 
        WHERE
            cp.Fecha_Final < CURDATE( ) 
            AND c.Fk_Id_Estado != 2 
            AND cp.Fecha_Final != '0000-00-00' 
        ORDER BY
            c.Numero ASC,
            pt.Pk_Id_Poliza_Tipo ASC";
        
        //Se retorna la consulta
        return $this->db->query($sql)->result(); 
    }//Fin polizas_vencidas()

    function solicitudes_pendientes(){
        $sql =
        "SELECT
            cs.Pk_Id_Contrato_Solicitud,
            CONCAT( u.Nombres, ' ', u.Apellidos ) AS Solicitante,
            tc.Nombre AS Tipo_Contrato,
            t.Nombre AS Contratista,
            cs.Objeto,
            cs.Valor_Inicial,
            cs.Fecha_Inicial
        FROM
            contratos_solicitudes AS cs
            INNER JOIN tbl_usuarios AS u ON cs.Fk_Id_Usuario = u.Pk_Id_Usuario
            INNER JOIN tbl_tipos_contratos AS tc ON cs.Fk_Id_Tipo_Contrato = tc.Pk_Id_Tipo_Contrato
            INNER JOIN tbl_terceros AS t ON cs.Fk_Id_Terceros = t.Pk_Id_Terceros 
        WHERE
            ( SELECT Count( cc.Pk_Id_Contrato ) FROM contratos AS cc WHERE cc.Fk_Id_Solicitud_Contrato = cs.Pk_Id_Contrato_Solicitud LIMIT 0, 1 ) = 0 
        ORDER BY
            cs.Fecha_Inicial ASC";

        return $this->db->query($sql)->result();
    } // solicitudes_pendientes
}//Fin email
/* End of file email_model.php */
/* Location: ./contratos/application/controllers/email_model.php */