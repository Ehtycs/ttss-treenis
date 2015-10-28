<?php


class SystemSettingsController extends AppController {

	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');

	
	public function index() {
		
		if(!$this->request->is('get')) {
			if($this->SystemSetting->save($this->request->data)) {
				$this->Session->setFlash(__('Changes saved'), 'flash_success');
				return $this->redirect(array('controller' => 'systemSettings', 'action' => 'index'));
			}
			$this->Session->setFlash(__('Saving data failed'), 'flash_fail');
		}
		$row = $this->SystemSetting->find('first');
		//debug($row);
		$this->request->data = $row;

	}
	
	
}