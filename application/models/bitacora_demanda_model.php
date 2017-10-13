<?php
/**
 * Modelo que se encarga de guardar un registro en la base de datos
 * de las anotaciones de la bit&aacute;cora para cada contrato
 * @author 		John Arley Cano Salinas
 * @copyright	&copy; HATOVIAL S.A.S.
 */
Class Bitacora_demanda_model extends CI_Model{
    
    /**
    * Guarda en la base de datos los datos de la bit&aacute;cora.
    *
    * @access	public
    * @return	
    */
    function agregar_bitacora($bitacora){
        //Se insertan los datos principales del contrato
        $this->db->insert('demanda_bitacora', $bitacora);
    }//Fin agregar_bitacora
    
    /**
    * Elimina de la base de datos los datos la anotaci&oacute;n
    * de la bit&aacute;cora seleccionada.
    *
    * @access	public
    * @return	
    */
    function eliminar_bitacora($bitacora){
        //Se insertan los datos principales del contrato
        $this->db->insert('contratos_bitacora', $bitacora);
    }//Fin agregar_bitacora
    
    /**
    * Retorna los datos de la bit&aacute;cora de la demanda
     * para la tabla de la vista.
    *
    * @access	
    * @param	
    * @param	
    * @return	
    */
    function listar_bitacora($id_demanda){
        //Consulta

    $sql = 'SELECT
        DATE_FORMAT(demanda_bitacora.Fecha,"%d-%m-%Y") AS Fecha,
        demanda_bitacora.Asunto,
        demanda_bitacora.Observacion,
        tbl_usuarios.Nombres,
        tbl_usuarios.Apellidos
        FROM
        demanda_bitacora
        INNER JOIN tbl_usuarios ON tbl_usuarios.Pk_Id_Usuario = demanda_bitacora.Fk_Id_Usuario
        WHERE
        demanda_bitacora.Fk_Id_Demanda = '.$id_demanda;

        //Se retorna la consulta
    return $this->db->query($sql)->result(); 
    }//Fin listar_bitacora demandas
}//Fin bitacora_model
