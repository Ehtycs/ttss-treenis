<?php

class BandsController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
    public $uses = array('Band','Member', 'ConstReservAccount', 'ReservAccount', 'LoginAccount');
    
    // Give a band access to its own information
    // Give admins full access
    public function isAuthorized($user) {
		
    	// bands can access only view 
    	if(in_array($this->action, array('view'))) {
			return true;
    	}
    	
    	return parent::isAuthorized($user);
    	
    }

    
    public function index() {
    	if(!$this->isAdmin()) {
    		return $this->redirect(array('controller' => 'bands', 'action' => 'view'));
    	}
    	
      // Get a list of bands. Dont associate members to bands 
      $res = $this->Band->find('all', array(
      		'recursive' => 0,
      		'order' => array('name ASC')
      ));
      // Get the column 'Bands' to be passed to BandList element
      // requires php 5.5
      //$bands = array_column($res, 'Band');
      // Like this instead
      $bands = array();
      foreach( $res as $key => $r) {
         $bands[$key] = $r['Band'];
      }
      
      //debug($bands);
      $this->set('bands', $bands);
    }
    
    public function view($id = null) {

    	// if user has the admin bit, 
    	// let id go through
    	if(!$id || !$this->isAdmin()) {
    		if($this->Auth->user('band_id')) {
    			$id = $this->Auth->user('band_id');
    			
    		}
    		else {
	    		$this->Session->setFlash(__('Select band from the list'), 'flash_success');
    			return $this->redirect(array('controller' => 'bands', 'action' => 'index'));
    		}
    	}
    	
    	$bandData = $this->Band->getViewDataById($id);

    	if(!$bandData) {
    		throw new NotFoundException(__("Invalid band id!"));
    	}

    	// combine all reservation accounts to single array
    	$racc = array_merge($bandData['HasReservAccount'],$bandData['HasConstReservAccount']);
//     	debug($bandData);
    	
    	$this->set('reservationAccountData', $racc);
    	$this->set('bandData',$bandData);
    	
    	// set flag to show the remove button column for each band member
    	$this->set('memberships', true);

    } 
    
    public function add() {
    	
    	if($this->request->is('post')) {
    		// Create band object and save it 
    		$this->Band->create();
    		$res = $this->Band->save($this->request->data);
    		if($res['ok']) {
    			$this->Session->setFlash(__($res['msg']), 'flash_success');
    			// Make the redirect go to just added bands view page
    			return $this->redirect(array('controller' => 'bands', 'action' => 'view', $this->Band->getLastInsertId()));
    		}
    		$this->Session->setFlash(__($res['msg']), 'flash_fail');
    	}
    	
    }
    
    public function edit($id = null) {
    	
    	// if user has the admin bit,
    	// let id go through
    	if(!$id || !$this->isAdmin()) {
    		if($this->Auth->user('band_id')) {
    			$id = $this->Auth->user('band_id');
    			 
    		}
    		else {
    			throw new NotFoundException(__("Invalid band id!"));
    		}
    	}
      
      if(!$id || !$this->Band->exists($id)) {
         throw new NotFoundException(__('Invalid band id'));
      }
      
      if(!$this->request->is('get')) {
         if($this->Band->save($this->request->data)['ok']) {
            $this->Session->setFlash(__('Changes saved'), 'flash_success');
            return $this->redirect(array('controller' => 'bands', 'action' => 'view', $id));
         }
         $this->Session->setFlash(__('Saving data failed'), 'flash_fail');
      }
      $band = $this->Band->findById($id);
      $this->request->data = $band;
//       debug($band);
      $this->set('bandName', $band['Band']['name']);
    }
    
    public function remove($bandId = null) {
      
      if(!$bandId) {
         throw new NotFoundException(__('Invalid band id'));
      }
      
      if(!$this->request->is('get')) {
         
         if($this->Band->delete($bandId, true)) {
            $this->Session->setFlash(__('Band and all membership connections were succesfully deleted.'), 'flash_success');
         }
         else {
            $this->Session->setFlash(__('Deleting band failed.'), 'flash_fail');
         }
                  
      }
      
      return $this->redirect(array('controller' => 'bands', 'action' => 'index'));

      
    }

}