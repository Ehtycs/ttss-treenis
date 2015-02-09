<?php

class MembershipFeesController extends AppController {

	
	// only for admins 
	
	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');
	public $uses = array('MembershipFee', 'Member');

	public function add($memberId = null) {
		
		if(!$memberId || !$this->Member->exists($memberId)) {
			throw new NotFoundException(__('Invalid member id'));
		}
		
		if($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			$data['MembershipFee']['member_id'] = $memberId;
			if($this->MembershipFee->save($data)) {
				$this->Session->setFlash(__('Membership fee added succesfully'), 'flash_success');
				return $this->redirect(array('controller'=>'members', 'action' => 'view', $memberId));
			}
			$this->Session->setFlash(__('Adding membership fee failed'));
		
		}
		
		$member = $this->Member->findById($memberId)['Member'];
// 		debug($member);
		$this->set('memberName', $member['first_name']." ".$member['last_name']);
// 		$members = $this->BandMembership->find('available_users_list', array('band' => $bandId));
// 		$this->set('members', $members);
// 		$this->set('band', $this->Band->findById($bandId));
		
	}
	
	public function remove($feeId = null) {
		if(!$feeId || !$this->MembershipFee->exists($feeId)) {
			throw new NotFoundException(__('Invalid fee id'));
		}
		
		$membfee = $this->MembershipFee->findById($feeId);
		
		if($this->request->is('post') || $this->request->is('put')) {
			
			if($this->MembershipFee->delete($feeId)) {
				$this->Session->setFlash(__('Membership fee removed succesfully'), 'flash_success');
			}
			else {
				$this->Session->setFlash(__('Removing membership fee failed'));
			}
			return $this->redirect(array('controller'=>'members', 'action' => 'view', $membfee['MembershipFee']['member_id']));	
		}
		
	}
}