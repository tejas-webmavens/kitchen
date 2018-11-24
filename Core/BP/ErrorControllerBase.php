<?php

class Core_BP_ErrorControllerBase extends Zend_Controller_Action
{
	public function init(){
		$this->view->setScriptPath(dirname(__FILE__)."/views/scripts/");

	}

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->view->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($this->view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }
        $params = $errors->request->getParams();

        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }

        $this->view->request   = $errors->request;
        
		$db = Zend_Db_Table::getDefaultAdapter();
		
		if(!$db) {
			echo $e->getMessage();
			exit;
		}
		
		$conf = $db->getConfig();

		$dblog = new Zend_Db_Adapter_Pdo_Mysql(array(
			'host'     => $conf['host'], 
			'username' => $conf['username'],
			'password' => $conf['password'],  
			'dbname'   => $conf['dbname']."_log"
		));		
		
		$session = Core_BP_Session::get();		
		try {
			if($session->user_name) {
				$u = $session->user_name;
			} elseif($session->userId) {
				$u = $session->userId;
			} elseif($session->storeId) {
				$u = Core_BP_Db::get("m_store", $session->storeId, "store_name");
			} else {
				$u="(other)";
			}
			
			$trace = debug_backtrace(); //$e->getTrace();
			
			$ct = count($trace);
			
			$arrLog = array(
				"application"=> $session->getNamespace(),
				"controller"=>  $params['controller'],
				"action"=>		$params['action'],
				"parameters"=>	print_r($params, true),
				"user"=>	 	$u,
				"error"=> 	 	$errors->exception,
				"logtrace"=> 	json_encode($trace)
			);
			
			$dblog->insert("log_errors",$arrLog);
			//send error to sentry
                        Core_BP_Sentry::send_error_request($errors->exception->getMessage());                        
			return $errors->exception;
			
		} catch(Exception $e) {
			echo $e->getMessage();
			exit;
		}

    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

