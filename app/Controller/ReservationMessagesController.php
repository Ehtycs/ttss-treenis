<?php

class ReservationMessagesController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
    public $uses = array('ReservationMessage', 'Reservation');
    
    // Give a band access to adding messages to it's own reservation
    public function isAuthorized($user) {
		
    	// bands can access add, view and edit methods
    	if(in_array($this->action, array('add', 'show', 'edit'))) {
			return true;
    	}
    	
    	return parent::isAuthorized($user);
    	
    }
    
    // allow public access to get method to show messages to non logged users too
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('get');
    }
   
    
    public function add($reservationId = null) {
    	
    	// validate reservation id
     	if(!$reservationId || !$this->Reservation->exists($reservationId)) {
         	throw new NotFoundException(__('Invalid reservation id'));
      	}
      	
      	$res = $this->Reservation->findById($reservationId);
      	
      	// check that logged in band owns the reservation
      	if($res['Reservation']['band_id'] != $this->Auth->user('band_id')) {
      		throw new NotFoundException(__('Authentication failure'));
      	}
    	
      	// if data is passed from form, save it
        if($this->request->is('post')) {
    		$this->ReservationMessage->create();
    		if($this->ReservationMessage->save($this->request->data)) {
    			$this->Session->setFlash(__('Message has been saved'), 'flash_success');
    			return $this->redirect(array('controller' => 'calendar'));
    		}
    		$this->Session->setFlash(__('Saving the message failed'));
    	}
    	
		$this->set("reservationId", $reservationId);
    }
    
    // show message, available for all
    public function show($id = null) {
      if(!$id || !$this->ReservationMessage->exists($id)) {
         throw new NotFoundException(__('Invalid message id'));
      }
      
      $msg = $this->ReservationMessage->findById($id)['ReservationMessage'];
      
      $this->set('message', $msg['message']);
      
    }
    
 // get json form of message
    public function get($id = null) {
      if(!$id || !$this->ReservationMessage->exists($id)) {
         throw new NotFoundException(__('Invalid message id'));
      }
      
      $msg = $this->ReservationMessage->find('first', array(
		'conditions' => array(
            	'ReservationMessage.id' => $id,
         ),
         'contain' => array(
         	'Reservation' => array(
         			'ToSlot',
         			'ReservedBy',
         	),
         )
      ));

      $this->layout = 'ajax';
      $this->autoRender = false;
      
		//debug($msg);
      return json_encode(array(
      	'message' => $msg['ReservationMessage']['message'],
      	'band' => $msg['Reservation']['ReservedBy']['name'],
        'date' => $msg['Reservation']['date'],
        'time' => $msg['Reservation']['ToSlot']['text'],
      
      ));
      
    }
    
    public function edit($id = null) {
      if(!$id || !$this->ReservationMessage->exists($id)) {
         throw new NotFoundException(__('Invalid message id'));
      }
      
      
      
     $message = $this->ReservationMessage->find('first', array(
		'conditions' => array(
            	'ReservationMessage.id' => $id,
         ),
         'contain' => array(
         	'Reservation' => array(
         			'ReservedBy',
         	),
         )
      ));
      
      if($this->Auth->user('band_id') != $message['Reservation']['ReservedBy']['id']) {
      		throw new NotFoundException(__('Not allowed'));
      }
      
      debug($this->request->data);
      if(!$this->request->is('get')) {
         if($this->ReservationMessage->save($this->request->data)) {
            $this->Session->setFlash(__('Changes saved'), 'flash_success');
            return $this->redirect(array('controller' => 'calendar'));
         }
         $this->Session->setFlash(__('Saving message failed'), 'flash_fail');
      }

      $this->request->data = $message;
    }
}
   
?>