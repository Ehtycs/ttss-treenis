<?php

class BandsController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
    public $uses = array('Band','Member');
    
    public function index() {
    // Get a list of bands. Dont associate members to bands 
    $res = $this->Band->find('all', array('recursive' => 0));
    // Get the column 'Bands' to be passed to BandList element
    $bands = array_column($res, 'Band');
    //debug($bands);
        $this->set('bands', $bands);
    }
    
    public function view($id = null) {

    	if(!$id) {
    		throw new NotFoundException(__("Invalid band id!"));
    	}
    	
    	$bandData = $this->Band->findById($id);
    	
//     	debug($this->Band->BandMembership->find('all'));
    	
    	if(!$bandData) {
    		throw new NotFoundException(__("Invalid band id!"));
    	}
    	
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

}