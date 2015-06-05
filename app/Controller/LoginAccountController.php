<?php
class LoginAccountController extends AppController {

	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');
	public $uses = array('LoginAccount', 'Member', 'Band');
	
	public function isAuthorized($user) {
		
		// login and logout should be accessed by bands
    	if(in_array($this->action, array('login', 'logout','changepw'))) {
			return true;
    	}
    	
    	return parent::isAuthorized($user);
		
	}


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
	
	public function changepw() {
		
		$id = $this->Auth->User("id");
		
		if(!$id || !$this->LoginAccount->exists($id)) {
			throw new NotFoundException(__('Invalid LoginAccount id'));
		}
		
		if(!$this->request->is('get')) {
			$error = "";
			switch($this->LoginAccount->saveChangedPassw($this->request->data)) {
			case "OK":
				$this->Session->setFlash(__('Changes saved'), 'flash_success');
				return $this->redirect(array('controller' => 'LoginAccount', 'action' => 'changepw'));
				
			case "CONFIRM_ERROR":
				$error = "New passwords don't match";
				break;
			case "SAVE_ERROR": 
				$error = "Unexpected error during data saving";
			    break;
			case "PASSWD_ERROR":
				$error = "Old password didn't match";
			}
			$this->Session->setFlash(__('Data was not saved: '.$error), 'flash_fail');
		}
		$account = $this->LoginAccount->findWithoutPassword($id);
		$this->set('accountName', $account['LoginAccount']['username']);
		//debug($account);
		$this->request->data = $account;
		
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
		return $this->redirect(array('controller' => 'LoginAccount', 'action' => 'index'));
	}
	
	// Login function
	public function login() {
		
		if($this->Auth->user()) {
			$this->redirect(array('controller' => 'pages'));
		}
		
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