<h3>Add Member</h3>
<?php
echo $this->Form->create('Member');
echo $this->Form->input('first_name');
echo $this->Form->input('last_name');
echo $this->Form->input('email');
echo $this->Form->end('Save Member');
?>