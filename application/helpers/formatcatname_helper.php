<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Formatte le nom d'une catégorie pour récupérer le HTML correspondant dans 
 * template/complInfo
 * @param type $category
 * @return String
 */
function formatCatName($category) {
    $category = str_replace(array(
        ' ',
        'é',
        'ô'
    ), array(
        '',
        'e',
        'o'
    ), $category);
    $category = strtolower($category);

    return trim($category);
}