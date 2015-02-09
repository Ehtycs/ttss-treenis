<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	public $components = array(
			'Session',
			'Auth' => array(
					'authenticate' => array(
							'Form' => array(
									'userModel' => 'LoginAccount',
									'passwordHasher' => 'Blowfish',
									// contain band info and member info
									// contain also timeslots
									'contain' => array(
										'Band' => array(
												'HasConstReservAccount'
										),
									    'Member',
									),
							),

					),
					'loginRedirect' => array(
							'controller' => 'LoginAccount',
							'action' => 'login'
					),
					'logoutRedirect' => array(
							'controller' => 'LoginAccount',
							'action' => 'login',
							'home'
					),
					'loginAction' => array(
							'controller' => 'LoginAccount',
							'action' => 'login'
					),
					'authorize' => array('Controller'),
			)
			
			
	);
	
	public function isAdmin() {
		
		return (bool) $this->Auth->user('admin');
		
	}
	
	public function isAuthorized($user) {
		
	    // Admin can access everything
    	if($user['admin']) {
    		return true;
    	}
		
		// Default deny
		return false;
		
	}
	
}



