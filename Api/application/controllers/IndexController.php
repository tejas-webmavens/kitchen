<?php
class IndexController extends Zend_Controller_Action
{
	public function init(){
		$this->view->noheader = false;
	}
	public function indexAction() {
		$this->view->noheader = true;
	}
}
