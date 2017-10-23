<?php
/**
 * Modelo que se encarga de gestionar la informaci&oacute;n
 * de los usuarios del sistema.
 * @author 		John Arley Cano Salinas
 * @copyright	&copy; HATOVIAL S.A.S.
 */
Class Usuario_model extends CI_Model{
    
    /**
    * Retorna los datos de un usuario si existe.
    *
    * @access	public
    * @param	string	el usuario.
    * @param	string	el password.
    * @return	los datos del usuario, FALSE en caso contrario.
    */
    function validar_login($usuario, $password){
        //columnas que se van a retornar
        $this->db->select('Pk_Id_Usuario');
        $this->db->select('Nombres');
        $this->db->select('Apellidos');
        $this->db->select('Usuario');
        $this->db->select('Email');
        $this->db->select('Tipo');
        $this->db->select('Activo');
        
        //Se valida el usuario y el password ingresados
        $this->db->where('Usuario', $usuario);
        $this->db->where('Clave', $password);
        
        //Se retorna la consulta
        $resultado = $this->db->get('tbl_usuarios')->row();
        
        return $resultado;
    }//Fin validar_login()
    
    /**
    * Retorna verdadero si el nombre de usuario que se ingresa existe.
    *
    * @access	public
    * @param	string	el usuario.
    * @return	los datos del nombre de usuario, TRUE en caso contrario.
    */
    function validar_usuario($usuario){
        $this->db->where('Usuario', $usuario);
        $query = $this->db->get('tbl_usuarios');
        if($query->num_rows() >0 ){
            return false;
        }else{
            return true;
        }
    }//Fin validar_usuario()
    
    /**
    * Retorna verdadero si el correo electr&oacute;nico que se ingresa existe.
    *
    * @access	public
    * @param	string	el usuario.
    * @return	el correo electr&oacute;nico del usuario, TRUE en caso contrario.
    */
    function validar_email($email){
        $this->db->where('Email', $email);
        $query = $this->db->get('tbl_usuarios');
        if($query->num_rows() >0 ){
            return false;
        }else{
            return true;
        }
    }//Fin validar_email()
    
    /**
    * Inserta un usuario en la base de datos
    *
    * @access	public
    */
    function insertar_usuario($usuario_nuevo){
        $this->db->insert('tbl_usuarios', $usuario_nuevo);
    }//Fin insertar_usuario()

    function cargar_permisos($id_usuario){
        //Columnas a retornar
        $this->db->where('Fk_Id_Usuario', $id_usuario);

        // Arreglo vacío
        $permisos = array();

        // Rcorrido de los resultados
        foreach ($this->db->get("permisos")->result() as $resultado) {
            // Se adiciona al nuevo arreglo
            $permisos[$resultado->Fk_Id_Accion] = true;
        }

        // Se retorna el nuevo arreglo
        return $permisos;
    } // cargar_permisos

    /**
    * Lista los terceros existentes en la base de datos.
    *
    * @access   public
    * @return   
    */
    function listar_usuarios($id_usuario = NULL){
        // Condición de usuario
        $usuario = ($id_usuario) ? "WHERE u.Pk_Id_Usuario = $id_usuario" : "" ;

        // Consulta
        $sql =
        "SELECT
            u.Pk_Id_Usuario,
            u.Nombres,
            u.Apellidos,
            u.Activo AS Estado,
            u.Usuario Login,
            u.Email,
            u.Telefono 
        FROM
            tbl_usuarios AS u
            $usuario
        ORDER BY
            u.Nombres ASC,
            u.Apellidos ASC";

            if ($id_usuario) {
                // Se retorna la consulta
                return $this->db->query($sql)->row();
            } else {
                // Se retorna la consulta
                return $this->db->query($sql)->result();
            }
    }//Fin listar_usuarios()

    function cargar_acciones_tipos(){
        // Se retorna los registros encontrados
        return $this->db->get("tbl_acciones_tipos")->result();
    } // cargar_acciones_tipo

    function cargar_modulos(){
        // Se retorna los registros encontrados
        return $this->db->get("tbl_modulos")->result();
    } // cargar_modulos

    function cargar_acciones($id_modulo, $id_accion_tipo){
        // Consulta
        $sql =
        "SELECT
            a.Pk_Id_Accion,
            a.Nombre 
        FROM
            tbl_acciones AS a 
        WHERE
            a.Fk_Id_Modulo = $id_modulo 
            AND a.Fk_Id_Accion_Tipo = $id_accion_tipo
        ORDER BY
            a.Nombre ASC";

        // Se retorna la consulta
        return $this->db->query($sql)->result();
    }//Fin cargar_acciones

    function cargar_permisos_usuario($id_usuario){
        // Consulta
        $sql =
        "SELECT
            p.Fk_Id_Accion 
        FROM
            permisos AS p 
        WHERE
            p.Fk_Id_Usuario = $id_usuario";

        // Se retorna la consulta
        return $this->db->query($sql)->result();
    }//Fin cargar_acciones

    function eliminar_permisos($id_usuario){
        //Se borran los permisos
        if($this->db->delete('permisos', array('Fk_Id_Usuario' => $id_usuario))){
            return true;
        }
    } // eliminar_permisos

    function guardar_permiso($datos){
        // if ($this->db->insert('permisos', $datos)) {
        //     return true;
        // }
        echo $this->db->insert('permisos', $datos);
    } // guardar_permiso
}
    