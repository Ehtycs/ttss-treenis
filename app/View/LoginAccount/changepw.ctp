<h2>Change password for <?php echo $accountName; ?>:</h2>
<?php
echo $this->Form->create('LoginAccount');
echo $this->Form->input('password_new', array('label' => 'New password', 'type' => 'password'));
echo $this->Form->input('password_new_retype', array('label' => 'Confirm new password', 'type' => 'password'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->input('password_old', array('label' => 'Old password', 'type' => 'password'));

echo $this->Form->end('Save Information');
?>