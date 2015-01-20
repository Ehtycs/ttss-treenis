<?php


class CalendarController extends AppController {

	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');

	
	public function index() {
		
		$this->set('cal', $this->Calendar->getCalendarInTableForm());
		
		$this->set('ajaxForm', $this->Calendar->calendar);
		
//  		debug($this->Calendar->getCalendarInTableForm());
	}
	
}