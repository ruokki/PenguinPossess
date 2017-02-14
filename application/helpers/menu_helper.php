<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Génère le HTML pour le top menu
 * @return String
 */
function generateMainMenu($activeCat = '') {
    $CI = get_instance();
    
    $CI->load->model('category_model', 'Cat', TRUE);
    
    $parents = $CI->Cat->getCategory();
    $final = array();
    
    foreach($parents as $cat) {
        $html = '';
        $param = array(
            'id' => $cat['category_id'], 
            'name' => $cat['category_name'], 
            'icon' => $cat['category_icon'],
            'subCat' => '',
            'active' => $activeCat
        );
        $children = $CI->Cat->getCategory($cat['category_id']);
        
        foreach($children as $childCat) {
            $param['subCat'] .= $CI->load->view('template/menu/child_category', array(
                'id'    => $childCat['category_id'],
                'name'  => $childCat['category_name'],
                'icon' => $childCat['category_icon'],
                'active' => $activeCat
            ), TRUE);
        }
        
        $html .= $CI->load->view('template/menu/parent_category', $param, TRUE);
        
        array_push($final, $html);
    }
    
    return $CI->load->view('template/main-menu', array('categories' => $final, 'active' => $activeCat), TRUE);
}