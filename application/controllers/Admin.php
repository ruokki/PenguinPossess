<?php

/**
 * Description of Admin
 *
 * @author Ruokki
 */
class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        if($this->session->user === NULL) {
            redirect('home/login');
        }
        if($this->session->user['role'] !== $this->config->item('admin_id')) {
            redirect('home/index');
        }
    }
    
    /**
     * Page d'admin
     * Liste les utilisateurs existants
     */
    public function index() {
        $this->load->model('User_model', 'User', TRUE);
        
        if($this->input->post()) {
            $post = $this->input->post('admin');
            
            foreach($post as $idUser => $info) {
                if(isset($info['user_active']) && $info['user_active'] === 'on') {
                    $info['user_active'] = 1;
                }
                else {
                    $info['user_active'] = 0;
                }
                $this->User->setUser($info, $idUser);
            }
        }
        
        $data = array(
            'title' => 'Administration',
            'active' => 'admin',
            'users' => $this->User->getUser(),
            'roles' => $this->User->getRole(),
            'css' => array(
                'admin/index.css'
            )
        );
        
        $this->load->view('template/header', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('template/footer', $data);
    }
    
}
