<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of validation
 *
 * @author Ultra_HaxZ
 */
class validate {

    private $_passed = FALSE,
            $_errors = array(),
            $_db = null;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array()) {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                $value = $source[$item];

                if ($this->required($item, $value, $rule, $rule_value)) {
                    break;
                } else {
                    $this->unique($item, $value, $rule, $rule_value);
                    $this->match($source, $item, $value, $rule, $rule_value);
                    $this->min($item, $value, $rule, $rule_value);
                    $this->max($item, $value, $rule, $rule_value);
                    $this->email($item, $value, $rule);
                }
            }
        }

        if (empty($this->_errors)) {
            $this->_passed = TRUE;
        }
        return $this;
    }

    private function required($item, $value, $rule, $rule_value) {
        if ($rule === 'required' && empty($value)) {
            $this->addError("{$item} is required");
            return TRUE;
        }
    }

    
    
    private function min($item, $value, $rule, $rule_value) {
        if ($rule === 'min') {
            if (strlen($value) < $rule_value) {
                $this->addError("{$item} is too short");
            }
        }
    }

    private function max($item, $value, $rule, $rule_value) {
        if ($rule === 'max') {
            if (strlen($value) > $rule_value) {
                $this->addError("{$item} is too long{$value}");
            }
        }
    }

    private function match($source, $item, $value, $rule, $rule_value) {
        if ($rule === 'match') {
            $match = $source[$rule_value];
            if (!("$value" === "$match")) {
                $this->addError("{$item}s don't match");
            }
        }
    }

    private function email($item, $value, $rule) {
        if ($rule === 'email') {
            if (!(filter_var($value, FILTER_VALIDATE_EMAIL))) {
                $this->addError("{$item} is not valid");
            }
        }
    }

    private function underAge($item,$value,$rule,$rule_value){
        
        
    }

        private function unique($item, $value, $rule, $rule_value) {
        if ($rule === 'unique') {

            $check = $this->_db->get($rule_value, array($item, '=', $value));

            if (($check->count())) {
                $this->addError("{$item} already exists");
            }
        }
    }

    private function addError($error) {
        $this->_errors[] = $error;
    }

    public function errors() {
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }

}
