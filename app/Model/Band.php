<?php


class Band extends AppModel {

   public $actsAs = array('Containable');

   public $hasMany = array(
      'BandMembership' => array(
         'className' => 'BandMembership',
      ),
      'HasConstReservAccount' => array(
         'className' => 'ConstReservAccount',
         'foreignKey' => 'band_id',
         'associationForeignKey' => false,
      ),
      'HasReservAccount' => array(
         'className' => 'ReservAccount',
      ),
      'Reservations' => array(
         'className' => 'Reservations',
         'foreignKey' => 'band_id',
      )
   );
   
//    public $hasOne = array(
//       'ConstReservAccount',
//       'ReservAccount',
//    );
      
   public $hasAndBelongsToMany = array(
      'Member' => array(
         'className' => 'Member',
         'joinTable' => 'bands_members',
         'foreignKey' => 'band_id',
         'associationForeignKey' => 'member_id',
         'unique' => 'keepExisting'
       ),
   );
   
   public function getViewDataById($id = null) {
   
      if(!$id) {
         throw new NotFoundException(__('Invalid band Id'));
      }
      
      /* This is finally the correct way to contain-find shit! */
      $bandData = $this->find('first', array(
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
         
      ));      

//       debug($bandData);
      return $bandData;
   
   }
   
   /*public function beforeSave($options = array()){
      foreach (array_keys($this->hasAndBelongsToMany) as $model){
         if(isset($this->data[$this->name][$model])){
            $this->data[$model][$model] = $this->data[$this->name][$model];
            unset($this->data[$this->name][$model]);
         }
      }
      return true;
   }*/

   
   //public $hasOne = '';
   
   

}