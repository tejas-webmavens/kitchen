<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Core_BP_Custom
{
    public static function check_num($number) {
        if ($number > 1) {
            throw new Exception("The value has to be 1 or lower");
        }
        return true;
    }
}