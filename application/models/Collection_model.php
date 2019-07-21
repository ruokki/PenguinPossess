<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of category_model
 *
 * @author Ruokki
 */
class Collection_model extends CI_Model {
    
    /**
     * Ajoute ou modifie une collection
     * @param Array $info
     * @param Integer $idItem
     */
    public function setCollection($info, $idCollection = 0) {
        if(intval($idCollection) === 0) {
            $this->db->insert('collection', $info);
            $idCollection = $this->db->insert_id();
        }
        else {
            $this->db->where('collection_id', $idCollection)
                    ->update('collection', $info);
        }
        
        return $idCollection;
    }
}
