<?php

/**
 * Band model
 * 
 * Represents a band. Has many-to-many connection to Members through Join model
 * BandMembership (table bands_members)
 * Has one-to-many connection to Reservations, ConstReservAccounts and ReservAccounts
 * 
 * 
 */
 
 
 

class Band extends AppModel {

   public $actsAs = array('Containable');
   
   // Connections to other models (tables)
   public $hasMany = array(
      // This is hasManyThrough connection... somehow I didn't manage
      // to get this to work without hasAndBelongsToMany connection too.
      // Actually when members get added, they are added through BandMembership
      // model and BandMemberships controller.
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
   
   // Member connection. Uses the table 'bands_members' as join table
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
            	'MembershipFee' => array(
            		// get only current years fee
            		'conditions' => array(
            			'MembershipFee.year' => date('Y'),
            		)
            	)
            ),
         	
         ),
         
      ));      

      return $bandData;
   
   }

}