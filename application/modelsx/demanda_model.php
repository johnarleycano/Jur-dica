<?php
/**
 * Modelo que se encarga de gestionar la informaci&oacute;n
 * de las demandas
    
 */
Class Demanda_model extends CI_Model{
    
    /**
    * Guarda en la base de datos los datos de la demanda.


    
    * @access	public
    * @return	
    */

    function guardar_actualizar_demanda($demanda, $id_demanda){
        //Se actualizan los datos principales del contrato
        $this->db->where('Pk_Id_Demandas', $id_demanda);
        $this->db->update('demandas', $demanda);
    }//Fin guardar_actualizar_demanda




    function registrar_demanda($demanda){
        //Se insertan los datos principales de la demanda
        $this->db->insert('demandas', $demanda);

    }//Fin registrar_demanda

    /**
    * Retorna verdadero si el numero de contrato que se ingresa existe.
    *
    * @access	public
    * @param	string	el numero del contrato.
    * @return	
    */
    function verificar_numero($radicado){
        $this->db->where('radicado', $radicado);
        $query = $this->db->get('demandas');
        if($query->num_rows() >0 ){
            return false;
        }else{
            return true;
        }
    }//Fin verificar_numero()


    function listar_demanda(){

        // if($id_demanda){
        //     $id_demanda = 'WHERE d.Pk_Id_Demandas ='.$id_demanda;
        // }

        //consulta

        $sql = 'SELECT
                d.Pk_Id_Demandas,
                d.radicado,
                d.asunto,
                d.valor_pretension As Pretencion,
                d.observacion,
                d.ultima_actuacion As Actuacion,
                d.pronostico,
                d.pendiente,
                tbl_terceros.Pk_Id_Terceros,
                tbl_terceros.Nombre AS Juzgado,
                tbl_tipo_proceso.Pk_Id_tipo_proceso,
                tbl_tipo_proceso.tipo_proceso AS Proceso
                FROM
                demandas AS d
                INNER JOIN tbl_terceros ON d.Fk_Id_Terceros = tbl_terceros.Pk_Id_Terceros
                INNER JOIN tbl_tipo_proceso ON d.Fk_Id_tipo_proceso = tbl_tipo_proceso.Pk_Id_tipo_proceso';

                //Se retorna la consulta
                return $this->db->query($sql)->result(); 

    }//Fin listar_demanda
    

     function actualizar_demanda($id_demanda){

        //consulta

        $sql = "SELECT
                d.Pk_Id_Demandas,
                d.radicado,
                d.asunto,
                d.valor_pretension,
                d.observacion,
                d.ultima_actuacion,
                d.pronostico,
                d.pendiente,
                tbl_terceros.Pk_Id_Terceros,
                tbl_terceros.Nombre,
                tbl_tipo_proceso.Pk_Id_tipo_proceso,
                tbl_tipo_proceso.tipo_proceso
FROM
                demandas AS d
                INNER JOIN tbl_terceros ON d.Fk_Id_Terceros = tbl_terceros.Pk_Id_Terceros
                INNER JOIN tbl_tipo_proceso ON d.Fk_Id_tipo_proceso = tbl_tipo_proceso.Pk_Id_tipo_proceso
WHERE
                d.Pk_Id_Demandas = $id_demanda";

                //Se retorna la consulta
                return $this->db->query($sql)->result(); 

    }//Fin listar_demanda
}//Fin demanda_model