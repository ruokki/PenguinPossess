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
        $this->load->model('item_model', 'Item', TRUE);
        
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
                    'user_id' => $this->session->user['id']
                )
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
    public function manageItem($cmd = 'create') {
        $this->load->model('category_model', 'Category', TRUE);
        $this->load->model('item_model', 'Item', TRUE);
        
        if($this->input->is_ajax_request()) {
            $cmd = $this->input->post('cmd');
            $return = array();
            
            if($cmd === 'getSub') {
                $return = $this->Category->getCategory($this->input->post('category'));
            }
            else if ($cmd === 'getCompl') {
                $category = $this->input->post('category');
                $return['html'] = '';
                
                $return['html'] = $this->load->view('template/complInfo/' . $category, array(), TRUE);
            }
            
            echo json_encode($return);
        }
        else {
            $data = array(
                'categories' => $this->Category->getCategory(),
                'title' => ($cmd === 'create' ? 'Création' : 'Modification') .  ' item',
                'active' => 'user',
                'cmd' => $cmd,
                'js' => array(
                    'user/manageItem.js'
                ),
                'result' => array()
            );
            
            // Enregistrement de l'item
            if($this->input->post()) {
                $item = $this->input->post();
                $isNew = FALSE;
                
                // Gestion des pistes pour un album
                if(isset($item['track'])) {
                    $item['item_tracklist'] = implode(',', $item['track']);
                    unset($item['track']);
                }
                
                // Date création
                $item['item_date_create'] = date('Ymd H:m:s');
                
                // Gestion de l'id
                $idItem = 0;
                if(isset($item['item_id'])) {
                    $idItem = $item['item_id'];
                    unset($item['item_id']);
                }
                else {
                    $isNew = TRUE;
                }
                
                // Gestion de l'upload de l'image
                $item['item_img'] = '';
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
                
                // On tente d'insérer le produit
                $item['item_img'] = '';
                $idItem = $this->Item->setItem($item, $idItem);
                
                // Si l'insertion se fait, on finit l'upload du fichier
                if(!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }
                
                if (!$this->upload->do_upload('item_img')) {
                    $data['result'] = array('error' => TRUE);
                }
                else {
                    $data['result'] = array('success' => TRUE);
                }
                $idItem = $this->Item->setItem(array('item_img' => $this->upload->data('file_name')), $idItem);
                
                if($isNew === TRUE) {
                    $this->Item->setItemUserLink($idItem, $this->session->user['id']);
                }
            }

            $this->load->view('template/header', $data);
            $this->load->view('user/manageItem', $data);
            $this->load->view('template/footer', $data);
        }
    }
    
}
