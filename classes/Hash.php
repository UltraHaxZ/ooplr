<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hash
 *
 * @author Ultra_HaxZ
 */
class Hash {
    public static function make($string,$salt=''){
        return hash('sha256', $string.$salt);
    }
    
    public static function salt($legnth){
        return mcrypt_create_iv($legnth);
    }

    public static function unique(){
        return self::make(uniqid());
    }
}
