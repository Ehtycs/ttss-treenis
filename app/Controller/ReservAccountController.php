<?php

class ReservAccountController extends AppController {

   public $helpers = array('Html', 'Form', 'Session');
   public $components = array('Session');
   public $uses = array('Band','Member','ReservAccount');
    
   public function add($bandId = null) {
   
      if(!$bandId || !$this->Band->exists($bandId)) {
         throw new NotFoundException(__('Invalid band id'));
      }

      if($this->request->is('post')) {
         $this->ReservAccount->create();
         $data = $this->request->data;
         $data['ReservAccount']['band_id'] = $bandId;

         if($this->ReservAccount->save($data)) {
            $this->Session->setFlash(__('Booking account has been saved'), 'flash_success');
            return $this->redirect(array('controller' => 'bands', 'action' => 'view', $bandId));
         }
         $this->Session->setFlash(__('Saving booking account failed'), 'flash_fail');
      }

//       $slots = $this->Slot->find('readable_list');
      $band = $this->Band->findById($bandId);
//       $this->set('slots', $slots);
      $this->set('bandName', $band['Band']['name']);
   }
   
   public function remove($id) {

      if(!$id || !$this->ReservAccount->exists($id)) {
         throw new NotFoundException(__('Invalid id'));
      }
      
      $bandId = $this->ReservAccount->findById($id)['ReservAccount']['band_id'];
      
      if($this->ReservAccount->delete($id)) {
         $this->Session->setFlash(__('Deleting booking account succesful'), 'flash_success');
      }
      else {
         $this->Session->setFlash(__('Deletion of booking account failed'), 'flash_fail');
      }
      
      $this->redirect(array('controller' => 'bands', 'action' => 'view', $bandId));

   }
   
}
   
?>
