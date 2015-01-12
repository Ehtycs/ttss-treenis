<h2>Modify band <?php echo $bandName; ?></h2>
<?php
echo $this->Form->create('Band');
echo $this->Form->input('name');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save Modifications');
?>