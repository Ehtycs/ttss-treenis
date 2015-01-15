<?php

class ConstReservAccountController extends AppController {

   public $helpers = array('Html', 'Form', 'Session');
   public $components = array('Session');
   public $uses = array('Band','ConstReservAccount', 'Slot'); 

   public function add($bandId = null) {
   
      if(!$bandId || !$this->Band->exists($bandId)) {
         throw new NotFoundException(__('Invalid band id'));
      }
   
      if($this->request->is('post')) {
         $this->ConstReservAccount->create();
         $data = $this->request->data;
         $data['ConstReservAccount']['band_id'] = $bandId;
         
         if($this->ConstReservAccount->save($data)) {
            $this->Session->setFlash(__('Timeslot has been saved'), 'flash_success');
            return $this->redirect(array('controller' => 'bands', 'action' => 'view', $bandId));
         }
         $this->Session->setFlash(__('Saving timeslot failed', 'flash_fail'));
      }
      
      $slots = $this->Slot->find('readable_list');
      $band = $this->Band->findById($bandId);
      $this->set('slots', $slots);
      $this->set('bandName', $band['Band']['name']);
   }
   
   public function remove($id) {

      if(!$id || !$this->ConstReservAccount->exists($id)) {
         throw new NotFoundException(__('Invalid id'));
      }
      
      $bandId = $this->ConstReservAccount->findById($id)['ConstReservAccount']['band_id'];
      
      if($this->ConstReservAccount->delete($id)) {
         $this->Session->setFlash(__('Deleting timeslot succesful'), 'flash_success');
      }
      else {
         $this->Session->setFlash(__('Deletion of timeslot failed'), 'flash_fail');
      }
      
      $this->redirect(array('controller' => 'bands', 'action' => 'view', $bandId));

   }
}
    
?>
