 
 
<h2>Add booking account for band <?php echo $bandName ?></h2>


<?php 
echo $this->Form->create('ReservAccount');
?>
<p>Is paid
<?php echo $this->Form->checkbox('is_paid'); ?>
</p>
<p>
Is valid (works, this can be used to ban someone)
<?php echo $this->Form->checkbox('is_valid'); ?>
</p>
<?php
echo $this->Form->input('year');
echo $this->Form->end('Save');
?>