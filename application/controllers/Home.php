<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $uri = uri_string();
        
        if($this->session->user === NULL && !in_array($uri, array('home/login', 'home/createDB', 'home/createUser'))) {
            redirect('home/login');
        }
    }
    
    /**
     * Page de login
     */
    public function login() {
        
        $data = array(
            'title' => 'Connexion',
            'error' => FALSE,
            'css' => array(
                'home/login.css'
            )
        );
        
        // Vérification des infos saisies
        if($this->input->post()) {
            $this->load->model('User_model', 'User', TRUE);
            $name = $this->input->post('userName');
            $pass = $this->input->post('userPass');
            
            $user = $this->User->getUserFromName($name);
            
            if(count($user) === 1) {
                $user = $user[0];
                if(password_verify($pass, $user['user_pwd'])) {
                    $this->session->set_userdata(array(
                        'user' => array(
                            'id' => intval($user['user_id']),
                            'name' => intval($user['user_name']),
                            'role' => intval($user['role_id'])
                        )
                    ));
                    redirect('home/index');
                }
                else {
                    $data['error'] = 'Mauvais couple user/pass';
                }
            }
            else {
                $data['error'] = 'Mauvais couple user/pass';
            }
        }
        
        $this->load->view('template/header', $data);
        $this->load->view('home/login');
        $this->load->view('template/footer', $data);
    }
    
    /**
     * Page de demande de création d'un utilisateur
     */
    public function createUser() {
        $data = array(
            'title' => 'Demande de création',
            'error' => FALSE,
            'css' => array(
                'home/login.css'
            )
        );
        
        if($this->input->post()) {
            $this->load->model('User_model', 'User', TRUE);
            $name = $this->input->post('userName');
            $pass = $this->input->post('userPass');
            
            $user = $this->User->getUserFromName($name);
            
            if(count($user) > 0) {
                $data['error'] = 'Nom déjà utilisé';
            }
            else {
                $this->User->setUser(array(
                    'user_name' => $name,
                    'user_pwd' => password_hash($pass, PASSWORD_DEFAULT),
                    'role_id' => $this->config->item('user_id'),
                    'user_active' => 0
                ));
                
                redirect('home/login');
            }
        }
        
        $this->load->view('template/header', $data);
        $this->load->view('home/createUser');
        $this->load->view('template/footer', $data);
    }

    /**
     * Page d'accueil
     * Affichage des derniers items saisis
     */
    public function index() {
        $this->load->model('Item_model', 'Item', TRUE);
        
        $data = array(
            'active' => 'home',
            'items' => $this->Item->getItem(array(
                'limit' => 500
            )),
            'css' => array(
                'listItem.css'
            ),
            'js' => array(
                'listItem.js'
            )
        );
        
        $this->load->view('template/header', $data);
        $this->load->view('template/listItem', $data);
        $this->load->view('template/footer', $data);
    }
    
    /**
     * Affichage des items correspondant à une catégorie
     * @param String $id
     */
    public function category($id) {
        $this->load->model('Item_model', 'Item', TRUE);
        
        $data = array(
            'title' => '',
            'css' => array(
                'listItem.css'
            ),
            'js' => array(
                'listItem.js'
            ),
            'active' => $id,
            'items' => $this->Item->getItem(array(
                'orWhere' => array(
                    'category_id' => $id,
                    'subcategory_id' => $id
                ),
                'limit' => 500
            ))
        );
        
        $this->load->view('template/header', $data);
        $this->load->view('template/listItem', $data);
        $this->load->view('template/footer', $data);
    }
    
    /**
     * Affichage des items correspondant à un user
     * @param String $id
     */
    public function user($id) {
        $this->load->model('Item_model', 'Item', TRUE);
        
        $data = array(
            'title' => '',
            'css' => array(
                'listItem.css'
            ),
            'js' => array(
                'listItem.js'
            ),
            'active' => $id,
            'items' => $this->Item->getItem(array(
                'where' => array(
                    'U.user_id' => $id
                ),
                'limit' => 500
            ))
        );
        
        $this->load->view('template/header', $data);
        $this->load->view('template/listItem', $data);
        $this->load->view('template/footer', $data);
    }
    
    /**
     * Affichage du détail d'un item
     * @param Integer $id
     */
    public function item($id = 0) {
        if($id === 0) {
            redirect('home/index');
        }
        $this->load->model('item_model', 'Item', TRUE);
        $this->load->helper('formatCatName');
        
        $item = $this->Item->getItem(array(
            'where' => array(
                'I.item_id' => $id
            )
        ));
        
        if(count($item) === 0) {
            $item = array('error' => TRUE);
        }
        else {
            $item = $item[0];
        }
        
        $possessors = explode(',', $item['user_possess']);
        
        $item['possessors'] = array();
        foreach($possessors as $user) {
            $tmp = explode('|', $user);
            array_push(
                $item['possessors'], 
                '<a href="' . site_url('home/user/' . $tmp[0]) . '">' . $tmp[1] . '</a>'
            );
        }
        
        $data = array(
            'css' => array(
                'home/item.css'
            ),
            'js' => array(),
            'item' => $item,
            'typeView' => 'print'
        );
        
        $this->load->view('template/header', $data);
        $this->load->view('home/item', $data);
        $this->load->view('template/footer', $data);
    }
    
    /**
     * Gestion des liens entre utilisateur et item
     */
    public function managePossess() {
        if($this->input->is_ajax_request()) {
            $this->load->model('item_model', 'Item', TRUE);
            
            $cmd = $this->input->post('cmd');
            $id = $this->input->post('item');
            
            if($cmd === 'add') {
                $this->Item->setItemUserLink($id, $this->session->user['id']);
            }
            else if($cmd === 'del') {
                $this->Item->delItemUserLink($id, $this->session->user['id']);
            }
        }
    }

    /**
     * Créer la base de données
     */
    public function createDB() {
        $this->load->model('forge_model', 'Forge', TRUE);
        $this->Forge->setDB();
    }
    
    /**
     * Déconnexion de l'utilisateur en cours
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('home/login');
    }
}
