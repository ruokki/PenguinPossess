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