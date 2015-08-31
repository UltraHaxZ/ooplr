<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tooken
 *
 * @author Ultra_HaxZ
 */
class token {

    public static function generate() {
        return session::put(config::get('session/token_name'), md5(uniqid()));
    }

    public static function check($token) {
        $tokenName = config::get('session/token_name');
        if (session::exists($tokenName) && $token === session::get($tokenName)) {
            session::delete($tokenName);
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
