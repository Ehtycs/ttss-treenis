<?php

class MembersController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

    public function index() {
      $res = $this->Member->find('all', array('recursive' => 0));
//       debug($res);
      $members = array_column($res, 'Member');
      $this->set('members', $members);
    }
    
    public function view($id = null) {

    	if(!$id) {
    		throw new NotFoundException(__("Invalid member id!"));
    	}
    	
    	$memberData = $this->Member->findById($id);
    	
    	if(!$memberData) {
    		throw new NotFoundException(__("Invalid member id!"));
    	}
    	
    	$this->set('memberData',$memberData);
    
    } 
    
    public function add() {
    	if($this->request->is('post')) {
    		$this->Member->create();
    		if($this->Member->save($this->request->data)) {
    			$this->Session->setFlash(__('Member has been saved'));
    			return $this->redirect(array('action' => 'index'));
    		}
    		$this->Session->setFlash(__('Saving the member failed'));
    	}
    	
    }

}