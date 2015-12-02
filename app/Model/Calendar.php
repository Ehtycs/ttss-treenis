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
 * 		"Weeks" => array(
 * 			weekno => array(
 * 				// date1 ...
 * 				"date1" => array(
 * 					"time1" = array(
 *	 					"Reservation" => null / reservation data ,
 * 						"Slot" => slot data,
 * 						"OwnedTimeslot => null / owned timeslot data,
 * 					),
 * 					...
 * 					"timex" => array (
 * 						...
 * 					)
 * 				)
 * 				
 * 				...
 * 				//date2
 * 				"date2" => array(
 * 					array(),
 * 					...
 * 					array(),	
 * 				)
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
	private $ownedslots = array();
	private $slots = null;
	
	private $systemSettings = null;
	
	public function __construct($id = false, $table = null, $ds = null) {
		
		$settings = ClassRegistry::init('SystemSettings');
		$this->systemSettings = $settings->find('first')['SystemSettings'];
		//debug($this->systemSettings);
		$this->changeDate = new DateTime($this->systemSettings['first_day_of_year']);
		$this->now = new DateTime('+0 days');
		parent::__construct($id, $table, $ds);
	}
	
	/**
	 * 	Rewamp the calendar array so that it can quickly be put together as a table (in a view)
	 *  (row by row)
	 * 	in array[week][clock] = array(contain all slots BY DAY that START at clock 'clock' or null (none))
	 *  -> in view, loop weeks, loop clocks, loop days -> as rows to table, 
	 *     set rowspan according to slot duration
	 */
	public function getCalendarInTableForm() {
		
		// Stores into $this->calendar
		$this->getCalendar();
		
		// week
		$week = array();
		// take a "transpose" $arr[week][clock][day]
		// also put clock as 00:00:00 -> 0, 01:00:00 -> 1, etc.
		foreach($this->calendar as $weekno => $w) {
			if(!isset($week[$weekno])) {
				// create 24 hours
				$week[$weekno] = array_fill(0, 24, array());
			}
			
			foreach($w as $date => $day) {
				foreach($day as $clock => $s) {	
					// take the hour of the clock, cast to int
					$ind = (int)explode(':', $clock)[0];
					// put the slot to it's correct place
					if(!isset($week[$weekno][$ind])) {
						$week[$weekno][$ind] = array();
					}
					$week[$weekno][$ind][$date] = $s;
				}
			}
		}
		return $week;
		
	}
	
	/**
	 * Returns an array of rehearsing calendar as described at top of this file.
	 * this format is basically designed to be exploited in ajaxrequests. 
	 * @param string $date1	starting date 
	 * @param string $date2 end date
	 * @return multitype:	array of all shit thats going down between the two dates (if null, two weeks from present is assumed)
	 */
	
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
		
		$currentYear = (int)$this->now->format('Y');

		//fetch all owned timeslots for current and following year
		$this->ownedslots[$currentYear-1] = $OwnedSlot->findAllReturnBySlotId(array(
			'conditions' => array(
				// Current used year here 
				'ConstReservAccount.year' => $currentYear-1
			)	
		));
		$this->ownedslots[$currentYear] = $OwnedSlot->findAllReturnBySlotId(array(
			'conditions' => array(
				// Current used year here 
				'ConstReservAccount.year' => $currentYear
			)	
		));

		$diff = $date1->diff($date2);
		$date = $date1;
		
		// create days, iterate day at a time
		// FIXME: Why the +2 is needed. its 3:30 am. I cant think anymore
		for($i = 0; $i < $diff->d + 2; $i++) {
			// create empty array for week
			if(!isset($this->calendar[$date->format('W')])) {
				$this->calendar[$date->format('W')] = array();
			}
				

			// If changeDate is in the past. Use next years reservation accounts.
			// if not, use current years reservation accounts. This is MAGIC, do not touch
			$year = $date->diff($this->changeDate)->invert ? $currentYear-1 : $currentYear;
			// index by week number, and date
			$this->calendar[$date->format('W')][$date->format('Y-m-d')] = $this->_createDay($year, $date, $i==0 ? true : false);
			$date->modify("+1 days");
		}

		return $this->calendar;
		
	}
	
	/**
	 * Creates a data structure of a day (date)
	 * @param $year: tells what years reservation account data to use
	 *        string $date: day to generate  
	 *        $today: true if we should remove
	 * 		  slots that are in the past
	 * @throws InternalErrorException if  $date is null
	 * @return array of timeslots in a day
	 */
	private function _createDay($year, $date = null, $today = false) {
		
		if(!$date) {
			throw new InternalErrorException('Invalid date');
		}
		
		$day = array();
		
		// we need to map day of week to TTSS style,  0=mon -> 6=sun
		// get slots in this day
		$slots = $this->slots[$this->_toTTSSWeek($date->format('w'))];
		
		// index slots by clock time
		foreach($slots as $s) {
			
			if($today) {
				$endtime = new DateTime($date->format('Y-m-d').' '.$s['end']);
				$diff = $this->now->diff($endtime);
			}
			
			$start = new DateTime($date->format('Y-m-d').' '.$s['start']);
			
			$day[$s['start']] = array( 
					"Slot" => $s,
					// If $today is true, check the time, if time is past, put "gone" to reservation
					"Reservation" => $today && $diff->invert ? "gone" : $this->_getReservation($date->format('Y-m-d'), $s['id']),
					// if owned slot is found, put band it to it, otherwise null to show that it's not owned
					// year tells which years reservation account data to use.
					//"OwnedTimeSlot" => isset($this->ownedslots[$s['id']]) ? $this->ownedslots[$s['id']] : null, 
					"OwnedTimeSlot" => $this->_ownedTimeSlotRealease($year, $s['id'], $this->now, $start),
					
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
	
	// determine if owned timeslot is to be released for all to reserve
	// Reads time constraints from database system_settings table.
	private function _ownedTimeSlotRealease($year,$id, $now, $start) {
		if(isset($this->ownedslots[$year][$id])) {
			// Day limit for unbooked owned timeslot release
			$releaseDays = $this->systemSettings['release_slots_days'];
			$release = new DateTime('+'.$releaseDays.' days');
			
			// Time when unowned slots will be released.
			$limit = new DateTime('+0 days');
			$releaseTime = explode(':',$this->systemSettings['release_slots_time']);
			
			//$limit->setTime(16, 00, 00);
			$limit->setTime($releaseTime[0], $releaseTime[1], $releaseTime[2]);

			$rDd = $now->diff($start)->d;	// days from now to beginning of slot
			
			// THE LOGIC STEPS: 
			// if $rDd is less than $releaseDays-1, we are close enough and slot is free to take.
			if($rDd < $releaseDays-1) {
				return null;	
			}
			//if($now->diff($limit)->invert && $release->diff($start)->invert) {
			// if rDr and releaseDays are equal, check the time. If time is past $releaseTime, slot is free to take
			else if($rDd == $releaseDays-1 && $now->diff($limit)->invert) {
				return null;
			}
			else {
				// else return name or id of owner band or something
				return $this->ownedslots[$year][$id];
			}
			
		}
		else {
			return null;
		}
	}

	
	// from 0=sunday...6=saturday to 0=monday...6=sunday
	private function _toTTSSWeek($daynum) {
		return $daynum == 0 ? 6 : $daynum - 1;
	}

}



?>
