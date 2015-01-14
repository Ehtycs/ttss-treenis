<?php

class Calendar extends AppModel {
	
	public $useTable = false;
	
	public function test() {
		
		$Slot = ClassRegistry::init('model','Slot');
		
		$testi = $Slot->findById(4);
		
		debug($testi);
		
	}
	
}



?>