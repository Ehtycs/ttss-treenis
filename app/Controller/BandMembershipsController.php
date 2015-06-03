<?php

class BandMembershipsController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
    public $uses = array('Band','Member', 'BandMembership');
    
	// these things can be accessed only by admins (inherited)
    
    /**
     *   Add member to band (both must exist) 
     */
    public function add($bandId = null) {
      if(!$bandId || !$this->Band->exists($bandId)) {
         throw new NotFoundException(__('Invalid band id'));
      }
      
      if($this->request->is('post') || $this->request->is('put')) {
         $data = $this->request->data;
         $data['BandMembership']['Band'] = $bandId;
         if($this->BandMembership->save($data)) {
            $this->Session->setFlash(__('Member added succesfully'), 'flash_success');
            return $this->redirect(array('controller'=>'bands', 'action' => 'view', $bandId));
         }
         $this->Session->setFlash(__('Adding member failed'));
      
      }
      $members = $this->BandMembership->find('available_users_list', array('band' => $bandId));
      $this->set('members', $members);
      $this->set('band', $this->Band->findById($bandId));

   }
   
   
   /**
    * Remove connection
    */
   public function remove($id = null) {
      if(!$id) {
         throw new NotFoundException(_('Invalid membership id!'));
      }
      
      $bandId = $this->BandMembership->findById($id, array('recursive' => 0))['BandMembership']['band_id'];
      
      if($this->BandMembership->delete($id)) {
         $this->Session->setFlash(__('Member connection deleted'), 'flash_success');
      }
      else {
         $this->Session->setFlash(__('Deleting connection failed'));
      }
      return $this->redirect(array('controller' => 'bands', 'action' => 'view', $bandId));
   }
}

?>