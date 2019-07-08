<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $uri = uri_string();
        $tmp = explode('/', $uri);
        
        if($this->session->user === NULL && !in_array($tmp[1], array('login', 'createDB', 'createUser', 'forgotPass', 'newPass'))) {
            redirect('home/login');
        }
    }
    
    /**
     * Page de login
     */
    public function login($msg = '') {
        
        $data = array(
            'title' => 'Connexion',
            'errors' => FALSE,
            'css' => array(
                'home/login.css'
            ),
            'js' => array(
                'home/login.js'
            ),
            'msg' => ''
        );
        
        $msg = $this->session->flashdata('msg');
        if($msg === 'sent') {
            $data['msg'] = 'Email de réinitialisation envoyé';
        }
        else if($msg === 'reinit') {
            $data['msg'] = 'Mot de passe réinitialisé';
        }
        
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
                    $data['errors'] = array('Mauvais couple user/pass');
                }
            }
            else {
                $data['errors'] = array('Mauvais couple user/pass');
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

                $user = $this->User->getUserFromName(trim($futureUser['user_name']));
                $userMail = $this->User->getUserFromEmail(trim($futureUser['user_email']));
                $totalUser = $this->User->getNbUser();

                if (count($user) > 0) {
                    $data['errors'] = array('Nom déjà utilisé');
                }
                else if (count($userMail) > 0) {
                    $data['errors'] = array('Email déjà utilisé');
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
     * Page de demande de réinitialisation du mot de passe
     */
    public function forgotPass() {
        $this->load->library('form_validation');
        
        $data = array(
            'title' => 'Réinitialisation du mot de passe',
            'error' => FALSE,
            'css' => array(
                'home/login.css'
            )
        );
        
        if($this->input->post()) {
            $this->load->model('User_model', 'User', TRUE);
            $user = $this->input->post();
            
            $config = array(
                    array(
                        'field' => 'user_email',
                        'label' => 'Email',
                        'rules' => 'required|valid_email'
                    )
                );
                
                $this->form_validation->set_rules($config);
                
                if($this->form_validation->run() === FALSE) {
                    $data['errors'] = $this->form_validation->error_array();
                }
                else {
                    $data['success'] = TRUE;
                    $user = $this->User->getUserFromEmail($user['user_email']);
                    
                    if(count($user) > 0) {
                        $token = uniqid();
                        $this->User->setUser(array(
                            'user_token_new_pass' => $token,
                            'user_date_new_pass' => date('Y-m-d H:i:s')
                        ), $user[0]['user_id']);
                        
                        $this->load->library('email');
                        $config['mailtype'] = 'HTML';
                        $this->email->initialize($config);
                        
                        $this->email->from('noreply@penguin.net');
                        $this->email->to($user['user_email']);
                        $this->email->subject('Demande de réinitialisation du mot de passe');
                        $this->email->message(
                            'Vous avez effectué une demande de réinitialisation de votre mot de passe.<br />' .
                            'Pour ce faire, <a href="' . site_url('home/newPass/' . $token) . '">cliquez ici !</a><br/>' . 
                            'Ce lien est valide pendant ' . $this->config->item('newPassValidateTime') . 'h. <br/><br/>' .
                            "Si vous n'avez pas fait de demande, merci d'ignorer cet email."
                        );
                        $this->session->set_flashdata('msg', 'sent');
                        redirect('home/login');
                    }
            }
        }
        
        $this->load->view('template/header', $data);
        $this->load->view('home/forgotPass');
        $this->load->view('template/footer', $data);
    }
    
    /**
     * Modification du mot de passe
     * @param String $token
     */
    public function newPass($token = '') {
        if($token === '') {
            redirect('home/login');
        }
        
        $this->load->library('form_validation');
        $this->load->model('User_model', 'User', TRUE);
        
        $user = $this->User->getUserFromToken($token);
        
        if(count($user) > 0) {
            $user = $user[0];
        }
        else {
            redirect('home/login');
        }
        
        $data = array(
            'title' => 'Nouveau mot de passe',
            'error' => FALSE,
            'css' => array(
                'home/login.css'
            )
        );
        
        if($this->input->post()) {
            $config = array(
                    array(
                        'field' => 'user_pwd',
                        'label' => 'Mot de passe',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'user_pwd_confirm',
                        'label' => 'de confirmation du mot de passe',
                        'rules' => 'required|matches[user_pwd]'
                    )
            );
                
            $this->form_validation->set_rules($config);

            if($this->form_validation->run() === FALSE) {
                $data['errors'] = $this->form_validation->error_array();
            }
            else {
                $this->User->setUser(array(
                    'user_pwd' => password_hash($this->input->post('user_pwd'), PASSWORD_DEFAULT),
                    'user_token_new_pass' => NULL,
                    'user_date_new_pass' => '0000-00-00'
                ), $user['user_id']);
                $this->session->set_flashdata('msg', 'reinit');
                redirect('home/login');
            }
        }
        else {
            $tokenDate = new DateTime($user['user_date_new_pass']);
            $now = new DateTime();
            $diffDate = $tokenDate->diff($now);
            if($diffDate->h > $this->config->item('newPassValidateTime')) {
                redirect('home/login');
            }
        }
        
        $this->load->view('template/header', $data);
        $this->load->view('home/newPass');
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
        
        // Il y a au moins un possesseur
        if($possessors[0] !== '') {
            foreach ($possessors as $user) {
                $tmp = explode('|', $user);
                array_push(
                        $item['possessors'], '<a href="' . site_url('home/user/' . $tmp[0]) . '">' . $tmp[1] . '</a>'
                );
            }
        }
        
        $data = array(
            'css' => array(
                'home/item.css',
                'listItem.css'
            ),
            'js' => array(
                'listItem.js'
            ),
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
            array_push($data['css'], 'user/manageItem.css');
            array_push($data['js'], 'user/manageItem.js');
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
            
            if($cmd === 'addPossess' || $cmd === 'delPossess') {
                // Ajoute la possession d'un item
                if($cmd === 'addPossess') {
                    $this->Item->setItemUserLink($id, $this->session->user['id']);
                }
                // Enlève la possession d'un item
                else if($cmd === 'delPossess') {
                    $this->Item->delItemUserLink($id, $this->session->user['id']);
                }
                
                $item = $this->Item->getItem(array(
                    'where' => array('I.item_id' => $id)
                ));
                
                $return = array(
                    'html' => $this->load->view('template/actionItem', array('item' => $item[0]), TRUE)
                );
            }
            // Ajoute une demande d'emprunt
            else if($cmd === 'addBorrow') {
                // On va récupérer les possesseurs de l'item
                $item = $this->Item->getItem(array(
                    'where' => array(
                        'I.item_id' => $id
                    )
                ));
                
                $item = $item[0];
                $possessorLetBorrow = explode(',', $item['user_let_borrow']);

                // On va regarder combien autorise le prêt de leur item
                $tmp = array();
                $possessors = array();
                $idToName = array();
                $listPossessors = array();
                
                for($i = 0, $len = count($possessorLetBorrow); $i < $len; $i++) {
                    $tmp = explode('|', $possessorLetBorrow[$i]);
                    if(intval($tmp[1]) === 1) {
                        array_push($possessors, $tmp[0]);
                        array_push($listPossessors, $tmp[0] . '|' . $tmp[2]);
                    }
                    $idToName[$tmp[0]] = $tmp[2];
                }
                
                $nbPossessor = count($possessors);
                if($nbPossessor === 1) {
                    // On va vérifier qu'une demande n'est pas déjà en cours pour le demandeur et l'item concerné
                    $isBorrow = $this->Item->getBorrow(array(
                        'where' => array(
                            'B.item_id' => $id,
                            'borrower_id' => $this->session->user['id'],
                            'lender_id' => $possessors[0],
                        ),
                        'notIn' => array(
                            'borrow_state' => 'GB'
                        )
                    ));

                    if(count($isBorrow) === 0) {
                        $this->Item->setBorrow(array(
                            'item_id' => $id,
                            'borrower_id' => $this->session->user['id'],
                            'borrow_state' => 'WA',
                            'borrow_date_create' => date('Y-m-d'),
                            'lender_id' => $possessors[0],
                            'borrow_date_renew_asked' => '1950-01-01'
                        ));

                        $return = array(
                            'created' => TRUE,
                            'possessors' => $idToName[$possessors[0]]
                        );
                    }
                    else {
                        $return = array(
                            'error' => TRUE,
                            'text' => 'Une demande est déjà en cours pour cet item auprès de ' . $idToName[$possessors[0]]
                        );
                    }
                }
                else if($nbPossessor <= 0) {
                    $return = array(
                        'error' => TRUE,
                        'text' => "Aucun item n'est disponible pour le prêt"
                    );
                }
                else {
                    $return = array(
                        'created' => FALSE,
                        'possessors' => $listPossessors
                    );
                }
            }
            // User autorise le prêt sur son item
            else if($cmd === 'letBorrow') {
                $this->Item->editItemUserLink(
                    $id, 
                    $this->session->user['id'],
                    array(
                        'item_borrowable' => 1
                    )
                );
            }
            // User refuse le prêt sur son item
            else if($cmd === 'stopBorrow') {
                $this->Item->editItemUserLink(
                    $id, 
                    $this->session->user['id'],
                    array(
                        'item_borrowable' => 0
                    )
                );
            }
            // Création d'une demande après sélection du user dans la liste des possesseurs
            else if ($cmd === 'createBorrow') {
                $user = $this->input->post('user');
                // On va vérifier qu'une demande n'est pas déjà en cours pour le demandeur et l'item concerné
                $isBorrow = $this->Item->getBorrow(array(
                    'where' => array(
                        'B.item_id' => $id,
                        'borrower_id' => $this->session->user['id'],
                        'lender_id' => $user,
                    ),
                    'notIn' => array(
                        'borrow_state' => 'GB'
                    )
                ));

                if(count($isBorrow) === 0) {
                    $this->Item->setBorrow(array(
                        'item_id' => $id,
                        'borrower_id' => $this->session->user['id'],
                        'borrow_state' => 'WA',
                        'borrow_date_create' => date('Y-m-d'),
                        'lender_id' => $user,
                        'borrow_date_renew_asked' => '1950-01-01'
                    ));

                    $return = array(
                        'error' => FALSE
                    );
                }
                else {
                    $return = array(
                        'error' => TRUE
                    );
                }
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
