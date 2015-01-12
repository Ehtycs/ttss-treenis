<?php

class Reservation extends AppModel {

   public $actsAs = array('Containable');
   
   public $belongsTo = array(
      'ReservedBy' = array(
         'className' => 'Band',
         'foreignKey' => 'band_id',
      ),
   );
   
   public $hasOne = array(
      'ToSlot' = array(
         'className' => 'Slot',
         'foreignKey' => 'slot_id',
      ),
   );


}

?>