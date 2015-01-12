<?php


class Member extends AppModel {
   
   public $hasMany = array(
      'BandMembership' => array(
         'className' => 'BandMembership'
      ),
   );
   
   public $actsAs = array('Containable');
   
   public $hasAndBelongsToMany = array(
      'Band' => array(
         'className' => 'Band',
         'joinTable' => 'bands_members',
         'foreignKey' => 'member_id',
         'associationForeignKey' => 'band_id',
         'unique' => 'keepExisting'
       ),
   );
   
}