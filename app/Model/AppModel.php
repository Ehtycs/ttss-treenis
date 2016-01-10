<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	protected function getCurrentUser() {
		  // for CakePHP 2.x:
		  App::uses('CakeSession', 'Model/Datasource');
		  $Session = new CakeSession();

		  $user = $Session->read('Auth.User');
		
		  return $user;
		
	}
	
	// from 0=sunday...6=saturday to 0=monday...6=sunday
	protected function _toTTSSWeek($daynum) {
		return $daynum == 0 ? 6 : $daynum - 1;
	}
}
