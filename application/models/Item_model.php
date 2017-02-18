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
            'item_id' => $idItem,
            'user_id' => $idUser
        ));
    }
    
    /**
     * Supprimer un lien entre un item et un utilisateur
     * @param Integer $idItem
     * @param Integer $idUser
     */
    public function delItemUserLink($idItem, $idUser) {
        $this->db->where(array(
                    'item_id' => $idItem,
                    'user_id' => $idUser
                ))
              ->delete('itemUser');
    }
    
    /**
     * Récupère les items appartenant à une catégorie spécifique
     * @param Integer $idCat
     * @return Array
     */
    public function getItem($cond) {
        
        if(isset($cond['where'])) {
            $this->db->where($cond['where']);
        }
        
        if(isset($cond['orWhere'])) {
            $this->db->or_where($cond['orWhere']);
        }
        
        if(isset($cond['like'])) {
            $this->db->like($cond['like']);
        }
        
        if(isset($cond['orderBy'])) {
            $this->db->order_by($cond['orderBy']);
        }
        
        return $this->db->select("I.item_id, I.category_id, I.subcategory_id, item_name, item_descript,"
                    . "item_date_create, item_img, item_creator, item_release, item_editor, item_tracklist, item_siblings,"
                    . " item_idx_sibling, item_universe, item_length, item_seasons, item_type, C.category_icon, "
                    . "C.category_name AS main_category, SC.category_name AS sub_category, GROUP_CONCAT(U.user_id) AS user_id_possess,"
                    . "GROUP_CONCAT(CONCAT(U.user_id, '|', user_name)) AS user_possess")
                ->from('item I')
                ->join('category C', 'I.category_id = C.category_id', 'left')
                ->join('category SC', 'I.subcategory_id = SC.category_id', 'left')
                ->join('itemuser IU', 'I.item_id = IU.item_id', 'left')
                ->join('user U', 'U.user_id = IU.user_id', 'left')
                ->group_by("I.item_id, I.category_id, I.subcategory_id, item_name, item_descript,"
                    . "item_date_create, item_img, item_creator, item_release, item_editor, item_tracklist, item_siblings,"
                    . " item_idx_sibling, item_universe, item_length, item_seasons, item_type, C.category_icon,"
                    . "C.category_name, SC.category_name")
                ->get()->result_array();
    }
    
}
