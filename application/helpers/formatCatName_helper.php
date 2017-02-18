<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Formatte le nom d'une catégorie pour récupérer le HTML correspondant dans 
 * template/complInfo
 * @param type $category
 * @return String
 */
function formatCatName($category) {
    $category = strtolower($category);
    $category = str_replace(array(
        ' ',
        'é'
    ), array(
        '',
        'e'
    ), $category);
    
    return trim($category);
}