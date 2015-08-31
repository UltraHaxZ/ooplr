<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of input
 *
 * @author Ultra_HaxZ
 */
class input {

    public static function exists($type = 'post') {
        switch ($type) {
            case 'post':
                return(!empty($_POST)) ? TRUE : FALSE;
                break;
            case 'get':
                return(!empty($_GET)) ? TRUE : FALSE;
                break;
            default:
                return FALSE;
                break;
        }
    }

    public static function get($item) {
        if (isset($_POST[$item])) {
            return $_POST[$item];
        } elseif (isset($_GET[$item])) {
            return$_GET[$item];
        } else {
            return '';
        }
    }

}
