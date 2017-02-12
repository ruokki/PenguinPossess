<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $uri = uri_string();
        
        if($this->session->user === NULL && !in_array($uri, array('home/login', 'home/createDB'))) {
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
                            'id' => $user['user_id'],
                            'name' => $user['user_name']
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
     * Créer la base de données
     */
    public function createDB() {
        $this->load->model('forge_model', 'Forge', TRUE);
        $this->Forge->setDB();
    }
}
