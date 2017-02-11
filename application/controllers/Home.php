<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $uri = uri_string();
        
        if($this->session->user === NULL && $uri !== 'home/login') {
            redirect('home/login');
        }
    }

    /**
     * Home page
     */
    public function index() {
        $this->load->view('template/header');
        $this->load->view('home/index');
        $this->load->view('template/footer');
    }
    
    /**
     * Page de login
     */
    public function login() {
        
        $data['title'] = 'Connexion';

        $this->load->view('template/header', $data);
        $this->load->view('home/login');
        $this->load->view('template/footer', $data);
    }

    /**
     * Créer la base de données
     */
    public function createDB() {
        $this->load->model('forge_model', 'Forge', TRUE);
        $this->Forge->setDB();
    }
}
