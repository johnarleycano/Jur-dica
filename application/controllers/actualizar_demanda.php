<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Controlador del m&oacute;dulo Modificar Contrato.
 * @author 		John Arley Cano Salinas
 * @copyright	&copy; HATOVIAL S.A.S.
 */
Class Actualizar_demanda extends CI_Controller{
    
    /**
    * Funci&oacute;n constructora de la clase actualizar. 
    * 
    * Se hereda el mismo constructor de la clase Controller para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access	public
    */
    function __construct() {
        //con esta linea se hereda el constructor de la clase Controller
        parent::__construct();
        //Verifica si el usuario est&aacute; logueado y no pueda acceder por url a menus sin permisos
        if($this->session->userdata('Pk_Id_Usuario') != TRUE || $this->session->userdata('Tipo') == FALSE)
        {
            //Se redirecciona para que cierre la sesion y lo lleve al inicio
            redirect('sesion/cerrar_sesion');
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
     * Muestra la vista principal del m&oacute;dulo Actualizar.
     * 
     * @access	public
     */
    function index(){
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
        $this->data['contenido_principal'] = 'actualizar/actualizar_demanda_view';
        //se carga el template
        $this->load->view('includes/template', $this->data);

    }//Fin index()
    
    /**
     * Funci&oacute;n que se encarga de actualizar el contrato
     * 
     * @access	public
     */
    function demanda(){
        /*
         * Este array se usa para mantener los datos modificados de todos los campos
         * en caso de no superar la validaci&oacute;n
         */
        $datos = array(
            // array('field' => 'radicado_proceso', 'label' => '', 'rules' => 'trim'),
            array('field' => 'tipoprocesos', 'label' => '', 'rules' => 'trim'),
            array('field' => 'juzgados', 'label' => '', 'rules' => 'trim'),
            array('field' => 'asunto', 'label' => '', 'rules' => 'trim'),
            array('field' => 'valor_pretenciones', 'label' => '', 'rules' => 'trim'),
            array('field' => 'observacion', 'label' => '', 'rules' => 'trim'),
            array('field' => 'ultima_actuacion', 'label' => '', 'rules' => 'trim'),
            array('field' => 'pendiente', 'label' => '', 'rules' => 'trim'),
            array('field' => 'pronostico', 'label' => '', 'rules' => 'trim'),
            
        );
        /*
         * Estas son las validaciones que se realizan con el Helper form_validation
         */
        $this->form_validation->set_rules($datos);
        $this->form_validation->set_rules('asunto', 'El Asunto de la demanda', 'required|trim');
        $this->form_validation->set_rules('valor_pretenciones', 'El valor de la pretencion', 'numeric|trim');
        $this->form_validation->set_rules('observacion', 'Observacion', 'trim');
        $this->form_validation->set_rules('ultima_actuacion', 'Ultima Actuacion', 'trim');
        $this->form_validation->set_rules('pendiente', 'Pendiente', 'trim');
        $this->form_validation->set_rules('pronostico', 'Pronostico', 'trim');
        
        //Mensajes que se muestran cuando no se supera la validaci&oacute;n
        $this->form_validation->set_message('required', '-%s no puede estar vac&iacute;o');
        $this->form_validation->set_message('numeric', '-%s no puede contener letras.');
        
        /*
         * Esta es la condición que ejecuta las reglas y no lo deja pasar. 
         * Si el método devuelve FALSE, la validación no se llevó corretamente
         */
        if($this->form_validation->run() == false){
            //Se imprime el mensaje de informaci&oacute;n
            $this->data['mensaje_alerta'] = "Hacen falta algunos datos necesarios<br> para guardar la demanda. Verifique por favor";
            $this->index();
        }else{
            /*
             * Se preparan los datos del contrato para enviar a la base de datos:
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
            
            //Condici&oacute;n para encontrar el predio espec&iacute;fico
            $id_demanda = $this->input->post('id_demanda');
            $numero = $this->input->post('radicado_proceso');
            
            //Estos datos se env&iacute;an a la demanda para modificarla
            $this->demanda_model->guardar_actualizar_demanda($demanda, $id_demanda);
            
            //Se usa el modelo para la acci&oacute;n de auditor&iacute;a
            $this->auditoria_model->modificar_demanda($numero);
         
            //Se establece el mensaje de exito
            $this->data['mensaje_exito'] = 'La Demanda '.$numero.' ha sido actualizado con &eacute;xito';
            
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
    }//Fin demanda()
}//Fin actualiazar
/* End of file actualizar_demanda.php */
/* Location: ./contratos/application/controllers/actualizar_demanda.php */