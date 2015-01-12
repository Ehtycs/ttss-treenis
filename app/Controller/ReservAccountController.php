<?php

class ReservAccountsController extends AppController {

   public $helpers = array('Html', 'Form', 'Session');
   public $components = array('Session');
   public $uses = array('Band','Member','');
    
   public function add($bandId = null) {
   
      if(!$bandId || !$this->Band->exists($bandId)) {
         throw new NotFoundException(__('Invalid band id'));
      }

      if($this->request->is('post')) {
         $this->ReservAccount->create();
         $data = $this->request->data;
         $data['ConstReservAccount']['band_id'] = $bandId;

         if($this->ConstReservAccount->save($data)) {
            $this->Session->setFlash(__('Booking account has been saved', 'flash_success'));
            return $this->redirect(array('controller' => 'bands', 'action' => 'view', $bandId));
         }
         $this->Session->setFlash(__('Saving timeslot failed', 'flash_fail'));
      }

//       $slots = $this->Slot->find('readable_list');
      $band = $this->Band->findById($bandId);
//       $this->set('slots', $slots);
      $this->set('bandName', $band['Band']['name']);
   }
   
?>
