<?php


class CalendarController extends AppController {

	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');

	
	public function index() {
		
		$cal = $this->Calendar->getCalendarInTableForm();
// 		debug($cal);
		$this->set('cal', $cal);
		
		$this->set('ajaxForm', $this->Calendar->calendar);
// 		debug($this->Auth->user());
		
//   		debug($this->Calendar->calendar);
	}
	
	
	public function beforefilter() {
		// Allow anyone to view the calendar
		$this->Auth->allow('index');
		
	}
	
}