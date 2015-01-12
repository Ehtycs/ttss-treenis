<?php


class ReservAccount extends AppModel {

   public $actsAs = array('Containable');
   
   public $belongsTo = array(
      'OwnedBy' => array(
         'className' => 'Band',
         'foreignKey' => 'band_id',
         //'associationForeignKey' => 'band_id',
      ),
   );
   
   public $hasMany = array(
//       'Reservation',
   );

}