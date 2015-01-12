<?php

class MembersController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

    public function index() {
      $res = $this->Member->find('all', array('recursive' => 0));
//       debug($res);
      // fix: array_column requires too new php version
      //$members = array_column($res, 'Member');
      $members = array();
      foreach( $res as $key => $r) {
         $members[$key] = $r['Member'];
      }
      
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
    
    public function edit($id = null) {
      
      if(!$id || !$this->Member->exists($id)) {
         throw new NotFoundException(__('Invalid member id'));
      }
      
      if(!$this->request->is('get')) {
         if($this->Member->save($this->request->data)) {
            $this->Session->setFlash(__('Changes saved'), 'flash_success');
            return $this->redirect(array('controller' => 'members', 'action' => 'view', $id));
         }
         $this->Session->setFlash(__('Saving data failed'), 'flash_fail');
      }
      $member = $this->Member->findById($id);
      $this->request->data = $member;
//       debug($member);
      $this->set('memberName', 
                 $member['Member']['first_name'].' '.$member['Member']['last_name']);
    }
    
    public function add() {
    	if($this->request->is('post')) {
    		$this->Member->create();
    		if($this->Member->save($this->request->data)) {
    			$this->Session->setFlash(__('Member has been saved'), 'flash_success');
    			return $this->redirect(array('action' => 'index'));
    		}
    		$this->Session->setFlash(__('Saving the member failed'));
    	}
    }
    
    public function remove($id = null) {
    
      if(!$id) {
         throw new NotFoundException(__('Invalid member id'));
      }
      
      if(!$this->request->is('get')) {
         
         if($this->Member->delete($id, true)) {
            $this->Session->setFlash(__('Member and all membership connections were succesfully deleted.'), 'flash_success');
         }
         else {
            $this->Session->setFlash(__('Deleting member failed.'), 'flash_fail');
         }
                  
      }
      
      return $this->redirect(array('controller' => 'members', 'action' => 'index'));
    
    }

}