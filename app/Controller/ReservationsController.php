<?php

class ReservationsController extends AppController {

   public $helpers = array('Html', 'Form', 'Session');
   public $components = array('Session');
   public $uses = array('Band', 'ReservAccount', 'Slot');

   public function add($bandId = null) {
      
      if(!$bandId || !$this->Band->exists($bandId)) {
         throw new NotFoundException(__('Invalid band id'));
      }
      
      if($this->request->is('post')) {
         $this->Reservation->create();
         $data = $this->request->data;
         $data['Reservation']['band_id'] = $bandId;
         

         if($this->Reservation->save($data)) {
            $this->Session->setFlash(__('Reservation has been made'), 'flash_success');
            return $this->redirect(array('controller' => ''));
         }
         $this->Session->setFlash(__('Reservation failed'), 'flash_fail');
      }
      
      $slots = $this->Slot->getAvailableTimeslots($bandId);
      $this->set('slots', $slots);
      
   }






}