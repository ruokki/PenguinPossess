<?php

/**
 * Description of Token_model
 *
 * @author Ruokki
 */
class Token_model extends CI_Model {
    
    /**
     * Ajoute ou modifie un token
     * @param Array $info
     * @param Integer $idUser
     * @return Integer
     */
    public function setToken($idToken, $info) {
        if(intval($idToken) === 0) {
            $this->db->insert('token', $info);
            $idToken = $this->db->insert_id();
        }
        else {
            $this->db->where('token_id', $idToken)
                    ->update('token', $info);
        }
        
        return $idToken;
    }
    
}
