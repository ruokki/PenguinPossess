<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of User_model
 *
 * @author Ruokki
 */
class User_model extends CI_Model {
    
    /**
     * Ajoute ou modifie un utilisateur
     * @param Array $info
     * @param Integer $idUser
     * @return Integer
     */
    public function setUser($info, $idUser = 0) {
        if(intval($idUser) === 0) {
            $this->db->insert('user', $info);
            $idUser = $this->db->insert_id();
        }
        else {
            $this->db->where('user_id', $idUser)
                    ->update('user', $info);
        }
        
        return $idUser;
    }
    
    /**
     * Récupère les utilisateurs par leur noms
     * @param type $name
     * @return Array
     */
    public function getUserFromName($name) {
        return $this->db->select('*')
                ->from('user')
                ->where('user_name', $name)
                ->where('user_active', 1)
                ->get()->result_array();
    }
    
    /**
     * Récupère l'ensemble des utilisateurs
     * @return Array
     */
    public function getUser() {
        return $this->db->select('*')
                ->from('user U')
                ->join('role R', 'U.role_id = R.role_id', 'left')
                ->get()->result_array();
    }
    
    /**
     * Récupère les rôles
     * @return Array
     */
    public function getRole() {
        return $this->db->select('*')
                ->from('role')
                ->get()->result_array();
    }
    
}
