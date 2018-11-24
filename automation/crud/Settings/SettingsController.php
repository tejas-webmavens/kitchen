<?php 
class SettingsController extends Zend_Controller_Action{ 

	protected $_redirector = null; 

	public function init() 
	{
		 $this->_redirector = $this->_helper->getHelper('Redirector'); 
	}
	public function indexAction(){
		if($this->_request->getParam('search')){
			$search=$this->_request->getParam('search');
			$this->view->query = "SELECT id,setting_label,setting_slug,setting_value,setting_help_text,sort_order,encrypted
				 FROM settings WHERE id LIKE '%$search%' OR setting_label LIKE '%$search%' OR setting_slug LIKE '%$search%' OR setting_value LIKE '%$search%' OR setting_help_text LIKE '%$search%' OR sort_order LIKE '%$search%' OR encrypted LIKE '%$search%' ORDER BY id desc";
		}
		else{
			$this->view->query = "SELECT id,setting_label,setting_slug,setting_value,setting_help_text,sort_order,encrypted
				 FROM settings ORDER BY id desc";
		}

		if($this->_request->getParam('limit'))
			$this->view->limit=$this->_request->getParam('limit');
		else
			$this->view->limit=10;
		if($this->_request->getParam('page'))
			$this->view->page=$this->_request->getParam('page');
		else
			$this->view->page=1;
	}

	public function addAction(){

		if($this->getRequest()->isPost())
		{
			$data = $this->_request->getPost();

			$settings['setting_label']=$data['setting_label'];
			$settings['setting_slug']=$data['setting_slug'];
			$settings['setting_value']=$data['setting_value'];
			$settings['setting_help_text']=$data['setting_help_text'];
			$settings['sort_order']=$data['sort_order'];
			$settings['encrypted']=$data['encrypted'];

			$settings_id = Core_BP_BaseTable::insert_new('settings', $settings);

			Core_BP_Session::setMessage("Data with id ".$settings_id." added");
			$this->_redirector->gotoSimple('index','settings');
		}
		Core_BP_View::renderForm();
	}
	public function editAction(){

		$db = Zend_Db_Table::getDefaultAdapter();
		$id = $this->_request->getParam('id');
		if($this->getRequest()->isPost())
		{
			$data = $this->_request->getPost();

			$settings['setting_label']=$data['setting_label'];
			$settings['setting_slug']=$data['setting_slug'];
			$settings['setting_value']=$data['setting_value'];
			$settings['setting_help_text']=$data['setting_help_text'];
			$settings['sort_order']=$data['sort_order'];
			$settings['encrypted']=$data['encrypted'];

			Core_BP_BaseTable::update_new('settings', $settings,'id='.$id);

			Core_BP_Session::setMessage("Data with id  ".$id." updated");
			$this->_redirector->gotoSimple('index','settings');
		}
		$settings= $db->fetchAll("SELECT * FROM settings WHERE id=$id");
		$this->view->settings = array_shift($settings);
		Core_BP_View::renderForm();
	}
	public function viewAction(){

		$db = Zend_Db_Table::getDefaultAdapter();
		$id = $this->_request->getParam('id');
		$settings= $db->fetchAll("SELECT * FROM settings WHERE id=$id");
		$this->view->settings = array_shift($settings);
		Core_BP_View::renderForm();
	}

	public function removeAction(){

		$id = $this->_request->getParam('id');
		$rtn = Core_BP_BaseTable::delete_new('settings','id='.$id);
		if($rtn == 1)
			Core_BP_Session::setMessage("Data with id $id deleted successfully");
		else
			Core_BP_Session::setMessage("Data was not deleted because $id not exists");
		$this->_redirector->gotoSimple('index','settings');
		die;
	}
}?>
