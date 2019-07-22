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
$config['version'] = '0.2';

// État des demandes d'emprunt (lisible pour l'homme) en fonction du type
// de l'utilisateur (emprunteur ou prêteur)
$config['borrowState'] = array(
    'borrower' => array(
        'WA' => 'En attente de réponse',
        'TB' => 'Demande acceptée',
        'BO' => 'Emprunt en cours',
        'AR' => 'Rallonge demandée',
        'GB' => 'Item rendu',
        'DE' => 'Demande refusée'
    ),
    'lender' => array(
        'WA' => 'En attente de réponse',
        'TB' => 'À prêter',
        'BO' => 'Item prété',
        'AR' => 'Rallonge demandée',
        'GB' => 'Item récupéré',
        'DE' => 'Demande refusée'
    )
);

// Heures durant laquel le token de nouveau mot de passe est valide
$config['newPassValidateTime'] = 2;

// Catégories gérées comme des collections
$config['collectionCategories'] = array(
    'livre',
    'comics',
    'manga',
    'bd'
);