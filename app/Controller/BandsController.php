<?php

class BandsController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
    public $uses = array('Band','Member', 'ConstReservAccount', 'ReservAccount');
    
    public function index() {
      // Get a list of bands. Dont associate members to bands 
      $res = $this->Band->find('all', array('recursive' => 0));
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

    	if(!$id) {
    		throw new NotFoundException(__("Invalid band id!"));
    	}
    	
    	$bandData = $this->Band->getViewDataById($id);

    	if(!$bandData) {
    		throw new NotFoundException(__("Invalid band id!"));
    	}

    	// combine all reservation accounts to single array
    	$racc = array_merge($bandData['HasReservAccount'],$bandData['HasConstReservAccount']);
//     	debug($racc);
    	
    	$this->set('reservationAccountData', $racc);
    	$this->set('bandData',$bandData);

    } 
    
    public function add() {
    	if($this->request->is('post')) {
    		$this->Band->create();
    		if($this->Band->save($this->request->data)) {
    			$this->Session->setFlash(__('Band has been saved'));
    			return $this->redirect(array('action' => 'index'));
    		}
    		$this->Session->setFlash(__('Saving the band failed'));
    	}
    	
    }
    
    public function edit($id = null) {
      
      if(!$id || !$this->Band->exists($id)) {
         throw new NotFoundException(__('Invalid band id'));
      }
      
      if(!$this->request->is('get')) {
         if($this->Band->save($this->request->data)) {
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