<?php

/**
 * 
 * Model to create a calendar data structure
 * something like 
 * 
 * in: date1, date2
 * 
 * out: 
 * 	array(
 * 		"Days" => array(
 * 			// date1 ...
 * 			"date1" => array(
 * 				"time1" = array(
 *	 				"Reservation" => null / reservation data ,
 * 					"Slot" => slot data,
 * 					"OwnedTimeslot => null / owned timeslot data,
 * 				),
 * 				...
 * 				"timex" => array (
 * 					...
 * 				)
 * 			)
 * 			
 * 			...
 * 			//date2
 * 			"date2" => array(
 * 				array(),
 * 				...
 * 				array(),	
 * 			)
 * 		)
 * 	)
 *
 *	So this shit can be pushed through json_encode to form ajax requests of some sort
 *
 */

class Calendar extends AppModel {
	
	public $useTable = false;
	
	public $calendar = array();
	
	private $reservations = null;
	private $ownedslots = null;
	private $slots = null;
	
	public function getCalendar($date1 = null, $date2 = null) {
		
		// empty the calendar
		$this->calendar = array();
		
		App::Uses('CakeTime', 'Utility');
		$date1 =  $date1 ? $date1 : new DateTime('+0 days');
		// Push one day more to make sure that moving to 
		// last sunday works
		$date2 =  $date2 ? $date2 : new DateTime('+15 days');
		// fiddle around and make the last date always sunday
		$date2->modify('last Sunday');
		
		$Slot = ClassRegistry::init('Slot');
		$Reservation = ClassRegistry::init('Reservation');
		$OwnedSlot = ClassRegistry::init('ConstReservAccount');
		
		// fetch timeslots in week calendar form
		$this->slots = $Slot->find('week_calendar', array(
			
		));
		
		// fetch all reservations between the two dates 
		$this->reservations = $Reservation->findAllReturnBySlotId(array(
			'conditions' => array(
				'and' => array(
						'Reservation.date >= ' => $date1->format('Y-m-d'),
      					'Reservation.date <= ' => $date2->format('Y-m-d'),		
				),
     		),
		));
		
		//fetch all owned timeslots
		$this->ownedslots = $OwnedSlot->findAllReturnBySlotId(array(
			'conditions' => array(
				// Current used year here 
				'ConstReservAccount.year' => 2015
			)
				
		));
		
		$diff = $date1->diff($date2);
		debug($diff);
// 		debug($date2->format('Y-m-d'));
		//debug($this->ownedslots);
// 		debug($diff->d);
		$date = $date1;
		
		// create days
		// FIXME: Why the +2 is needed. its 3:30 am. I cant think anymore
		for($i = 0; $i < $diff->d + 2; $i++) {
			$this->calendar[$date->format('Y-m-d')] = $this->_createDay($date);
			$date->modify("+1 days");
		}
		
		return $this->calendar;
		
	}
	
	/**
	 * Creates a data structure of a day (date)
	 * @param string $date, day to generate
	 * @throws InternalErrorException if  $date is null
	 * @return array of timeslots in a day
	 */
	private function _createDay($date = null) {
		
		if(!$date) {
			throw new InternalErrorException('Invalid date');
		}
		
		$day = array();
		
		// we need to map day of week to TTSS style,  0=mon -> 6=sun
		// get slots in this day
		$slots = $this->slots[$this->_toTTSSWeek($date->format('w'))];
		
		// index slots by clock time
		foreach($slots as $s) {
			$day[$s['start']] = array( 
					"Slot" => $s,
					"Reservation" => $this->_getReservation($date->format('Y-m-d'), $s['id']),
					// this can be dealt with ternary
					"OwnedTimeSlot" => isset($this->ownedslots[$s['id']]) ? $this->ownedslots[$s['id']] : null, 
			);
		}
		
		return $day;
	}
	
	// helper function to get reservation from the array
	private function _getReservation($d, $id) {
		if(!isset($this->reservations[$d]) || !isset($this->reservations[$d][$id])) {
			return null;
		}
		
		return $this->reservations[$d][$id];
	}
	

	
	// from 0=sunday...6=saturday to 0=monday...6=sunday
	private function _toTTSSWeek($daynum) {
		return $daynum == 0 ? 6 : $daynum - 1;
	}

}



?>