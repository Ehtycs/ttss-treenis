<?php

/**
 * Slot model.
 * Represents one time slot in week calendar. Can be pre-occupied by
 * ConstReservAccount ( normal accounts or a non-owner can book this 
 * only two days before ).
 * 
 */ 

class Slot extends AppModel {

   	public $actsAs = array('Containable');
   
   	public $hasOne = array(
   		// Connection tracks If this is an owned timeslot of some band
      	'OwnedByConstReservAccount' => array(
        	'className' => 'ConstReservAccount',
         	'foreignKey' => 'slot_id',
         	'associationForeignKey' => false,
      	),
   			
   	);
   	
   // Slot has not to be in relation to Reservations
   
   // Used to map weekdaynumber to text...
   private $wdays = array('Mon', 'Tue','Wed',
                     'Thu', 'Fri','Sat', 'Sun');
   private $weekdays = array('Monday', 'Tuesday','Wednesday',
                     'Thursday', 'Friday','Saturday', 'Sunday');

   public function find($type = 'first', $qData = array()) {
    
      switch($type) {     
         /**
          * Return a list of form array('id1' => 'Day1 12:34', 'id2' => 'Day2 13:45'...)
          * to be viewed in lists or dropdowns.
          */
         case 'readable_list': 
            
            
            $slots = parent::find('all', $qData);
//             debug($slots);
            $ret = [];
            
            foreach($slots as $s) {
               
               $ret[$s['Slot']['id']] = $this->wdays[$s['Slot']['day']].' '.$s['Slot']['start'];
            }
            
            return $ret;
            
         // Return slots in week calendar form, ie. indexed by week day and number inside the day
         case 'week_calendar':
         	return $this->_toWeekCalendarForm(parent::find('all', $qData));
         
         default:
            return parent::find($type, $qData);

      }
    
    
    }
    
   /**
    * Attach textual representation and duration of slot (as hours) of a slot to normal return array of
    * find function
    */
   public function afterFind($results, $primary = false) {
   
      // attach Textual representation of a slot and the duration
      foreach($results as $key => $val) {
         $keys = array_keys($val);
         // oh my god... jesus ...
         $results[$key][$keys[0]]['text'] = $this->wdays[$val[$keys[0]]['day']]
                                             .' '.$val[$keys[0]]['start'];
         $beg = $results[$key][$keys[0]]['start'];
         $end = $results[$key][$keys[0]]['end'];
         
         $diff = (new DateTime($beg))->diff(new DateTime($end));
         $results[$key][$keys[0]]['hours'] = $diff->h+1;
      }
      return $results;
   }
    
   /**
    * Get a single slot in readable form by id
    */
   public function readableById($id) {
      $res = $this->findById($id);
      return $this->wdays[$s['Slot']['day']].' '.$s['Slot']['start'];
   }

   /**
    * Return an array of free timeslots of the form
    * array(
    *    'text' => array( 'Mon 08:00 yyyy-mm-dd', ... )
    *    'date' => array( 'yyyy-mm-dd', ... )
    *    'slot_id' => array( 'id1', ... )
    * )
    *
    * E.g. map correct dates to timeslots, so the band can pick a slot
    * 
    */
   public function getAvailableTimeslots($bandId) {
      
      App::uses('CakeTime', 'Utility');
      
      // get all slots
      $slots = $this->_toWeekCalendarForm($this->find('all', array(
         // contain nothing
         'contain' => array(
            /*'Slot' => array(
               
            )*/
         )
      )));
      // get today's date
      $today = CakeTime::format(time(), '%G-%m-%d');
      debug(CakeTime::format('+0 days', '%G-%m-%d'));
      // This returns ISO standard Monday => 1 ... Sunday => 7, so -1
      // to get the TTSS standard :)
      $dayOfWeek = CakeTime::format(time(), '%u') -1;
      
      $ret = array('slot_txt' => array(), 'date' => array(), 'slot_id' => array());
      // Create two days
      // Oh my god what a mess...
      for($i=1; $i <= 2; $i++) {
         $date = CakeTime::format('+'.$i.' days',  '%G-%m-%d');
         $dow = CakeTime::format('+'.$i.' days',  '%u') -1;
         for($j=0; $j < count($slots[$dow]); $j++) {         
            $ret['text'][] = $slots[$dow][$j]['text'].' '.$date;
            $ret['date'][] = $date;
            $ret['slot_id'][] = $slots[$dow][$j]['id'];
         }
      }
      
      /*$bandData = $this->find('first', array(
         'conditions' => array(
            'Band.id' => $id,
         ),
         'contain' => array(
            'HasConstReservAccount' => array(
               'OwnsSlot',
            ),
            'HasReservAccount' => array(
            
            ),
            'Member' => array(
               
            ),
         ),
         
      ));*/
   
      return $ret;
   
   }
   
   // to 2D array indexed by weekday
   private function _toWeekCalendarForm($result) {
      $ret = array();
      foreach($result as $r) {
         if(!isset($ret[$r['Slot']['day']])) {
            $ret[$r['Slot']['day']] = array();
         }
         $ret[$r['Slot']['day']][] = $r['Slot'];
      }
      //debug($result);
      return $ret;
   }
   

}