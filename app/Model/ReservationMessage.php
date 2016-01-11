<?php

class ReservationMessage extends AppModel {

   	public $actsAs = array('Containable');
   	
   	public $belongsTo = array(
   		'Reservation' => array(
         	'className' => 'Reservation',
         	'foreignKey' => 'reservation_id',
      	),
   	);
   
}

?>