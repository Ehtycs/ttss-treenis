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
   
   
}

?>