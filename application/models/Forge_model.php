<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of forge_model
 *
 * @author Ruokki
 */
class Forge_model extends CI_Model {
    
    private $attributes = array('ENGINE' => 'InnoDB');
    
    /**
     * Execute l'ensemble des fonctions permettant de créer ou mettre à jour la base de données
     */
    public function setDB() {
        $this->load->dbforge();
        
        // on essaie d'abord de créer les tables
        $this->createUser();
        $this->createRole();
        $this->createCategory();
        $this->createItem();
        $this->createCollection();
        $this->createTag();
        $this->createItemTag();
        $this->createItemUser();
        $this->createBorrow();
        $this->createToken();
        $this->createWish();
        
        // On tente de les modifier ensuite
        $this->alterUser();
    }
    
    /**
     * Création de la table User
     */
    public function createUser() {
        $fields = array(
            'user_id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE
            ),
            'role_id' => array(
                'type' => 'INT',
                'default' => '1'
            ),
            'user_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'user_firstname' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'user_email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'user_pwd' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'user_active' => array(
                'type' => 'INT',
                'constraint' => '1'
            ),
            'user_token_new_pass' => array(
                'type' => 'VARCHAR',
                'constraint' => '13'
            ),
            'user_date_new_pass' => array(
                'type' => 'DATETIME'
            ),
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('user_id', TRUE);
        $created = $this->dbforge->create_table('user', TRUE, $this->attributes);
        
//        if($created === TRUE) {
//            $this->populateUser();
//        }
    }
    
    /**
     * Modification de la table User si déjà existante
     */
    public function alterUser() {
        if(!$this->db->field_exists('user_token_new_pass', 'user')) {
            $this->dbforge->add_column('user', array(
                    'user_token_new_pass' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '13'
                )
            ));
        }
        
        if(!$this->db->field_exists('user_date_new_pass', 'user')) {
            $this->dbforge->add_column('user', array(
                    'user_date_new_pass' => array(
                    'type' => 'DATETIME'
                )
            ));
        }
    }
    
    /**
     * Création de la table Role
     */
    public function createRole() {
        $fields = array(
            'role_id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE
            ),
            'role_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('role_id', TRUE);
        $created = $this->dbforge->create_table('role', TRUE, $this->attributes);
        
//        if($created === TRUE) {
//            $this->populateRole();
//        }
    }
        
    /**
     * Création de la table Category
     */
    public function createCategory() {
        $fields = array(
            'category_id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE
            ),
            'category_parent_id' => array(
                'type' => 'INT',
                'null' => TRUE,
                'default' => NULL
            ),
            'category_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'category_icon' => array(
                'type' => 'VARCHAR',
                'constraint' => '25'
            ),
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('category_id', TRUE);
        $created = $this->dbforge->create_table('category', TRUE, $this->attributes);
        
//        if($created === TRUE) {
//            $this->populateCategory();
//        }
    }
    
    /**
     * Création de la table Item
     */
    public function createItem() {
        $fields = array(
            'item_id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE
            ),
            'category_id' => array(
                'type' => 'INT'
            ),
            'subcategory_id' => array(
                'type' => 'INT'
            ),
            'collection_id' => array(
                'type' => 'INT',
            ),
            'item_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'item_descript' => array(
                'type' => 'TEXT'
            ),
            'item_date_create' => array(
                'type' => 'DATETIME'
            ),
            'item_img' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'item_creator' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'item_release' => array(
                'type' => 'VARCHAR',
                'constraint' => '4'
            ),
            'item_editor' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'item_tracklist' => array(
                'type' => 'TEXT'
            ),
            'item_siblings' => array(
                'type' => 'INT'
            ),
            'item_idx_sibling' => array(
                'type' => 'INT'
            ),
            'item_universe' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'item_length' => array(
                'type' => 'INT'
            ),
            'item_seasons' => array(
                'type' => 'INT'
            ),
            'item_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('item_id', TRUE);
        $created = $this->dbforge->create_table('item', TRUE, $this->attributes);
    }
    
    /**
     * Création de la table Collection
     */
    public function createCollection() {
        $fields = array(
            'collection_id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE
            ),
            'collection_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'collection_length' => array(
                'type' => 'VARCHAR',
                'constraint' => '4'
            ),
            'collection_date_create' => array(
                'type' => 'DATETIME'
            ),
            'collection_creator' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'collection_editor' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'collection_release' => array(
                'type' => 'VARCHAR',
                'constraint' => '4'
            ),
            'collection_universe' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('collection_id', TRUE);
        $created = $this->dbforge->create_table('collection', TRUE, $this->attributes);
    }
    
    /**
     * Création de la table Tag
     */
    public function createTag() {
        $fields = array(
            'tag_id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE
            ),
            'tag_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('tag_id', TRUE);
        $this->dbforge->create_table('tag', TRUE, $this->attributes);
    }
    
    /**
     * Création de la table Tag
     */
    public function createItemTag() {
        $fields = array(
            'link_id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE
            ),
            'item_id' => array(
                'type' => 'INT'
            ),
            'tag_id' => array(
                'type' => 'INT'
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('link_id', TRUE);
        $this->dbforge->create_table('itemTag', TRUE, $this->attributes);
    }
    
    /**
     * Création de la table ItemUser
     * Lien de possession entre un item et un user
     */
    public function createItemUser() {
        $fields = array(
            'link_id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE
            ),
            'item_id' => array(
                'type' => 'INT'
            ),
            'user_id' => array(
                'type' => 'INT'
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('link_id', TRUE);
        $this->dbforge->create_table('itemUser', TRUE, $this->attributes);
    }
    
    /**
     * Création de la table Borrow
     * Item emprunté par une personne à une autre
     */
    public function createBorrow() {
        $fields = array(
            'borrow_id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE
            ),
            'item_id' => array(
                'type' => 'INT'
            ),
            'lender_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'borrower_id' => array(
                'type' => 'INT'
            ),
            'borrow_state' => array(
                'type' => 'VARCHAR',
                'constraint' => '2'
            ),
            'borrow_date_end' => array(
                'type' => 'DATE'
            ),
            'borrow_date_begin' => array(
                'type' => 'DATE'
            ),
            'borrow_date_create' => array(
                'type' => 'DATE'
            ),
            'borrow_deny' => array(
                'type' => 'TEXT'
            ),
            'borrow_length' => array(
                'type' => 'INT'
            ),
            'borrow_date_renew_asked' => array(
                'type' => 'DATE'
            ),
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('borrow_id', TRUE);
        $this->dbforge->create_table('borrow', TRUE, $this->attributes);
    }
    
    /**
     * Création de la table Token
     * Token pour la modification de mot de passe
     */
    public function createToken() {
        $fields = array(
            'token_id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT'
            ),
            'token_key' => array(
                'type' => 'VARCHAR',
                'constraint' => 32
            ),
            'token_ip' => array(
                'type' => 'VARCHAR',
                'constraint' => 15
            ),
            'token_date_create' => array(
                'type' => 'DATETIME'
            ),
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('token_id', TRUE);
        $this->dbforge->create_table('token', TRUE, $this->attributes);
    }
    
        
    /**
     * Création de la table Wish
     * Item que voudrait posséder un User
     */
    public function createWish() {
        $fields = array(
            'wish_id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT'
            ),
            'item_id' => array(
                'type' => 'INT',
            ),
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('wish_id', TRUE);
        $this->dbforge->create_table('wish', TRUE, $this->attributes);
    }
    
    
    
    
    /**
     * Ajoute le premier utilisateur dans la base
     */
    public function populateUser() {
        $this->db->insert('user', array(
            'role_id' => '1',
            'user_name' => 'admin',
            'user_pwd' => password_hash('admin', PASSWORD_DEFAULT),
            'user_active' => 1
        ));
    }
    
    /**
     * Ajoute les valeurs par défaut dans la table Role
     */
    public function populateRole() {
        $this->db->insert('role', array(
            'role_name' => 'admin'
        ));
        $this->db->insert('role', array(
            'role_name' => 'utilisateur'
        ));        
    }
    
    /**
     * Création de l'ensemble des catégories dans la base
     */
    public function populateCategory() {
        $categories = array(
            'Audio' => array(
                'icon' => 'music',
                'sub' => array(
                    'Album' => '',
                    'Audiobook' => '',
                    'Saga' => ''
                )
            ),
            'Vidéo' => array(
                'icon' => 'film',
                'sub' => array(
                    'Série' => '',
                    'Anime' => '',
                    'Film' => ''
                )
            ),
            'Livre' => array(
                'icon' => 'books',
                'sub' => array(
                    'Livre' => '',
                    'Comics' => '',
                    'Manga' => '',
                    'BD' => ''
                )
            ),
            'Jeux' => array(
                'icon' => 'pacman',
                'sub' => array(
                    'Jeux vidéo' => '',
                    'Jeux de plateau' => '',
                    'Jeux de rôle' => ''
                )
            )
        );
        
        foreach($categories as $parent => $children) {
            $this->db->insert('category', array(
                'category_name' => $parent,
                'category_icon' => $children['icon']
            ));
            $idParent = $this->db->insert_id();
            
            foreach($children['sub'] as $category => $icon) {
                $this->db->insert('category', array(
                    'category_name' => $category,
                    'category_parent_id' => $idParent,
                    'category_icon' => $icon
                ));
            }
        }
    }
    
}
