<?php


class CalendarController extends AppController {

	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');

	
	public function index() {
		
		$cal = $this->Calendar->getCalendarInTableForm();
// 		debug($cal);
		$this->set('cal', $cal);
		
		$this->set('ajaxForm', $this->Calendar->calendar);
		
//  		debug($this->Calendar->getCalendarInTableForm());
	}
	
}