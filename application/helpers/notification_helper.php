<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gestion des notifications de prêts et d'emprunts
 * @return String
 */
function getNotification($idUser) {
    $CI = get_instance();
    
    $CI->load->model('user_model', 'User', TRUE);

    return $CI->load->view('template/notif', array(
        'borrow' => $CI->User->getNbBorrowNotif($idUser),
        'exp' => $CI->User->getExpiringBorrow($idUser)
    ), TRUE);
}