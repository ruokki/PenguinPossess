<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Id du role "Admin" dans la base
$config['admin_id'] = 1;

// Id du role "Utilisateur" dans la base
$config['user_id'] = 2;

// Dossier contenant les fichiers des modifs en attente de validation
$config['validateFolder'] = array(
    'root' => './asset/userfile/validate',
    'img' => 'img'
);

// Version de l'application
$config['version'] = '0.1';

// État des demandes d'emprunt (lisible pour l'homme) en fonction du type
// de l'utilisateur (emprunteur ou prêteur)
$config['borrowState'] = array(
    'borrower' => array(
        'WA' => 'En attente de réponse',
        'TB' => 'Demande acceptée',
        'BO' => 'Item emprunté',
        'GB' => 'Item rendu'
    ),
    'lender' => array(
        'WA' => 'En attente de réponse',
        'TB' => 'À prêter',
        'BO' => 'Item prété',
        'GB' => 'Item récupéré'
    )
);