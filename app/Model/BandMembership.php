<?php


class BandMembership extends AppModel {
    public $belongsTo = array(
        'Band', 'Member'
    );
    
    public $useTable = 'bands_members';
    
    public function find($type = 'first', $qData = array()) {
    
      switch($type) {     

         case 'available_users_list': 
            // fetch all users, and remove those that already belong to band $band
            
            if(!$qData || !$qData['band'] || !$this->Band->exists($qData['band'])) {
               throw new NotFoundException(__('The band doesn\'t exist'));
            }
                        
            $members = $this->Member->find('all');/*, array(
               'contain' => array('Band'),
               'conditions' => array(
                  'Band.id' => $qData["band"],
               ),
            ));*/
            
            $ret = [];
            
            /* May god have mercy on my soul, but i just couldn't figure out 
             * correct better way to do this with sql joins (error messages)...
             */
             
//              debug($members);
            foreach($members as $m) {
               $cont = 1;
               if(count($m['BandMembership']) > 0) {
                  foreach ($m['BandMembership'] as $bm) {
                     if($bm['band_id'] == $qData['band']) {
                        // remove from results
                        $cont = 0;
                        break;
                     }
                  }
                }
                if($cont) {
                  $ret[$m['Member']['id']] = $m['Member']['first_name'].' '.$m['Member']['last_name'];
               }
            }
            
            //debug($ret);
            
            return $ret;
         
         default:
         return parent::find($type, $qData);
      
      
      }
    
    
    }
    
    public function save($qData = NULL, $validate = true, $fieldList = array()) {
         debug($qData);
         $qData['BandMembership']['member_id'] = $qData['BandMembership']['Member'];
         $qData['BandMembership']['band_id'] = $qData['BandMembership']['Band'];
         unset($qData['BandMembership']['Member']);
         unset($qData['BandMembership']['Band']);
         return parent::save($qData, $validate, $fieldList);
    }
    
}



?>
