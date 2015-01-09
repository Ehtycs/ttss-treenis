<?php


class Band extends AppModel {

   public $hasMany = array(
      'BandMembership'
   );
   
   public $actsAs = array('Containable');
   
   public $hasAndBelongsToMany = array(
      'Member' => array(
         'className' => 'Member',
         'joinTable' => 'bands_members',
         'foreignKey' => 'band_id',
         'associationForeignKey' => 'member_id',
         'unique' => 'keepExisting'
       ),
   );
   
   
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