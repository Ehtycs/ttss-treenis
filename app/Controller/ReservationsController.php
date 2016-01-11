<?php

class ReservationsController extends AppController {

	
   public $helpers = array('Html', 'Form', 'Session');
   public $components = array('Session');
   public $uses = array('Band', 'Reservation', 'Slot', 'ReservationMessage');
   
   public function isAuthorized($user) {
   
   	// this class should be accessible by bands for the 
   	// most part
   	if(in_array($this->action, array('book','cancel'))) {
   		return true;
   	}
   	 
   	return parent::isAuthorized($user);
   
   }

   public function book($slotId = null, $date = null) {
   	
   	// make reservations for the band which is logged in 
   	$bandId = (int) $this->Auth->user('band_id');
   	
   	  if(!$this->Auth->user('band_id')) {
   	  	$this->Session->setFlash(__('Wrong type of account'), 'flash_fail');
   	 	$this->redirect(array('controller' => 'calendar'));
   	  }
   	
      if(!$bandId || !$slotId || !$date ||
      	 	!$this->Band->exists($bandId)) {
         throw new NotFoundException(__('Invalid parameters for booking'));
      }
      
      $this->Reservation->create();
      if($this->Reservation->save(array('slot_id' => $slotId, 
      									'band_id' => $bandId,
      									'date' => $date))) {
      	$this->Session->setFlash(__('Reservation has been made'), 'flash_success');  
      }
      else {
      	$this->Session->setFlash(__('Reservation failed'), 'flash_fail');
      }
      
      $this->redirect(array('controller' => 'calendar'));

      
   }
   
   public function cancel($id = null) {
   	

		if(!$id) {
			throw new NotFoundException(__('Invalid parameters for booking'));
		}
		
		$bandId = (int) $this->Auth->user('band_id');
   	   	$reservation = $this->Reservation->findById($id);
		
   	   	if($reservation['Reservation']['band_id'] != $bandId) {
   	   		$this->Session->setFlash(__('You are not allowed to cancel other bands reservations, you asshole.'), 'flash_fail');
   	   		$this->redirect(array('controller' => 'Calendar'));
   	   		return;
   	   	}
   	   	
		if($this->Reservation->delete($id)) {
			$this->Session->setFlash(__('Reservation has been cancelled'), 'flash_success');
		}
		else {
			$this->Session->setFlash(__('Cancellation failed'), 'flash_fail');
		}
   	
		$this->redirect(array('controller' => 'Calendar'));
   	
   }






}