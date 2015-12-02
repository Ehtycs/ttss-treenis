<?php

/*
 * Cases dealt with:
 * - x Band tries to reserve owned timeslot that they dont own
 * - x Slot and date do not match 
 * Todo: 
 * - Band doesn't have a valid booking account
 * - If year changeover is going on, check that 
 *   band has rights to reserve the account on correct year
 * - Change "two days" criteria to be read from settings
 * 
 */

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
   	
   	public function beforeSave($options = array()) {
   		
   		// check that slotid and date are ok
   		
   		if(!$this->ReservedBy->hasBookingAccount(
   				$this->data['Reservation']['band_id'])) {
   			return false;			
   		}

   		// Get band info 
   		$band = $this->ReservedBy->find(
   			'first', array( 
   				'contain' => array(
   					'HasReservAccount' => array(),
   					'HasConstReservAccount' => array(),
   				),
   				'conditions' => array(
   					'ReservedBy.id' => $this->data['Reservation']['band_id'],
   				),
   		));
   		
   		// Get slot info, mainly if the slot is an owned timeslot
   		$ownedSlot = $this->ToSlot->find('first',
   			array(
   					'conditions' => array(
   						'ToSlot.id' => $this->data['Reservation']['slot_id'],
   					),
   					'contain' => array(
   						'OwnedByConstReservAccount'
   					)
   			)		
   		);
   		
   		// slot id and date correspond check
   		$slotd = new DateTime($this->data['Reservation']['date'].' 16:00:00');
   		if($ownedSlot['ToSlot']['day'] != $slotd->format('w')-1) {
   			return false;
   		}
//    		debug($ownedSlot);
//    		throw new NotFoundException();
   		
   		// if band is owner of this timeslot, accept reservation
   		// if timeslot is not owned (band_id = null) accept also
   		if(!$ownedSlot['OwnedByConstReservAccount']['band_id'] || 
   		   $ownedSlot['OwnedByConstReservAccount']['band_id'] == 
   		    $this->data['Reservation']['band_id']) {
   			return true;
   		}
   		// if the 'two days' criteria is met 16:00 
   		else {
   			$now = new DateTime('+0 days');
   			$slotd = new DateTime($this->data['Reservation']['date'].' 16:00:00');
   			$diff = $slotd->diff($now);
   			if($diff->d < 2) {
   				return true;
   			}
   		}
   		
   		// otherwise return false
   		return false;
   		
   	}

}

?>