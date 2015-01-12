<?php


class Slot extends AppModel {

   public $actsAs = array('Containable');

   public $hasOne = array(
      'OwnedByConstReservAccount' => array(
         'className' => 'ConstReservAccount',
         'foreignKey' => false,
         'associationForeignKey' => 'slot_id',
      ),
   );
   
   public $wdays = array('Mon', 'Tue','Wed',
                     'Thu', 'Fri','Sat', 'Sun');
                     
   public $weekdays = array('Monday', 'Tuesday','Wednesday',
                     'Thursday', 'Friday','Saturday', 'Sunday');

   public function find($type = 'first', $qData = array()) {
    
      switch($type) {     

         case 'readable_list': 
            
            
            $slots = parent::find('all', $qData);
//             debug($slots);
            $ret = [];
            
            foreach($slots as $s) {
               
               $ret[$s['Slot']['id']] = $this->wdays[$s['Slot']['day']].' '.$s['Slot']['start'];
            }
            
            return $ret;
         
         default:

            return parent::find($type, $qData);

      }
    
    
    }
    
    public function afterFind($results, $primary = false) {
      
//       debug($results);
      
      // attach Textual representation of a slot
      foreach($results as $key => $val) {
         $keys = array_keys($val);
         // oh my god... jesus ...
         $results[$key][$keys[0]]['text'] = $this->wdays[$val[$keys[0]]['day']].' '.$val[$keys[0]]['start'];
      }
      
      return $results;
       
    }
    
    
   public function readableById($id) {
      
      $res = $this->findById($id);
      
      return $this->wdays[$s['Slot']['day']].' '.$s['Slot']['start'];
      
   }


}