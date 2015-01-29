<?php



class MembershipFee extends AppModel {
	 
	public $belongsTo = array(
			'Member' => array(
					'className' => 'Member'
			),
	);
	 
	public $actsAs = array('Containable');
	 
	 
}