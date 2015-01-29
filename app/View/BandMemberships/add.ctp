<h3>Add an existing member to band <?php echo $band['Band']['name']; ?></h3>
<?php
echo $this->Form->create('BandMembership');
echo $this->Form->input('Member');
echo $this->Form->end('Save Member');
?>

<h3>Add a new user to band <?php echo $band['Band']['name']; ?></h3>

<?php
echo $this->Form->create('Member', array('url' => array('controller' => 'Members', 'action' => 'addWithBand', $band['Band']['id'])));
echo $this->Form->input('first_name');
echo $this->Form->input('last_name');
echo $this->Form->input('email');
?>
<!-- <p>Is a member of TTYY -->
<?php // echo $this->Form->checkbox('ttyy'); ?>
<!-- </p> -->
<p>
Has access to rehearsal room 
<?php echo $this->Form->checkbox('access'); ?>
</p>
<?php
echo $this->Form->end('Save Member');
?>
