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
        $data['title'] = 'Mon compte';
        $data['active'] = 'user';
        
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
                )
            );
            $this->load->view('template/header', $data);
            $this->load->view('user/manageItem', $data);
            $this->load->view('template/footer', $data);
        }
    }
    
}
