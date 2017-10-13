<?php
/**
 * Modelo que se encarga de gestionar la informaci&oacute;n
 * de los contratos en estado de liquidaci&oacute;n.
 * @author 		John Arley Cano Salinas
 * @copyright	&copy; HATOVIAL S.A.S.
 */
Class Tipoproceso_model extends CI_Model{
    /**
    * Guarda en la base de datos los datos del contrato.
    *
    * @access	public
    * @return	
    */

     function listar_tipoprocesos(){
        //columnas que se van a retornar
        $this->db->select('*');
        // $this->db->where('Fk_Id_Terceros_Tipo', 4);
        $this->db->order_by('tipo_proceso', "asc"); 
        
        //Se retorna la consulta
        $resultado = $this->db->get('tbl_tipo_proceso')->result();
        
        return $resultado;
    }//Fin listar_tipo procesos()

}//Fin tipo procesos