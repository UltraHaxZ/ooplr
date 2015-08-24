
<?php

require_once 'core/init.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DB
 *
 * @author Ultra_HaxZ
 */
class DB {

    private static $_instance = null;
    private $_pdo,
            $_quiry,
            $_error = false,
            $_result,
            $_count = 0;

    private function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host=' . config::get('mysql/host') . ';dbname=' . config::get('mysql/DB') . ';', config::get('mysql/username'), config::get('mysql/password'));
            echo 'connected!!';
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query($sql, $prms = array()) {
        $this->_error = FALSE;
        if ($this->_quiry = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($prms)) {
                foreach ($prms as $param) {
                    $this->_quiry->bindParam($x, $param);
                    $x++;
                }
            }
            if ($this->_quiry->execute()) {
                $this->_result = $this->_quiry->fetchAll(PDO::FETCH_OBJ);
                $this->_count=  $this->_quiry->rowCount();
            }  else {
                $this->_error=true;    
            }
        }
    }

}
