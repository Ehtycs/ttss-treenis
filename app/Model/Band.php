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
      	),
   			'LoginAccount' => array(
   				'className' => 'LoginAccount',
   		),
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
   
   	// Return an array of bands indexed by Id
   	public function getNameListIndexedById() {
   	
	   	$res = $this->find('all', array('order' => array('name ASC')));
	   	$ret = array();
	   
	   	foreach($res as $band) {
	   
	   		$ret[$band['Band']['id']] = $band['Band']['name'];
	   
	   	}
	   
	   
	   	return $ret;
   	
   	}
   
   	// check that band has a valid booking account
	public function hasBookingAccount($id = null, $date = null) {
		
		$date = $date ? $date : DateTime("+0 days");
		$settings = ClassRegistry::init('SystemSetting');
		debug($date);
		$year = $settings->getSystemYearOfDay($date);
   		debug($year);
   		$res = $this->find('first', array(
   			'contain' => array(
   				'HasReservAccount' => array(
   					'conditions' => array(
   						'HasReservAccount.year' => $year,
   						'HasReservAccount.is_paid' => true,
   						'HasReservAccount.is_valid' => true,
   					)
   				),
   				'HasConstReservAccount' => array(
   					'conditions' => array(
   						'HasConstReservAccount.year' => $year,
   						'HasConstReservAccount.is_paid' => true,
   						'HasConstReservAccount.is_valid' => true,
   					)
   				),
   					
   			),
   			'conditions' => array(
   				'id' => $id,		
 			)
   			
   		));
		debug($res);
   		if(count($res['HasConstReservAccount']) > 0 ||
   	   		count($res['HasReservAccount']) > 0) {
   			
   	   		return true;
   		}
   	
   		return false;
   	}
   
   	public function save($qData = NULL, $validate = true, $fieldList = array()) {   		
  
   		// Check if loginaccount and password were given
		if((count($qData['Band']['login_account']) > 0) and 
			(count($qData['Band']['password']) > 0)){
				
				if(!$this->LoginAccount->uniqueUsername($qData['Band']['login_account'])) {
					// error, username exists, it must be unique
					return array('ok' => false, 'msg' => 'Login name already exists');
				}
				
				if(!parent::save($qData, $validate, $fieldList)) {
					return array('ok' => false, 'msg' => 'Saving band failed');
				}
				
				$la = array(
					'LoginAccount' => array(
						'band_id' => $this->getLastInsertId(),
						'password' => $qData['Band']['password'],
						'username' => $qData['Band']['login_account'],
					)
				);
				
				if(!$this->LoginAccount->save($la)) {
					return array('ok' => false, 'msg' => 'Band was saved. Saving login account failed.');
				}
				
				return array('ok' => true, 'msg' => 'Band and login account saved.');
				
		}
		else {
			// just save band name
			return array( 'ok' => parent::save($qData, $validate, $fieldList));
			
		}			
   	}
   	
   	public function delete($id = null, $cascade = true) {
   		// delete all reservations of band, and after that succeedes delete the band
   		return $this->Reservations->deleteAll(array('band_id' => $id)) && parent::delete($id, $cascade);
   	}

}