<?php

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');


class LoginAccount extends AppModel {
	
	public $belongsTo = array(
			'Band',
			'Member',
	); 

	public $validate = array(
			'username' => array(
					'required' => array(
							'rule' => array('notEmpty'),
							'message' => 'A username is required'
					)
			),
			'password' => array(
					'required' => array(
							'rule' => array('notEmpty'),
							'message' => 'A password is required'
					)
			)
	);
	
	// Enable password hashing
	public function beforeSave($options = array()) {
		
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
					$this->data[$this->alias]['password']
			);
		}
		
		if(isset($this->data[$this->alias]['Band'])) {
			$this->data[$this->alias]['band_id'] = $this->data[$this->alias]['Band'];
		}
		
		if(isset($this->data[$this->alias]['Member'])) {
			$this->data[$this->alias]['member_id'] = $this->data[$this->alias]['Member'];
		}
		
		return true;
	}
	
	
}


?>