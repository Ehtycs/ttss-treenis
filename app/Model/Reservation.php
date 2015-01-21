<?php

class Reservation extends AppModel {

   	public $actsAs = array('Containable');
   
   	public $belongsTo = array(
      	'ReservedBy' => array(
         	'className' => 'Band',
         	'foreignKey' => 'band_id',
      	),
   		// One sided relation to Slots,
   		// Slots dont need to be in relation to reservations
     	'ToSlot' => array(
        	'className' => 'Slot',
         	'foreignKey' => 'slot_id',
         	'associationForeignKey' => false,
      	),
   	);
	
   	// return reservations indexed as ['date']['slot_id']
   	// osed by Calendar model..
   	public function findAllReturnBySlotId($qData = null) {
   	
   		$reservations = $this->find('all', $qData);
   		$res = array();
   		
   		foreach($reservations as $r) {
   			
   			if(!isset($res[$r['Reservation']['date']])) {
   				$res[$r['Reservation']['date']] = array();
   			}
			
   			$res[$r['Reservation']['date']][$r['Reservation']['slot_id']] = $r;
   		}
   		return $res;
   	}

}

?>