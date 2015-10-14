<h2>Add a Band</h2>
<?php
echo $this->Form->create('Band');
echo $this->Form->input('name');
echo $this->Form->input('login_account', 
	array('label' => 'Login name', 
	'type' => 'text',
		'before' => "Add also a login account(leave empty if not)"));
echo $this->Form->input('password', array('label' => 'password', 'type' => 'password'));
echo $this->Form->end('Save Band');
?>