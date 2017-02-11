<?php

/**
 * Description of User_model
 *
 * @author Ruokki
 */
class User_model extends CI_Model {
    
    /**
     * Récupère les utilisateurs par leur noms
     * @param type $name
     * @return Array
     */
    public function getUserFromName($name) {
        return $this->db->select('*')
                ->from('user')
                ->where('user_name', $name)
                ->get()->result_array();
    }
    
}
