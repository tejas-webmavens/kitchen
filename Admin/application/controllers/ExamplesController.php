<?php

class ExamplesController extends Zend_Controller_Action {

    function indexAction() {
        
    }

    function trycatchexampleAction() {
        try {
            var_dump(Core_BP_Custom::check_num(2));
            //if function throw exception than execution stop from try and after catch statments will execute.
        } catch (Exception $ex) {            
            Core_BP_Sentry::send_error_request("testing:".$ex->getMessage());                        
            //use sentry API to send errors.
        }
    }

}
