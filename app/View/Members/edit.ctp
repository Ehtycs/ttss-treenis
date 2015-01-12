<h2>Edit Member <?php echo $memberName; ?></h2>
<?php
echo $this->Form->create('Member');
echo $this->Form->input('first_name');
echo $this->Form->input('last_name');
echo $this->Form->input('email');
?>
<p>Is a member of TTYY
<?php echo $this->Form->checkbox('ttyy'); ?>
</p>
<p>
Has access to rehearsal room 
<?php echo $this->Form->checkbox('access'); ?>
</p>
<?php
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save Member');
?>