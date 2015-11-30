<?php

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');


class LoginAccount extends AppModel {
	
	public $actsAs = array('Containable');
	
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
			),
			'password_new' => array(
					'required' => array(
							'rule' => array('notEmpty'),
							'message' => 'A password is required'
					)
			),
			'password_new_retype' => array(
					'required' => array(
							'rule' => array('notEmpty'),
							'message' => 'A password is required'
					)
			),
			'password_old' => array(
					'required' => array(
							'rule' => array('notEmpty'),
							'message' => 'A password is required'
					)
			),
	);
	
	
	// Enable password hashing
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = Security::hash(
					$this->data[$this->alias]['password'], 'blowfish'
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
	
	// Remove password from return array
	public function findWithoutPassword($id = null) {
		$arr = $this->findById($id);
		$arr["LoginAccount"]["password"] = "";
		return $arr;
	}
	
	
	// Save new password and do all checks related 
	public function saveChangedPassw(array $data = null, array $params = array()) {

		$id = AuthComponent::user('id');

		// check that user doesn't try to change someone elses password
		if($id != $data["LoginAccount"]["id"]) {
			throw new InternalErrorException("ID:s dont match, something strange going on.");
		}
		
		// password retype matches 
		if($data["LoginAccount"]['password_new'] != $data["LoginAccount"]['password_new_retype']) {
			return "CONFIRM_ERROR";
		}
		
		$account = $this->findById($id);
		
		$oldpw = Security::hash($data["LoginAccount"]["password_old"], 'blowfish', 
								$account["LoginAccount"]["password"]);
		
		// check if old password matches
		if($oldpw != $account["LoginAccount"]["password"]) {
			return "PASSWD_ERROR";
		}
		
		// avoid double hashing.
		$account["LoginAccount"]["password"] = $data["LoginAccount"]["password_new"];
		
		// save, dont validate this time since username uniqueness 
		// wont be fulfilled
		if($this->save($account["LoginAccount"], false)) {
			return "OK";
		}
		else {
			return "SAVE_ERROR";
		}
		
	}
	
}


?>