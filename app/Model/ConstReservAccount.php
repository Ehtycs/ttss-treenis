<?php


class ConstReservAccount extends AppModel {
   
   public $actsAs = array('Containable');
   
   public $belongsTo = array(
      'OwnedBy' => array(
         'className' => 'Band',
         'foreignKey' => 'band_id',
         //'associationForeignKey' => 'band_id',
      ),
      'OwnsSlot' => array(
         'className' => 'Slot',
         'foreignKey' => 'slot_id',
         //'associationForeignKey' => 'slot_id',
      )
   );
   
   public $hasMany = array(
      //'Reservation'
   );
   
   public function beforeSave($options = array()) {
      
      // if we have a field Slot, change it to slot_id
      
      if($this->data['ConstReservAccount']['Slot']) {
         $this->data['ConstReservAccount']['slot_id'] = $this->data['ConstReservAccount']['Slot'];
      }
      
      
      return true;
   }

}