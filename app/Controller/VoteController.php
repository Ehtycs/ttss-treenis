<?php


class VoteController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
    
	public function beforefilter() {
		// Allow anyone to view the calendar
		$this->Auth->allow('index', 'vote', 'confirm');
	}
    
    public function index() {
		
    }
    
    public function vote() {
      
      if(!$this->request->is('get')) {
         if($this->Vote->saveVote($this->request->data)) {
            $this->Session->setFlash(__('Your vote has been saved, confirmation email has been sent'), 'flash_success');
            return $this->redirect(array('controller' => 'Vote', 'action' => 'index'));
         }
         else {
	         $this->Session->setFlash(__('Operation failed.'), 'flash_fail');
         }
      }

    }
    
    public function confirm($id = NULL, $token = NULL) {
    	debug(array($id,$token));
    	if(!$id || !$this->Vote->exists($id) || !$token) {
     		throw new NotFoundException(__('Invalid id'));
    	}
    	
    	$vote = $this->Vote->findById($id);
    	if($vote['Vote']['confirm_hash'] === $token) {
    		 $vote['Vote']['confirmed'] = 1;
    		 if($this->Vote->save($vote)) {
    		 	$this->Session->setFlash(__('Your vote has been confirmed. Thank you for participating.'), 'flash_success');
    		 }
    		 else {
    		 	  $this->Session->setFlash(__('Confirmation failed, saving data failed.'), 'flash_fail');
    		 	
    		 }
    	}
    	else {
    		 $this->Session->setFlash(__('Confirmation failed, information doesn\'t match.'), 'flash_fail');
    	}
    	
    	return $this->redirect(array('controller' => 'Vote', 'action' => 'index'));
    	
    }
}