<?php


class SlotsController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
    
    public function index() {
      $res = $this->Slot->find('all');
      $this->set('slots', $res);
      $this->set('weekdays', array('Mon','Tue','Wed','Thu','Fri','Sat','Sun'));
    }
    
    public function add() {
      if($this->request->is('post')) {
         $this->Slot->create();
         if($this->Slot->save($this->request->data)) {
            $this->Session->setFlash(__('Slot added'), 'flash_success');
            return $this->redirect(array('action' => 'index'));
         }
         $this->Session->setFlash(__('Saving the slot failed'));
      }
    }
    
    public function edit($id = null) {
      if(!$id || !$this->Slot->exists($id)) {
         throw new NotFoundException(__('Invalid slot id'));
      }
      
      if(!$this->request->is('get')) {
         if($this->Slot->save($this->request->data)) {
            $this->Session->setFlash(__('Changes saved'), 'flash_success');
            return $this->redirect(array('controller' => 'slots', 'action' => 'index'));
         }
         $this->Session->setFlash(__('Saving data failed'), 'flash_fail');
      }
      $slot = $this->Slot->findById($id);
      $this->request->data = $slot;

    }

}