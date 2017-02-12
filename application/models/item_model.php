<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of item_model
 *
 * @author Ruokki
 */
class item_model extends CI_Model {
    
    /**
     * Ajoute ou modifie un item
     * @param Array $info
     * @param Integer $idItem
     */
    public function setItem($info, $idItem = 0) {
        if(intval($idItem) === 0) {
            $this->db->insert('item', $info);
            $idItem = $this->db->insert_id();
        }
        else {
            $this->db->where('item_id', $idItem)
                    ->update('item', $info);
        }
        
        return $idItem;
    }
    
    /**
     * Établit un lien entre un item et un utilisateur
     * @param Integer $idItem
     * @param Integer $idUser
     */
    public function setItemUserLink($idItem, $idUser) {
        $this->db->insert('itemUser', array(
            'item_id' => $idUser,
            'user_id' => $idUser
        ));
    }
    
    /**
     * Récupère les items appartenant à une catégorie spécifique
     * @param Integer $idCat
     * @return Array
     */
    public function getItemFromCategory($idCat = NULL) {
        
        if($idCat !== NULL) {
            $this->db->where('category_id', $idCat)
                ->or_where('subcategory_id', $idCat);
        }
        
        return $this->db->select('*')
                ->from('item')
                ->get()->result_array();
    }
    
}
