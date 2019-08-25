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
class Category_model extends CI_Model {
    
    /**
     * Récupère les catégories
     * @param Integer $idParent
     * @return Array
     */
    public function getCategory($idParent = NULL) {
        $this->db->select('*')
                ->from('category');
        
        if($idParent === 'sub') {
            $this->db->where('category_parent_id IS NOT NULL');
        }
        else if($idParent !== NULL) {
            $this->db->where('category_parent_id', $idParent);
        }
        else {
            $this->db->where('category_parent_id', NULL);
        }
        
        return $this->db->get()->result_array();
    }
}
