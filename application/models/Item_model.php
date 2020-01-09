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
     * Récupère les items appartenant à une catégorie spécifique
     * @param Integer $idCat
     * @return Array
     */
    public function getItem($cond = array()) {
        
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
        
        $toReturn = $this->db->select("I.item_id, I.category_id, I.subcategory_id, item_name, item_descript, I.collection_id, "
                    . "item_date_create, item_img, item_creator, item_release, item_editor, item_tracklist, item_siblings,"
                    . " item_idx_sibling, item_universe, item_length, item_seasons, item_type, C.category_icon, "
                    . "C.category_name AS main_category, SC.category_name AS sub_category, GROUP_CONCAT(U.user_id) AS user_id_possess,"
                    . "GROUP_CONCAT(CONCAT(U.user_id, '|', user_name)) AS user_possess, GROUP_CONCAT(CONCAT(U.user_id, '|', item_borrowable, '|', user_name)) AS user_let_borrow")
                ->from('item I')
                ->join('category C', 'I.category_id = C.category_id', 'left')
                ->join('category SC', 'I.subcategory_id = SC.category_id', 'left')
                ->join('itemUser IU', 'I.item_id = IU.item_id', 'left')
                ->join('user U', 'U.user_id = IU.user_id', 'left')
                ->group_by("I.item_id, I.category_id, I.subcategory_id, item_name, item_descript,"
                    . "item_date_create, item_img, item_creator, item_release, item_editor, item_tracklist, item_siblings,"
                    . " item_idx_sibling, item_universe, item_length, item_seasons, item_type, C.category_icon,"
                    . "C.category_name, SC.category_name")
                ->get()->result_array();
        
        foreach($toReturn as &$one) {
            if(intval($one['collection_id']) > 0) {
                $collec = $this->getCollection($one['collection_id']);
                if($collec !== FALSE) {
                    $one['item_name'] = $collec['collection_name'] . ' T' . $one['item_idx_sibling'];
                    $one['item_creator'] = $collec['collection_creator'];
                    $one['item_editor'] = $collec['collection_editor'];
                    $one['item_release'] = $collec['collection_release'];
                    $one['item_universe'] = $collec['collection_universe'];
                    $one['collection_length'] = $collec['collection_length'];
                }
            }
        }
        
        return $toReturn;
    }
    
    /**
     * Récupération des infos d'une collection
     * @param type $id
     * @return Array
     */
    public function getCollection($id) {
        $query = $this->db->select('*')
                ->from('collection')
                ->where('collection_id', $id)
                ->get()->result_array();
        
        if(count($query) > 0) {
            return $query[0];
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Récupération de l'ensemble des items de la wishlist d'un user
     * @param type $id
     * @return Array
     */
    public function getWishlist($cond) {
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
        
        $query = $this->db->select("I.item_id, I.category_id, I.subcategory_id, item_name, item_descript, I.collection_id, "
                    . "item_date_create, item_img, item_creator, item_release, item_editor, item_tracklist, item_siblings,"
                    . " item_idx_sibling, item_universe, item_length, item_seasons, item_type, C.category_icon, "
                    . "C.category_name AS main_category, SC.category_name AS sub_category, GROUP_CONCAT(U.user_id) AS user_id_possess,"
                    . "GROUP_CONCAT(CONCAT(U.user_id, '|', user_name)) AS user_possess")
                ->from('item I')
                ->join('category C', 'I.category_id = C.category_id', 'left')
                ->join('category SC', 'I.subcategory_id = SC.category_id', 'left')
                ->join('wish W', 'I.item_id = W.item_id')
                ->join('user U', 'U.user_id = W.user_id', 'left')
                ->group_by("I.item_id, I.category_id, I.subcategory_id, item_name, item_descript,"
                    . "item_date_create, item_img, item_creator, item_release, item_editor, item_tracklist, item_siblings,"
                    . " item_idx_sibling, item_universe, item_length, item_seasons, item_type, C.category_icon,"
                    . "C.category_name, SC.category_name")
                ->get()->result_array();
        
        return $query;
    }
    
    /**
     * Récupère le nombre d'élément par catégorie ou sous catégorie
     * @param Integer $idUser
     * @param Boolean $sub
     * @return Array
     */
    public function getNbItemByCategory($idUser, $sub = FALSE) {
        if($sub === TRUE) {
            $this->db->select('C.category_name, CP.category_name AS parent_name, CP.category_id AS parent_id')
                    ->join('category C', 'C.category_id = I.subcategory_id')
                    ->join('category CP', 'C.category_parent_id = CP.category_id')
                    ->group_by('subcategory_id');
        }
        else {
            $this->db->select('category_name')
                    ->join('category C', 'C.category_id = I.category_id')
                    ->group_by('I.category_id');
        }
        
        // WHERE user_id = 1 group by I.category_id
        return $this->db->select('COUNT(I.item_id) AS nb_item')
                ->from('item I')
                ->join('itemuser IU', 'IU.item_id = I.item_id')
                ->where('user_id', $idUser)
                ->get()->result_array();
                
                
    }
    
    /**
     * Établit un lien de possession entre un item et un utilisateur
     * @param Integer $idItem
     * @param Integer $idUser
     */
    public function setItemUserLink($idItem, $idUser) {
        $this->db->insert('itemUser', array(
            'item_id' => $idItem,
            'user_id' => $idUser,
            'item_borrowable' => 1
        ));
    }
    
    /**
     * 
     * @param Integer $idItem
     * @param Integer $idUser
     * @param Array $data
     */
    public function editItemUserLink($idItem, $idUser, $data) {
        $this->db->where('item_id', $idItem)
                ->where('user_id', $idUser)
                ->update('itemUser', $data);
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
     * Établit un lien de désir entre un item et un utilisateur
     * @param Integer $idItem
     * @param Integer $idUser
     */
    public function setItemUserWish($idItem, $idUser) {
        $this->db->insert('wish', array(
            'item_id' => $idItem,
            'user_id' => $idUser
        ));
    }
    
    /**
     * Établit un lien de désir entre un item et un utilisateur
     * @param Integer $idItem
     * @param Integer $idUser
     */
    public function delItemUserWish($idItem, $idUser) {
        $this->db->where(array(
                    'item_id' => $idItem,
                    'user_id' => $idUser
                ))
              ->delete('wish');
    }
    

    /**
     * Ajoute une demande d'emprunt dans la base
     * @param Array $info
     * @param Integer $idBorrow
     */
    public function setBorrow($info, $idBorrow = 0) {
        if(intval($idBorrow) === 0) {
            $this->db->insert('borrow', $info);
        }
        else {
            $this->db->where('borrow_id', $idBorrow)
                    ->update('borrow', $info);
        }
    }
    
    /**
     * Récupère les emprunts/prêts 
     * @param Array $cond
     * @param String
     * @return Array
     */
    public function getBorrow($cond = array()) {
        if(isset($cond['where'])) {
            $this->db->where($cond['where']);
        }
        
        if(isset($cond['notIn'])) {
            foreach($cond['notIn'] as $field => $val) {
                $this->db->where_not_in($field, $val);
            }
        }
        
        if(isset($cond['like'])) {
            foreach($cond['like'] as $field => $val) {
                $this->db->like($field, $val);
            }
        }
        
        if(isset($cond['orWhere'])) {
            $this->db->or_where($cond['orWhere']);
        }
        
        if(isset($cond['orderBy'])) {
            $this->db->order_by($cond['orderBy']);
        }
        
        return $this->db->select('borrow_id, item_name, borrow_date_create, borrow_date_end, borrow_date_begin, borrow_length, '
                . 'borrow_state, lender_id, U2.user_name AS lender_name, borrower_id, U.user_name AS borrower_name, borrow_date_renew_asked')
                ->from('borrow B')
                ->join('item I', 'B.item_id = I.item_id', 'left')
                ->join('user U', 'B.borrower_id = U.user_id', 'left')
                ->join('user U2', 'B.lender_id = U2.user_id', 'left')
                ->group_by('borrow_id, item_name, borrow_date_create, borrow_date_end, borrow_date_begin, borrow_state, borrow_date_renew_asked')
                ->get()->result_array();
    }
    
}
