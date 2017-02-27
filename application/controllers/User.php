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
     *  - Ajout d'un produit
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
     * Gestion des infos d'un item d'un user
     *  - Ajout d'un item
     *  - Édition d'un item
     */
    public function manageItem($cmd = 'create', $id = 0) {
        $this->load->model('Category_model', 'Category', TRUE);
        $this->load->model('Item_model', 'Item', TRUE);
        $this->load->helper('formatcatname');
        
        if($this->input->is_ajax_request()) {
            $cmd = $this->input->post('cmd');
            $return = array();
            
            if($cmd === 'getSub') {
                $return = $this->Category->getCategory($this->input->post('category'));
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
                'title' => ($cmd === 'create' ? 'Création' : 'Modification') .  ' item',
                'active' => 'user',
                'cmd' => $cmd,
                'css' => array(
                    'user/manageItem.css'
                ),
                'js' => array(
                    'user/manageItem.js'
                ),
                'result' => array(),
                'typeView' => 'form'
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
                }
                else {
                    $item = $this->input->post();
                    $oldItem = array();
                    $isNew = FALSE;

                    // Gestion des pistes pour un album
                    if(isset($item['track'])) {
                        $item['item_tracklist'] = implode('|', $item['track']);
                        unset($item['track']);
                    }

                    // Gestion de l'id
                    $idItem = 0;
                    if(isset($item['item_id'])) {
                        $idItem = $item['item_id'];
                        unset($item['item_id']);
                        $oldItem = $this->Item->getItem(array(
                            'where' => array(
                                'I.item_id' => $idItem
                            )
                        ));
                        $oldItem = $oldItem[0];
                    }
                    else {
                        $isNew = TRUE;
                        // Date création
                        $item['item_date_create'] = date('Y-m-d H:i:s');
                    }

                    if($idItem !== 0) {
                        $userPossess = explode(',', $oldItem['user_id_possess']);
                    }
                    else {
                        $userPossess = array($this->session->user['id']);
                    }

                    // Gestion de l'upload de l'image
                    $config = array();
                    $this->load->library('upload', $config);

                    $config['upload_path']          = './asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'];
                    $config['allowed_types']        = 'gif|jpg|png';
                    $config['max_size']             = 2048;
                    $config['max_width']            = 1260;
                    $config['max_height']           = 1260;
                    $config['file_ext_tolower']     = TRUE;
                    $config['file_name']            = uniqid($this->session->user['id'] . '_');

                    $this->upload->initialize($config);
                    // Si plusieurs utilisateurs possèdent l'item, on bloque l'édition 
                    // et on attend la validation par un admin*
                    if(count($userPossess) > 1) {
                        $this->load->helper('file');
                        $validateFolder = $this->config->item('validateFolder');

                        if(!is_dir($validateFolder['root'] . '/' . $validateFolder['img'])) {
                            mkdir($validateFolder['root'] . '/' . $validateFolder['img'], 0777, TRUE);
                        }
                        $config['upload_path'] = $validateFolder['root'] . '/' . $validateFolder['img'];
                        $this->upload->initialize($config);
                        $this->upload->do_upload('item_img');

                        write_file($validateFolder['root'] . '/pendingEdit', serialize($item) . '##', 'a');
                    }
                    else {

                        // On tente d'insérer le produit
                        if($idItem === 0) {
                            $item['item_img'] = '';
                        }
                        $idItem = $this->Item->setItem($item, $idItem);

                        // Si l'insertion se fait, on finit l'upload du fichier
                        if(!is_dir($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, TRUE);
                        }

                        if($idItem === 0) {
                            if (!$this->upload->do_upload('item_img')) {
                                $data['result'] = array('error' => TRUE);
                                $data['errors'] = array('Veuiller sélectionner une image pour cette item');
                            }
                            else {
                                $data['result'] = array('success' => TRUE);
                                $idItem = $this->Item->setItem(array('item_img' => $this->upload->data('file_name')), $idItem);
                            }
                        }
                        else {
                            if ($this->upload->do_upload('item_img')) {
                                if(isset($oldItem['item_img']) && trim($oldItem['item_img']) !== '') {
                                    unlink($config['upload_path'] . '/' . $oldItem['item_img']);
                                }
                                $idItem = $this->Item->setItem(array('item_img' => $this->upload->data('file_name')), $idItem);
                            }
                            $data['result'] = array('success' => TRUE);
                        }

                        if($isNew === TRUE) {
                            $this->Item->setItemUserLink($idItem, $this->session->user['id']);
                        }
                    }
                }
            }
            
            if($id !== 0) {
                $item = $this->Item->getItem(array(
                    'where' => array(
                        'I.item_id' => $id
                    )
                ));
                
                if(count($item) > 0) {
                    $data['item'] = $item[0];
                    $data['subCategories'] = $this->Category->getCategory($data['item']['category_id']);
                    
                    $userPossess = explode(',', $data['item']['user_id_possess']);
                    if(!in_array($this->session->user['id'] . '', $userPossess)) {
                        redirect('home/index');
                    }
                    else {
                        if(count($userPossess) > 1) {
                            $data['multiUser'] = true;
                        }
                    }
                }
                else {
                    
                }
            }
            
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

        foreach($items as &$item) {
            $lenders = substr($item['lender_id'], 1, strlen($item['lender_id']) - 2);
            $lendersName = $this->User->getLender(explode(',', $lenders));
            if($lendersName === FALSE) {
                $item['lenders_name'] = '';
            }
            else {
                $item['lenders_name'] = $lendersName['names'];
            }
        }
        
        $data = array(
            'css' => array(
                'user/listBorrowLent.css'
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
                        'borrow_state' => 'TB',
                        'lender_id' => ',' . $this->session->user['id'] . ','
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
                        'lender_id' => ',' . $this->session->user['id'] . ',',
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
            // Modification de la date de fin
            else if ($cmd === 'renew') {
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

                        $infos = array(
                            'borrow_date_end' => $endDate->format('Y-m-d'),
                            'borrow_length' => $diffDate->format('%a')
                        );
                    }
                    else {
                        $error = TRUE;
                    }
                }
                else {
                    $error = TRUE;
                }
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
                'css' => array(
                    'user/listBorrowLent.css'
                ),
                'js' => array(
                    'user/listLent.js'
                ),
                'items' => $this->Item->getBorrow(array(
                    'like' => array(
                        'lender_id' => ',' . $this->session->user['id'] . ','
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
    
}
