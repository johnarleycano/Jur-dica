<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Controlador del m&oacute;dulo de contrato.
 * @author 		John Arley Cano Salinas
 * @copyright	&copy; HATOVIAL S.A.S.
 */
Class Demanda extends CI_Controller{
    
    /**
    * Funci&oacute;n constructora de la clase Contrato. 
    * 
    * Se hereda el mismo constructor de la clase Controller para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access	public
    */
   function __construct() {
        //con esta linea se hereda el constructor de la clase Controller
        parent::__construct();
        //Verifica si el usuario est&aacute; logueado
        if($this->session->userdata('Pk_Id_Usuario') != TRUE)
        {
            //Redirecci&oacute;n al controlador de sesi&oacute;n
            redirect('sesion');
        }
        //Se carga el modelo de los demandas en la base de datos
        $this->load->model('demanda_model');
        //Se carga el modelo de los tipos de procesos en la base de datos
        $this->load->model('tipoproceso_model');
        //Se carga el modelo de los contratistas en la base de datos
        $this->load->model('tercero_model');
        //Se carga el helper html para usar en la vista
        $this->load->helper('html');
   }//Fin construct()
   
    /**
     * Muestra la vista principal del m&oacute;dulo de sesi&oacute;n.
     * 
     * @access	public
     */
    function index(){
        
              
        //Se traen los juzgados que se encuentran en la aplicaci&oacute;n
        $this->data['juzgados'] = $this->tercero_model->listar_juzgados();
        //Se traen los tipos de procesos que se encuentran en la aplicaci&oacute;n
        $this->data['tipoprocesos'] = $this->tipoproceso_model->listar_tipoprocesos();
        //se establece el titulo de la p&aacute;gina
        $this->data['titulo'] = 'Demanda - Crear nuevo';
        //se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'demanda/demanda_view';
        //se carga el template
        $this->load->view('includes/template', $this->data);
    }//Fin index
    
    /**
     * Valida los numeros de contrato creados en la aplicaci&oacute;n
     * con el fin de no permitir que se repitan.
     * 
     * @access	public
     */
    function verificar_numero($radicado){
        return $this->demanda_model->verificar_numero($radicado);
    }//Fin verificar_numero()
    
    /**
    * Funci&oacute;n que se encarga de agregar un contrato nuevo
    * 
    * @access	public
    */
    function agregar_demanda(){
        /*
         * Estas son las validaciones que se realizan con el Helper form_validation
         */
        $this->form_validation->set_rules('radicado_proceso', 'El n&uacute;mero del radicado', 'required|numeric|trim|callback_verificar_numero');
        // $this->form_validation->set_rules('tribunal_juzgado', 'El Tribunal', 'required|trim');
        // $this->form_validation->set_rules('tipo_proceso', 'El tipo de Proceso', 'required|trim');
        $this->form_validation->set_rules('asunto', 'El Asunto de la demanda', 'required|trim');
        $this->form_validation->set_rules('valor_pretenciones', 'El valor de la pretencion', 'numeric|trim');
        $this->form_validation->set_rules('observacion', 'Observacion', 'trim');
        $this->form_validation->set_rules('ultima_actuacion', 'Ultima Actuacion', 'trim');
        $this->form_validation->set_rules('pendiente', 'Pendiente', 'trim');
        $this->form_validation->set_rules('pronostico', 'Pronostico', 'trim');
        
        //Mensajes que se muestran cuando no se supera la validaci&oacute;n
        $this->form_validation->set_message('required', '-%s no puede estar vac&iacute;o');
        $this->form_validation->set_message('numeric', '-%s no puede contener letras.');
        $this->form_validation->set_message('verificar_numero', '-El n&uacute;mero del radicado '.$this->input->post('radicado_proceso').' ya existe en la base de datos.');
        
        /*
         * Esta es la condición que ejecuta las reglas y no lo deja pasar. 
         * Si el método devuelve FALSE, la validación no se llevó corretamente
         */
        if($this->form_validation->run() == false){
            //Se imprime el mensaje de informaci&oacute;n
            $this->data['mensaje_alerta'] = "Hacen falta algunos datos necesarios<br> para guardar el contrato. Verifique por favor";
            $this->index();
        }else{
            /*
             * Se preparan los datos de la demanda para enviar a la base de datos:
             * 
             */
            $demanda = array(
                'radicado' => $this->input->post('radicado_proceso'),
                'asunto' => $this->input->post('asunto'),
                'valor_pretension' => $this->input->post('valor_pretenciones'),
                'observacion' => $this->input->post('observacion'),
                'ultima_actuacion' => $this->input->post('ultima_actuacion'),
                'pronostico' => $this->input->post('pronostico'),
                'pendiente' => $this->input->post('pendiente'),
                'Fk_Id_tipo_proceso' => $this->input->post('tipoprocesos'),
                'Fk_Id_Terceros' => $this->input->post('juzgados'), 
                'Fk_id_Usuario' => $this->session->userdata('Pk_Id_Usuario'),
              
            );
            // print_r($demanda);
            //Estos datos se insertan en la tabla demanda mediante este modelo
            $this->demanda_model->registrar_demanda($demanda);

            $numero = $this->input->post('radicado_proceso');

             //Se usa el modelo para la acci&oacute;n de auditor&iacute;a
            $this->auditoria_model->insertar_demanda($numero);       
            
            //Se establece el mensaje de exito
            $this->data['mensaje_exito'] = 'La registro de la demanda No. '.$this->input->post('radicado_proceso').' ha sido creado con &eacute;xito';

            /*
             * Se prepara la redirecci&oacute;n
             */
            $id_demanda = '';
            //Se traen todos las demandas
            $this->data['demandas'] = $this->demanda_model->listar_demanda($id_demanda);
            //Se traen los tipos de procesos que se encuentran en la aplicaci&oacute;n
            $this->data['tipoprocesos'] = $this->tipoproceso_model->listar_tipoprocesos();
            //se establece el titulo de la p&aacute;gina donde ir&aacute; despu&eacute;s de guardar
            $this->data['titulo'] = 'Demandas - Inicio';
            //se establece la vista que tiene el contenido principal
            $this->data['contenido_principal'] = 'inicio/inicio_demandas_view';
            //se carga el template
            $this->load->view('includes/template', $this->data);
        }
    }//Fin agregar_demanda

    function detalle_demanda(){
        //Se obtiene mediante la url el n&uacute;mero de la demanda
        $id_demanda = $this->uri->segment(3);

        //Se traen todos las demandas
        $this->data['demandas'] = $this->demanda_model->actualizar_demanda($id_demanda);
        //Se traen los juzgados que se encuentran en la aplicaci&oacute;n
        $this->data['juzgados'] = $this->tercero_model->listar_juzgados();
        //Se traen los tipos de procesos que se encuentran en la aplicaci&oacute;n
        $this->data['tipoprocesos'] = $this->tipoproceso_model->listar_tipoprocesos();
        //se establece el titulo de la p&aacute;gina
        $this->data['titulo'] = 'Actualizar Demanda';
        //se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'demanda/detalle_demanda_view';
        //se carga el template
        $this->load->view('includes/template', $this->data);
    }//Fin detalle_demanda()  
    
   

}//Fin demanda
/* End of file demanda.php */
/* Location: ./contratos/application/controllers/demanda.php */
?>