<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Ruokki
 */
class User extends CI_Controller {
    
    public function __construct() {
        parent::__construct();

        if($this->session->user === NULL) {
            redirect('home/login');
        }
    }
    
    /**
     * Page d'accueil "Mon compte"
     */
    public function index() {
        $this->load->model('Item_model', 'Item', TRUE);
        
        $data = array(
            'title' => 'Mon compte',
            'active' => 'user',
            'css' => array(
                'listItem.css',
                'user/index.css'
            ),
            'js' => array(
                'listItem.js'
            ),
            'items' => $this->Item->getItem(array(
                'where' => array(
                    'U.user_id' => $this->session->user['id']
                ),
                'orderBy' => 'item_date_create DESC'
            ))
        );
        
        $this->load->view('template/header', $data);
        $this->load->view('user/index', $data);
        $this->load->view('template/footer', $data);
    }
    
    /**
     * Création d'un item
     */
    public function manageItem($type = 'item', $id = 0) {
        $this->load->model('Category_model', 'Category', TRUE);
        $this->load->model('Item_model', 'Item', TRUE);
        $this->load->model('Common_model', 'Common', TRUE);
        $this->load->helper('formatcatname');
        
        if($this->input->is_ajax_request()) {
            $cmd = $this->input->post('cmd');
            $return = array();
            
            if($cmd === 'getSub') {
                $return = $this->Category->getCategory($this->input->post('category'));
                $isCollection = $this->config->item('collectionCategories');
            }
            else if ($cmd === 'getCompl') {
                $category = $this->input->post('category');
                $return['html'] = '';
                
                $return['html'] = $this->load->view('template/complInfo/' . formatCatName($category), array(
                    'typeView' => 'form'
                ), TRUE);
            }
            
            echo json_encode($return);
        }
        else {
            $data = array(
                'categories' => $this->Category->getCategory(),
                'title' => "Création d'un item",
                'active' => 'createItem',
                'type' => $type,
                'css' => array(
                    'user/manageItem.css'
                ),
                'js' => array(
                    'user/manageItem.js'
                ),
                'result' => array(),
                'typeView' => 'form',
                'maxWidthImg' => 1260,
                'maxHeightImg' => 1260,
                'entry' => FALSE
            );
            
            // Enregistrement de l'item
            if($this->input->post()) {
                $this->load->library('form_validation');
                
                $config = array(
                    array(
                        'field' => 'item_name',
                        'label' => 'Nom',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'category_id',
                        'label' => 'Catégorie',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'subcategory_id',
                        'label' => 'Sous-catégorie',
                        'rules' => 'required'
                    ),
                );
                
                $this->form_validation->set_rules($config);
                
                if($this->form_validation->run() === FALSE) {
                    $data['errors'] = $this->form_validation->error_array();
                    $data['entry'] = $this->input->post();
                }
                else {
                    $this->Common->startTransaction();
                    try {
                        $item = $this->input->post();
                        // Gestion des pistes pour un album
                        if(isset($item['track'])) {
                            $item['item_tracklist'] = implode('|', $item['track']);
                            unset($item['track']);
                        }

                        // Suppression clé uniquement pour la vue
                        if(isset($item['sub_category'])) {
                            unset($item['sub_category']);
                        }

                        // Gestion de l'id
                        $idItem = 0;
                        // Date création
                        $item['item_date_create'] = date('Y-m-d H:i:s');
                        $userPossess = array($this->session->user['id']);

                        // Gestion de l'upload de l'image
                        $config = array();
                        $this->load->library('upload', $config);

                        $config['upload_path']          = './asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'];
                        $config['allowed_types']        = 'gif|jpg|png';
                        $config['max_size']             = 2048;
                        $config['max_width']            = $data['maxWidthImg'];
                        $config['max_height']           = $data['maxHeightImg'];
                        $config['file_ext_tolower']     = TRUE;
                        $config['file_name']            = uniqid($this->session->user['id'] . '_');

                        $this->upload->initialize($config);
                        // Si plusieurs utilisateurs possèdent l'item, on bloque l'édition 
                        // et on attend la validation par un admin
    //                    if(count($userPossess) > 1) {
    //                        $this->load->helper('file');
    //                        $validateFolder = $this->config->item('validateFolder');
    //
    //                        if(!is_dir($validateFolder['root'] . '/' . $validateFolder['img'])) {
    //                            mkdir($validateFolder['root'] . '/' . $validateFolder['img'], 0777, TRUE);
    //                        }
    //                        $config['upload_path'] = $validateFolder['root'] . '/' . $validateFolder['img'];
    //                        $this->upload->initialize($config);
    //                        $this->upload->do_upload('item_img');
    //
    //                        write_file($validateFolder['root'] . '/pendingEdit', serialize($item) . '##', 'a');
    //                    }
    //                    else {

                        // On tente d'insérer le produit
                        if($idItem === 0) {
                            $item['item_img'] = '';
                        }
                        $idItem = $this->Item->setItem($item, $idItem);
                        
                        if($type === 'wish') {
                            $this->Item->setItemUserWish($idItem, $this->session->user['id']);
                        }
                        else {
                            $this->Item->setItemUserLink($idItem, $this->session->user['id']);
                        }

                        // Si l'insertion se fait, on finit l'upload du fichier
                        if(!is_dir($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, TRUE);
                        }

                        // On upload l'image
                        if ($this->upload->do_upload('item_img')) {
                            $idItem = $this->Item->setItem(array('item_img' => $this->upload->data('file_name')), $idItem);
                            $this->Item->setItemUserLink($idItem, $this->session->user['id']);
                            $this->Common->completeTransaction();
                            $data['result'] = array('success' => TRUE);
                        }
                        else {
                            $data['result'] = array('error' => TRUE);
                            $data['errors'] = array($this->upload->display_errors());
                            $this->Common->rollbackTransaction();
                            $data['entry'] = $this->input->post();
                        }
    //                    // Si on est en modif, l'image n'est pas obligatoire
    //                    $oldItem = array();
    //                    else {
    //                        if (empty($_FILES['item_img']['name'])) {
    //                            $data['result'] = array('success' => TRUE);
    //                        }
    //                        else {
    //                            if ($this->upload->do_upload('item_img')) {
    //                                if (isset($oldItem['item_img']) && trim($oldItem['item_img']) !== '') {
    //                                    unlink($config['upload_path'] . '/' . $oldItem['item_img']);
    //                                }
    //                                $idItem = $this->Item->setItem(array('item_img' => $this->upload->data('file_name')), $idItem);
    //                            }
    //                            else {
    //                                $data['result'] = array('error' => TRUE);
    //                                $data['errors'] = array($this->upload->display_errors());
    //                            }
    //                        }
    //                        // Dans tout les cas, on enregistre les modifications qui ont été faites
    //                        $this->Common->completeTransaction();
    //                    }
    //                    }
                    }
                    catch (Exception $ex) {
                        $this->Common->rollbackTransaction();
                    }
                }
            }
            
            if($data['entry'] !== FALSE) {
                $data['subCategories'] = $this->Category->getCategory($data['entry']['category_id']);
            }
//            if($id !== 0) {
//                $item = $this->Item->getItem(array(
//                    'where' => array(
//                        'I.item_id' => $id
//                    )
//                ));
//                
//                if(count($item) > 0) {
//                    $data['item'] = $item[0];
//                    $data['subCategories'] = $this->Category->getCategory($data['item']['category_id']);
//                    
//                    $userPossess = explode(',', $data['item']['user_id_possess']);
//                    if(!in_array($this->session->user['id'] . '', $userPossess)) {
//                        redirect('home/index');
//                    }
//                    else {
//                        if(count($userPossess) > 1) {
//                            $data['multiUser'] = true;
//                        }
//                    }
//                }
//                else {
//                    
//                }
//            }
            
            $this->load->view('template/header', $data);
            $this->load->view('user/manageItem', $data);
            $this->load->view('template/footer', $data);
        }
    }
    
    /**
     * Création d'une collection
     */
    public function manageCollection($type = 'item') {
        $this->load->model('Item_model', 'Item', TRUE);
        $this->load->model('Collection_model', 'Collection', TRUE);
        $this->load->model('Category_model', 'Category', TRUE);
        $this->load->model('Common_model', 'Common', TRUE);
        $this->load->helper('formatcatname');
        
        if($this->input->is_ajax_request()) {
            $cmd = $this->input->post('cmd');
            $return = array();
            
            if($cmd === 'getSub') {
                $categories = $this->Category->getCategory($this->input->post('category'));
                $isCollection = $this->config->item('collectionCategories');
                
                $return = array();
                foreach($categories as $one) {
                    if(in_array(strtolower($one['category_name']), $isCollection)) {
                        array_push($return, $one);
                    }
                }
            }
            else if ($cmd === 'getCompl') {
                $category = $this->input->post('category');
                $return['html'] = '';
                
                $return['html'] = $this->load->view('template/complInfo/' . formatCatName($category) . 'Collec', array(
                    'typeView' => 'form'
                ), TRUE);
            }
            
            echo json_encode($return);
        }
        else {
            if($this->input->post()) {
                $this->load->library('form_validation');
                
                $config = array(
                    array(
                        'field' => 'item_name',
                        'label' => 'Nom',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'category_id',
                        'label' => 'Catégorie',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'subcategory_id',
                        'label' => 'Sous-catégorie',
                        'rules' => 'required'
                    ),
                );
                
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() === FALSE) {
                    $data['errors'] = $this->form_validation->error_array();
                    $data['entry'] = $this->input->post();
                }
                else {
                    $item = $this->input->post();
                    
                    $this->Common->startTransaction();
                    $this->load->model('Collection_model', 'Collection', TRUE);
                    
                    try {
                        // Date création
                        $userPossess = array($this->session->user['id']);
                        $collection = $item['collection'];
                        $collection['collection_date_create'] = date('Y-m-d H:i:s');
                        $collection['collection_name'] = $item['item_name'];
                        $tomes = isset($collection['got_tome']) ? $collection['got_tome'] : array();

                        // Suppression des clés inutiles
                        unset($item['collection']);
                        unset($collection['got_tome']);
                        unset($item['sub_category']);

                        $idCollection = $this->Collection->setCollection($collection);
                        $item['collection_id'] = $idCollection;
                        $item['item_date_create'] = date('Y-m-d H:i:s');
                        $idItem = 0;
                        if($type === 'wish') {
                            for($i = 0; $i < $collection['collection_length']; $i++) {
                                $item['item_idx_sibling'] = $i;
                                $idItem = $this->Item->setItem($item, 0);                                
                                $this->Item->setItemUserWish($idItem, $this->session->user['id']);
                            }
                        }
                        else {
                            foreach($tomes as $nbTome => $checked) {
                                if($checked === 'on') {
                                    $item['item_idx_sibling'] = $nbTome;
                                    $idItem = $this->Item->setItem($item, 0);                                
                                    $this->Item->setItemUserLink($idItem, $this->session->user['id']);
                                }
                            }
                        }
                        $this->Common->completeTransaction();
                    }
                    catch (Exception $ex) {
                        $this->Common->rollbackTransaction();
                    }
                }
            }
            
            $categories = $this->Category->getCategory($this->input->post('category'));
            $isCollection = $this->config->item('collectionCategories');

            $availableCategories = array();
            foreach($categories as $one) {
                if(in_array(strtolower($one['category_name']), $isCollection)) {
                    array_push($availableCategories, $one);
                }
            }
            
            $data = array(
                'categories' => $availableCategories,
                'title' => "Création d'une collection",
                'type' => $type,
                'active' => 'createCollec',
                'css' => array(
                    'user/manageItem.css'
                ),
                'js' => array(
                    'user/manageItem.js'
                ),
                'result' => array(),
                'typeView' => 'form',
                'maxWidthImg' => 1260,
                'maxHeightImg' => 1260,
                'entry' => FALSE,
                'isCollec' => TRUE
            );

            $this->load->view('template/header', $data);
            $this->load->view('user/manageItem', $data);
            $this->load->view('template/footer', $data);
        }
    }
    
    /**
     * Liste des items empruntés
     */
    public function borrowed() {
        $this->load->model('Item_model', 'Item', TRUE);
        $this->load->model('User_model', 'User', TRUE);
        
        $items = $this->Item->getBorrow(array(
            'where' => array(
                'borrower_id' => $this->session->user['id']
            ),
            'orderBy' => 'borrow_state'
        ));
        
        $data = array(
            'active' => 'borrow',
            'css' => array(
                'user/listBorrowLent.css'
            ),
            'js' => array(
                'user/listLent.js'
            ),
            'items' => $items,
            'state' => $this->config->item('borrowState')['borrower']
        );
        
        $this->load->view('template/header', $data);
        $this->load->view('user/listBorrow', $data);
        $this->load->view('template/footer', $data);
    }
    
    /**
     * Liste des items prétés
     */
    public function lent() {
        $this->load->model('Item_model', 'Item', TRUE);
        
        if($this->input->is_ajax_request()) {
            $cmd = $this->input->post('cmd');
            $infos = array();
            $error = FALSE;
            
            // Acceptation de la demande
            if($cmd === 'accept') {
                $idBorrow = $this->input->post('idBorrow');
                if(intval($idBorrow) > 0) {
                    $infos = array(
                        'borrow_state' => 'TB'
                    );
                }
                else {
                    $error = TRUE;
                }
            }
            // Refus de la demande
            else if ($cmd === 'deny') {
                $idBorrow = $this->input->post('idBorrow');
                if(intval($idBorrow) > 0) {
                    $infos = array(
                        'borrow_state' => 'DE',
                        'borrow_deny' => $this->input->post('motive')
                    );
                }
                else {
                    $error = TRUE;
                }
            }
            // Item transmis au demandeur
            else if ($cmd === 'given') {
                $idBorrow = $this->input->post('idBorrow');
                $nbJour = $this->input->post('length');
                if(intval($nbJour) > 0 && intval($idBorrow) > 0) {
                    $infos = array(
                        'borrow_state' => 'BO',
                        'borrow_length' => $nbJour,
                        'borrow_date_begin' => date('Y-m-d'),
                        'borrow_date_end' => date('Y-m-d', strtotime('+' . $nbJour . ' days'))
                    );
                }
                else {
                    $error = TRUE;
                }
            }
            // Fin du prêt
            else if ($cmd === 'stop') {
                $idBorrow = $this->input->post('idBorrow');
                if(intval($idBorrow) > 0) {
                    $infos = array(
                        'borrow_state' => 'GB',
                        'borrow_date_end' => date('Y-m-d')
                    );
                }
                else {
                    $error = TRUE;
                }
            }
            // Modification/Demande de modification de la date de fin
            else if ($cmd === 'renew' || $cmd === 'askRenew') {
                $idBorrow = $this->input->post('idBorrow');
                $newDate = $this->input->post('newDate');
                
                if(preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/', $newDate) === 1) {
                    $borrow = $this->Item->getBorrow(array(
                        'where' => array(
                            'borrow_id' => $idBorrow
                        )
                    ));

                    if (count($borrow) === 1) {
                        $borrow = $borrow[0];
                        $beginDate = new DateTime($borrow['borrow_date_begin']);
                        $endDate = DateTime::createFromFormat('d/m/Y', $newDate);
                        $diffDate = $beginDate->diff($endDate);
                        
                        if($cmd === 'renew') {
                            $infos = array(
                                'borrow_date_end' => $endDate->format('Y-m-d'),
                                'borrow_length' => $diffDate->format('%a')
                            );
                        }
                        else if($cmd === 'askRenew') {
                            $infos = array(
                                'borrow_date_renew_asked' => $endDate->format('Y-m-d'),
                                'borrow_state' => 'AR'
                            );
                        }
                    }
                    else {
                        $error = TRUE;
                    }
                }
                else {
                    $error = TRUE;
                }
            }
            // Demande de modification de la date de fin acceptée
            else if($cmd === 'acceptRenew') {
                $idBorrow = $this->input->post('idBorrow');
                $borrow = $this->Item->getBorrow(array(
                    'where' => array(
                        'borrow_id' => $idBorrow
                    )
                ));

                if (count($borrow) === 1) {
                    $borrow = $borrow[0];
                    $beginDate = new DateTime($borrow['borrow_date_begin']);
                    $endDate = new DateTime($borrow['borrow_date_renew_asked']);
                    $diffDate = $beginDate->diff($endDate);

                    $infos = array(
                        'borrow_date_end' => $endDate->format('Y-m-d'),
                        'borrow_length' => $diffDate->format('%a'),
                        'borrow_state' => 'BO'
                    );
                }
                else {
                    $error = TRUE;
                }
            }
            // Demande de modification de la date de fin refusée
            else if($cmd === 'denyRenew') {
                $idBorrow = $this->input->post('idBorrow');
                $infos = array(
                    'borrow_state' => 'BO',
                    'borrow_date_renew_asked' => '2000-01-01'
                );
            }
            else {
                $error = TRUE;
            }
            
            if($error === FALSE) {
                $this->Item->setBorrow($infos, $this->input->post('idBorrow'));
            }
            else {
                echo 'ERROR';
            }
        }
        else {
            $data = array(
                'active' => 'lent',
                'css' => array(
                    'user/listBorrowLent.css'
                ),
                'js' => array(
                    'user/listLent.js'
                ),
                'items' => $this->Item->getBorrow(array(
                    'where' => array(
                        'lender_id' => $this->session->user['id']
                    ),
                    'notIn' => array(
                        'borrow_state' => array('DE', 'GB')
                    ),
                    'orderBy' => 'borrow_state'
                )),
                'state' => $this->config->item('borrowState')['lender']
            );

            $this->load->view('template/header', $data);
            $this->load->view('user/listLend', $data);
            $this->load->view('template/footer', $data);
        }
    }
    
    /**
     * Liste des items prétés
     */
    public function oldLent() {
        $this->load->model('Item_model', 'Item', TRUE);

        $data = array(
            'active' => 'oldLent',
            'css' => array(
                'user/listBorrowLent.css'
            ),
            'items' => $this->Item->getBorrow(array(
                'where' => array(
                    'lender_id' => $this->session->user['id'],
                    'borrow_state' => 'GB'
                ),
                'orderBy' => 'borrow_date_create DESC'
            )),
            'state' => $this->config->item('borrowState')['lender'],
            'oldLent' => TRUE
        );

        $this->load->view('template/header', $data);
        $this->load->view('user/listLend', $data);
        $this->load->view('template/footer', $data);
    }
    
    /**
     * Page d'accueil de la partie wishlist "Ma wishlist"
     */
    public function wishlist() {
        $this->load->model('Item_model', 'Item', TRUE);
        
        $data = array(
            'title' => 'Ma wishlist',
            'active' => 'wishlist',
            'css' => array(
                'listItem.css',
                'user/index.css'
            ),
            'js' => array(
                'listItem.js'
            ),
            'items' => $this->Item->getWishlist($this->session->user['id'])
        );
        
        $this->load->view('template/header', $data);
        $this->load->view('user/index', $data);
        $this->load->view('template/footer', $data);
    }
    
}
