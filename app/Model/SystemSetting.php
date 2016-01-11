<?php 

/**
 * SystemSettings model.
 * System usage related settings
 * 	- first day of year: aka. when new slots and accounts step into order
 *  - reservation release days: defines how many days before unbooked owned timeslots are released
 *  - reservation release time: defines at which time the unbooked owned timeslots are released
 */
class SystemSetting extends AppModel {
   
   public $actsAs = array('Containable');
   
   // Read first day of new year setting from database. If
   // that day is in future, return first_day_of_year - 1 year, i.e. last year.
   // If first day has passed, return the year of first_day_of_year.
   public function getSystemYearOfDay($now = null) {
   		$now = $now ?  $now : new DateTime('+0 days');
   		
   		$settings = $this->find('first')['SystemSetting'];
   		$firstDay = new DateTime($settings['first_day_of_year']);

   		$diff = $now->diff($firstDay);
   		
   		if($now <= $firstDay) {
   			// first day is on past, or equal
   			return ((int)$firstDay->format('Y')) -1;
   		}
   		// first day is in the future
   		
   		return (int)$firstDay->format('Y');
   }
   
   public function isDayReleased($date) {
   	
   		$settings = $this->find('first')['SystemSetting'];
   		$now = new DateTime("+0 days");
		
   		$releaseDays = $settings['release_slots_days'];
   		
   		// Time of day when unowned slots will be released.
		$limit = new DateTime('+0 days');
		$releaseTime = explode(':',$settings['release_slots_time']);
		
		$limit->setTime($releaseTime[0], $releaseTime[1], $releaseTime[2]);
		$date->setTime(0, 0, 0);
		
		$rDd = $now->diff($date)->d;
		
		// THE LOGIC STEPS: 
		// if $rDd is less than $releaseDays-1, we are close enough and 
		// slots are free to take.
		if($rDd < $releaseDays-1) {
			return true;
		}
		// if rDr and releaseDays-1 are equal, check the time. If time is past 
		// $releaseTime, slots are free to take
		else if($rDd == $releaseDays-1 && $now->diff($limit)->invert) {
			return true;
		}

		return false;
			
   }
   
   
}

?>