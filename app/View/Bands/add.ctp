<h3>Add a Band</h3>
<?php
echo $this->Form->create('Band');
echo $this->Form->input('name');
echo $this->Form->end('Save Band');
?>