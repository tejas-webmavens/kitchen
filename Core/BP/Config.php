<?
class Core_BP_Config {
	function get($var) {
		$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		return $config->getOption($var);
	}
}
