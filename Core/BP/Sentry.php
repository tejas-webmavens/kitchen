<?php 
class Core_BP_Sentry {
	public static function send_error_request($error_message)
        {  
            Core_BP_Raven_Autoloader::register();
            // $client = new Core_BP_Raven_Client(Core_BP_Settings::get_setting('sentry_secret_key'));
            // $client->setEnvironment(Core_BP_Helpers::coreRegistry('environment'));
            // $client->setRelease(Core_BP_Sentry::get_current_git_commit());
            // $error_handler = new Core_BP_Raven_ErrorHandler($client);            
            // $error_handler->registerExceptionHandler();
            // $error_handler->registerErrorHandler();
            // $error_handler->registerShutdownFunction();            
            // $event_id = $client->getIdent($client->captureMessage($error_message)); 
            // return $event_id;
        }               
        
    public static function get_current_git_commit( $branch='master' ) {
	  if ( $hash = file_get_contents( sprintf( '/var/www/html/.git/refs/heads/%s', $branch ) ) ) {
	    return trim($hash);
	  } else {
    	return false;
	  }
	}

}
