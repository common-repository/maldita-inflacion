<?php

namespace MALINF\backend;

class malinfWelcomepage{
/**
 * Brings html file of admin welcome page 
 */
    public function printW(){
        $pr =  '';
        $pr .= file_get_contents(__DIR__ . '/malinfWelcomePage.html');
        return $pr;
    }
}
