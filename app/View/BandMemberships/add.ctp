<h3>Add member to band <?php echo $band['Band']['name']; ?></h3>
<?php
echo $this->Form->create('BandMembership');
echo $this->Form->input('Member');
echo $this->Form->end('Save Member');
?> 
