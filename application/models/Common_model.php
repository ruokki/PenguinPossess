<?php

/**
 * Description of Common_model
 *
 * @author Ruokki
 */
class Common_model extends CI_Model {
    
    /**
     * Lancement de la transaction
     */
    public function startTransaction() {
        $this->db->trans_begin();
    }
    
    /**
     * Fin de la transaction
     */
    public function completeTransaction() {
        $this->db->trans_commit();
        
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    
    /**
     * Rollback sur la transaction en cours
     */
    public function rollbackTransaction() {
        $this->db->trans_rollback();
    }
    
}
