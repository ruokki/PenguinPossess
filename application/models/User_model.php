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
     * Récupère un utilisateur par son adresse mail
     * @param type $name
     * @return Array
     */
    public function getUserFromEmail($email) {
        return $this->db->select('*')
                ->from('user')
                ->where('user_email', $email)
                ->get()->result_array();
    }
    
    /**
     * Récupère un utilisateur par son token
     * @param type $name
     * @return Array
     */
    public function getUserFromToken($token) {
        return $this->db->select('user_id, user_date_new_pass')
                ->from('user')
                ->where('user_token_new_pass', $token)
                ->get()->result_array();
    }
    
    /**
     * Récupère l'ensemble des utilisateurs
     * @param Array
     * @return Array
     */
    public function getUser($cond = array()) {
        
        if(isset($cond['where'])) {
            $this->db->where($cond['where']);
        }
        
        if(isset($cond['orWhere'])) {
            $this->db->or_where($cond['orWhere']);
        }
        
        if(isset($cond['orderBy'])) {
            $this->db->order_by($cond['orderBy']);
        }
        
        return $this->db->select('*')
                ->from('user U')
                ->join('role R', 'U.role_id = R.role_id', 'left')
                ->get()->result_array();
    }
    
    /**
     * Récupère le nom des emprunteurs d'un item
     * @param Array $ids
     * @return Array
     */
    public function getLender($ids) {
        $result = $this->db->select('GROUP_CONCAT(user_name) AS names')
                ->from('user')
                ->where_in('user_id', $ids)
                ->get()->result_array();
        
        if(count($result) > 0) {
            return $result[0];
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Récupère le nombre d'utilisateur total
     * @return Integer
     */
    public function getNbUser() {
        return $this->db->count_all('user');
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
    
    /**
     * Récupère les demandes d'emprunts faites à un utilisateur
     * @param Integer $idUser
     */
    public function getNbBorrowNotif($idUser) {
        return $this->db->where('lender_id', $idUser, 'both')
                ->where('borrow_state', 'WA')
                ->count_all_results('borrow');
    }
    
    /**
     * Récupère les emprunts arrivant à expiration d'un utilisateur
     * @param Integer $idUser
     */
    public function getExpiringBorrow($idUser) {
        return $this->db->where('borrower_id', $idUser)
                ->where('borrow_state', 'BO')
                ->where('`borrow_date_end` <= CURDATE() + INTERVAL 30 DAY')
                ->count_all_results('borrow');
    }
    
}
