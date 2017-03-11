<?php

/**
 * Description of Api
 *
 * @author Ruokki
 */
class Api extends CI_Controller {
    
    public function index() {
        if($this->input->is_ajax_request()) {
            $this->load->model('Token_model', 'Token', TRUE);
            $cmd = $this->input->post('cmd');
            $return = array(
                'error' => FALSE,
                'errorTxt' => ''
            );
           
            if($cmd === 'login') {
                $this->load->model('User_model', 'User', TRUE);
                $name = $this->input->post('user');
                $pass = $this->input->post('pwd');

                $user = $this->User->getUserFromName($name);

                if (count($user) === 1) {
                    $user = $user[0];
                    if (password_verify($pass, $user['user_pwd'])) {
                        $token = $this->generateToken();
                        $this->Token->setToken(0, array(
                            'token_key' => $token,
                            'user_id' => $user['user_id'],
                            'token_ip' => $this->input->ip_address(),
                            'token_date_create' => date('Y-m-d H:i')
                        ));
                        
                        $return['token'] = $token;
                    }
                    else {
                        $return['error'] = TRUE;
                        $return['errorTxt'] = 'Mauvais couple user/pass';
                    }
                }
                else {
                    $return['error'] = TRUE;
                    $return['errorTxt'] = 'Mauvais couple user/pass';
                }
            }
            else {
               $token = $this->getInfoToken();
            }
            
            echo json_encode($return);
        }
    }
   
   /**
    * Génère un token unique
    * @return String
    */
   private function generateToken() {
       return md5(uniqid(rand(), true));
   }
   
   /**
    * 
    */
   private function getInfoToken() {
   }
   
}
