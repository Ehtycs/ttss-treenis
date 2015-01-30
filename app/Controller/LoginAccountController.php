<?php
class LoginAccountController extends AppController {

	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');
	public $uses = array('LoginAccount', 'Member', 'Band');


	public function index() {
// 		debug($this->LoginAccount->find('all'));
		$this->set('accounts', $this->LoginAccount->find('all'));

	}
	
	public function add() {
		
		if($this->request->is('post')) {
// 			debug($this->request->data);
			$this->LoginAccount->create();
			if($this->LoginAccount->save($this->request->data)) {
				$this->Session->setFlash(__('New login account has been created'), 'flash_success');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Saving the account failed'));
		}
		
		$members = $this->Member->getNameListIndexedById();
		$bands = $this->Band->getNameListIndexedById();
		$members[0] = '<empty>';
		$bands[0] = '<empty>';
		$this->set('members', $members);
		$this->set('bands', $bands);
		
	}
	
	public function remove($id = null) {
		
		if(!$id) {
			throw new NotFoundException(__('Invalid account id'));
		}
		
		if(!$this->request->is('get')) {
			 
			if($this->LoginAccount->delete($id, true)) {
				$this->Session->setFlash(__('Account succesfully deleted.'), 'flash_success');
			}
			else {
				$this->Session->setFlash(__('Deleting account failed.'), 'flash_fail');
			}
		}
		return $this->redirect(array('controller' => 'AdminAccount', 'action' => 'index'));
	}
	
	// Login function for admin accounts
	public function login() {
		debug($this->request->data);
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Session->setFlash(__('Invalid username or password, try again'));
		}
		
	}
	
	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

}

?>