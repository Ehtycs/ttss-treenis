<?php

class ReservationsController extends AppController {

	
   public $helpers = array('Html', 'Form', 'Session');
   public $components = array('Session');
   public $uses = array('Band', 'Reservation', 'Slot');
   
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
      
      if(!$bandId || !$slotId || !$date ||
      	 	!$this->Band->exists($bandId)) {
         throw new NotFoundException(__('Invalid parameters for booking'));
      }
      
      // FIXME: we should check that slotId and date are correct?
      // also check that band has pribileges to make a booking 
      // (not owned timeslot of someone else, has paid the fees of current year)
      // and that there is no reservations made to that slot 
      // with given date (if someone is fooling around)
      // 
      
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
//       if($this->request->is('post')) {
//          $this->Reservation->create();
//          $data = $this->request->data;
//          $data['Reservation']['band_id'] = $bandId;
         
//          if($this->Reservation->save($data)) {
//             $this->Session->setFlash(__('Reservation has been made'), 'flash_success');
//             return $this->redirect(array('controller' => ''));
//          }
//          $this->Session->setFlash(__('Reservation failed'), 'flash_fail');
//       }
      
//       $slots = $this->Slot->getAvailableTimeslots($bandId);
//       $this->set('slots', $slots);
      
   }
   
   public function cancel($id = null) {
   	
		if(!$id) {
			throw new NotFoundException(__('Invalid parameters for booking'));
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