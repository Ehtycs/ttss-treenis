<?php

/**
 * Member model.
 * Links to bands, holds contact information of a user
 * and info about membership fee.
 */
class Member extends AppModel {
   
   public $hasMany = array(
      'BandMembership' => array(
         'className' => 'BandMembership',
         'dependent' => true,
      ),
      'MembershipFee' => array(
      	'className' => 'MembershipFee',
        'dependent' => true,
      ),
   	  'LoginAccount' => array(
   	    'className' => 'LoginAccount',
      	'dependent' => true,
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
   
   // Return an array of bands indexed by Id
   public function getNameListIndexedById() {
   
   	$res = $this->find('all', array(
   			'order' => array('first_name ASC')
   	));
   	$ret = array();
   
   	foreach($res as $member) {
   		$ret[$member['Member']['id']] = $member['Member']['first_name']." ".$member['Member']['last_name'];
   	}
   
   
   	return $ret;
   
   }
   
}