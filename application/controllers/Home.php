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
        $this->load->library('form_validation');
        
        $data = array(
            'title' => 'Demande de création',
            'error' => FALSE,
            'css' => array(
                'home/login.css'
            )
        );
        
        if($this->input->post()) {
            $this->load->model('User_model', 'User', TRUE);
            $futureUser = $this->input->post();
            
            $config = array(
                    array(
                        'field' => 'user_name',
                        'label' => 'Nom',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'user_firstname',
                        'label' => 'Prénom',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'user_email',
                        'label' => 'Email',
                        'rules' => 'required|valid_email'
                    ),
                    array(
                        'field' => 'user_pwd',
                        'label' => 'Mot de passe',
                        'rules' => 'required'
                    ),
                );
                
                $this->form_validation->set_rules($config);
                
                if($this->form_validation->run() === FALSE) {
                    $data['errors'] = $this->form_validation->error_array();
                }
                else {
                    
                    $user = $this->User->getUserFromName($futureUser['user_name']);
                $totalUser = $this->User->getNbUser();

                if (count($user) > 0) {
                    $data['errors'] = array('Nom déjà utilisé');
                }
                else if ($totalUser > 10) {
                    $data['errors'] = array("Nombre d'utilisateur max atteint");
                }
                else {
                    $futureUser['user_pwd'] = password_hash($futureUser['user_pwd'], PASSWORD_DEFAULT);
                    $futureUser['role_id'] = $this->config->item('user_id');
                    $futureUser['user_active'] = 1;

                    $this->User->setUser($futureUser);

                    redirect('home/login');
                }
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
                'limit' => 500,
                'orderBy' => 'item_date_create DESC'
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
                    'I.category_id' => $id,
                    'I.subcategory_id' => $id
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
        $this->load->model('Item_model', 'Item', TRUE);
        $this->load->helper('formatcatname');
        
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
            'title' => $item['item_name'],
            'item' => $item,
            'typeView' => 'print'
        );
        
        $this->load->view('template/header', $data);
        $this->load->view('home/item', $data);
        $this->load->view('template/footer', $data);
    }
    
    /**
     * Page de recherche
     * Utilisé aussi pour récupérer les infos du champ de recherche dans le top-menu
     */
    public function search() {
        $this->load->model('Item_model', 'Item', TRUE);
        $this->load->model('Category_model', 'Category', TRUE);
        
        $data = array(
            'active' => 'search',
            'categories' => $this->Category->getCategory(),
            'css' => array(
                'listItem.css'
            ),
            'js' => array(
                
            )
        );
        $view = 'search';
        
        if($this->input->post()) {
            array_push($data['css'], 'home/result.css');
            array_push($data['js'], 'listItem.js');
            
            $postSearch = $this->input->post();
            $search = array();
            
            foreach($postSearch as $field => $value) {
                $tmp = 'I.' . $field;
                $search[$tmp] = $value;
            }
            
            $data['result'] = $data['items'] = $this->Item->getItem(array(
                'like' => $search
            ));
            $view = 'result';

            // La requête vient du champ de recherche, on envoie juste les 
            // infos en JSON et on arète le traitement
            if($this->input->is_ajax_request()) {
                echo json_encode($data);
                return;
            }
        }
        else {
            array_push($data['css'], 'home/search.css');
            array_push($data['js'], 'home/search.js');
        }
        
        $this->load->view('template/header', $data);
        $this->load->view('home/' . $view, $data);
        $this->load->view('template/footer', $data);
    }
    
    /**
     * Gestion des liens entre utilisateur et item
     */
    public function managePossess() {
        if($this->input->is_ajax_request()) {
            $this->load->model('Item_model', 'Item', TRUE);
            
            $cmd = $this->input->post('cmd');
            $id = $this->input->post('item');
            $return = '';
            
            // Ajoute la possession d'un item
            if($cmd === 'addPossess') {
                $this->Item->setItemUserLink($id, $this->session->user['id']);
            }
            // Enlève la possession d'un item
            else if($cmd === 'delPossess') {
                $this->Item->delItemUserLink($id, $this->session->user['id']);
            }
            // Ajoute une demande d'emprunt
            else if($cmd === 'addBorrow') {
                $this->Item->setBorrow(array(
                    'item_id' => $id,
                    'borrower_id' => $this->session->user['id'],
                    'borrow_state' => 'WA',
                    'borrow_date_create' => date('Y-m-d')
                ));
            }
            
            echo json_encode($return);
        }
    }

    /**
     * Créer la base de données
     */
    public function createDB() {
        $this->load->model('Forge_model', 'Forge', TRUE);
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
