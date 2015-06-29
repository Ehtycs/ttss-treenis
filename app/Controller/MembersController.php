<?php

class MembersController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
    public $uses = array('Member', 'Band', 'BandMembership');
    
    // only for admins

    public function index() {
//       $res = $this->Member->find('all', array('recursive' => 0));
      $res = $this->Member->find('all', array(
      		'contain' => array(
      			'MembershipFee'
      		),
      		'order' => array(
      			'first_name ASC'
      		)
      ));

//       debug($res);
      // fix: array_column requires too new php version
      //$members = array_column($res, 'Member');
      $members = array();
      foreach( $res as $key => $r) {
         $members[$key]= $r['Member'];
         $members[$key]['MembershipFee'] = $r['MembershipFee'];
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
    	$this->set('membershipFees', $memberData['MembershipFee']);
    	
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
    
    // Add a new user and join him immediately to a band
    public function addWithBand($bandId = null) {
    	if(!$bandId || !$this->Band->exists($bandId)) {
    		throw new NotFoundException(__('Invalid band id'));
    	}
    	
    	if($this->request->is('post')) {
    		$this->Member->create();
    		
    		// If member can be saved succesfully, then join him to band.
    		if($this->Member->save($this->request->data)) {
    			$this->BandMembership->create();
    			$membership = array('BandMembership' => array(
    					'Member' => $this->Member->getLastInsertId(),
    					'Band' => $bandId,
    			));
    			if($this->BandMembership->save($membership)) {
    				$this->Session->setFlash(__('Member has been saved and added to band'), 'flash_success');
    				return $this->redirect(array('controller' => 'bands', 'action' => 'view', $bandId));
    			}
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