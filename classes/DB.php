
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
                    $this->_quiry->bindValue($x, $param);
                    $x++;
                }
            }
            if ($this->_quiry->execute()) {
                $this->_result = $this->_quiry->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_quiry->rowCount();
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }

    public function action($action, $table, $where = array()) {
        if (count($where) === 3) {
            $operators = array('=', '<', '>', '<=', '>=');
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return FALSE;
    }

    public function get($table, $where = array()) {
        return $this->action("SELECT *", $table, $where);
    }

    public function results() {
        return $this->_result;
    }

    public function delete($table, $where = array()) {
        return $this->action("DELETE", $table, $where);
    }

    public function insert($table, $fields = array()) {
        if (count($fields)) {
            $keys = array_keys($fields);
            $values = '';
            $x = 1;
            foreach ($fields as $field) {
                $values .= "?";

                if ($x < count($fields)) {
                    $values .=', ';
                    $x++;
                }
            }
            $sql = "INSERT INTO " . $table . " (`" . implode("`,`", $keys) . "`) VALUES(" . $values . ")";
            echo $sql;
            print_r($fields);
            if (!$this->query($sql, $fields)->error()) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function update($table, $id, $fields) {
        $set = '';
        $x = 1;
        foreach ($fields as $name => $value) {
            $set .="{$name} = ?";
            if ($x < count($fields)) {
                $set .=", ";
                $x++;
            }
        }
        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        echo $sql;
        if (!$this->query($sql, $fields)->error()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getId($table, $where) {
        return $this->action("SELECT id", $table, $where);
    }

    public function first() {
        return $this->results()[0];
    }

    public function error() {

        return $this->_error;
    }

    public function count() {
        return $this->_count;
    }

}
