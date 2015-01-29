
<h2>Add membership fee for <?php echo $memberName ?></h2>

<?php 
echo $this->Form->create('MembershipFee');
?>

<?php
// This can also be set to date('Y') + 1 but i think it's more realistic this way. 
echo $this->Form->input('year', array('default' => date('Y')));
?>
<p>Is a member of TTYY
<?php echo $this->Form->checkbox('ttyy', array('default' => true)); ?>
</p>
<?php 
echo $this->Form->end('Save');
?>