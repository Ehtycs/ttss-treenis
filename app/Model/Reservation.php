<?php

/*
 * Cases dealt with:
 * - x Band tries to reserve owned timeslot that they dont own
 * - x Slot and date do not match 
 * Todo: 
 * - x Band doesn't have a valid booking account
 * - x If year changeover is going on, check that 
 *   x band has rights to reserve the account on correct year
 * - x Change "two days" criteria to be read from settings
 * 
 */

class Reservation extends AppModel {

   	public $actsAs = array('Containable');
   
   	public $hasOne = array(
   		'ReservationMessage' => array(
         	'className' => 'ReservationMessage',
         	'foreignKey' => 'reservation_id',
   			'dependent' => true,
      	),
   	);
   	
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
   		
   		$data = $this->data['Reservation'];
   		$date = new DateTime($data['date']);
   		
   		$user = $this->getCurrentUser();

   		// Reserver id:s dont match
   		if($user['band_id'] != $data['band_id']) {
   			return false;
   		}
   		   		
   		// check that band has a booking account
   		if(!$this->ReservedBy->hasBookingAccount($data['band_id'], $date)) {
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
   						'ToSlot.id' => $data['slot_id'],
   					),
   					'contain' => array(
   						'OwnedByConstReservAccount'
   					)
   			)		
   		);
   		
   		// slot id and date correspond check
   		//$slotd = new DateTime($this->data['Reservation']['date'].' 16:00:00');
   		$day = $this->_toTTSSWeek($date->format('w'));
   		if($ownedSlot['ToSlot']['day'] != $day) {
   			return false;
   		}

   		// if band is owner of this timeslot, accept reservation
   		// if timeslot is not owned (band_id = null) accept also
   		if(!$ownedSlot['OwnedByConstReservAccount']['band_id'] || 
   		   $ownedSlot['OwnedByConstReservAccount']['band_id'] == 
   		    $this->data['Reservation']['band_id']) {
   			return true;
   		}
   		// if day is released according to system settings
   		else {
   			$Settings = ClassRegistry::init('SystemSettings');
   			if($settings->isDayReleased($date)) {
				return true;
   			}
   		}
   		
   		// otherwise return false
   		return false;
   		
   	}

}

?>