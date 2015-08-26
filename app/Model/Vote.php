<?php 

/**
 * Vote model
 */

App::uses('CakeEmail', 'Network/Email');

class Vote extends AppModel {
   
	public $actsAs = array('Containable');
   
   	public $validate = array(
   		'email' => array(
   			'rule' => 'email',
   			'required' => true,
   			'message' => 'Email is required to vote',
		   	'allowEmpty' => false,
   		),
   		'magic_word' => array(
   			'rule' => array('equalTo', 'korgigate'),
   			'message' => 'You didn\'t say the magic word',
   			'allowEmpty' => false,
   		),
   		'vote_option' => array(
   			'rule' => 'notEmpty',
   			'required' => true,
   			'allowEmpty' => false,
   		),
   		
   	);
   	
   /**
    * Tune the save operation a bit.
    */
   public function saveVote($qData = NULL, $validate = true, $fieldList = array()) {
        debug($qData);
        if(isset($qData['Vote']['magic_word'])) {
	        unset($qData['Vote']['magic_word']);
        }
        // create random hash
        
        $chash = $this->createCheckHash();
        $qData['Vote']['confirm_hash'] = $chash;
        
        if(!parent::save($qData, $validate, $fieldList)) {
        	return false;
        }
        
        
        if(!$this->sendConfirmationMail($qData, $chash)) {
        	debug("Maili feil");
        	return false;
        }
        
        
        return true;
        //return parent::save($qData, $validate, $fieldList);
   }
   
   private function createCheckHash() {
   		// not the most perfect one but gets the job done
   		$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
   		return $randomString;
   		//return "asdfghjktiyotkigktif";
   }
   
   private function sendConfirmationMail($qData, $chash) {
   		$Email = new CakeEmail('gmail');
		$Email->from(array('rikuroudari@gmail.com' => 'TTSS Voting system'));
		$Email->to($qData['Vote']['email']);
		$Email->subject('TTSS vote Confirmation');
		
		$id = $this->getLastInsertID();
		
		$msg = "
Hei,
		
Joku(TM) on äänestänyt TTSS:n äänestyskikkareessa käyttäen sinun sähköpostiosoitettasi. Varmista henkilöllisyytesi ja vie äänestys loppuun käymällä alla olevassa osoitteessa.
http://berryhill.dy.fi:10123/ttss-treenis/Vote/confirm/".$id."/".$chash."

Parhain terveisin
Riku Roudari / TTSS Botti

p.s. Älä vastaa tähän viestiin
";
		
		$Email->send($msg);
		return true;
   }
   	

}

?>