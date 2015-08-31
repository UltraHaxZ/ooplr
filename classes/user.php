<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Ultra_HaxZ
 */
class user {
    private $_db;
    public function __construct($user=NULL) {
        $this->_db = DB::getInstance();
    }
    public function create($usersTableName,$fields=  array()){
        if (!$this->_db->insert($usersTableName,$fields)) {
            throw new Exception("there was a problem adding user!");
        }
    }
}
