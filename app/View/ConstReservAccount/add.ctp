 
<h2>Add an owned timeslot to band <?php echo $bandName ?></h2>


<?php 
echo $this->Form->create('ConstReservAccount');
echo $this->Form->input('Slot');
?>
<p>Is paid
<?php echo $this->Form->checkbox('is_paid'); ?>
</p>
<p>
Is valid (works, this can be used to ban someone)
<?php echo $this->Form->checkbox('is_valid'); ?>
</p>
<?php
echo $this->Form->input('year', array('default' => date('Y')));
echo $this->Form->end('Save');
?>