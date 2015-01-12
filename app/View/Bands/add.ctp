<h2>Add a Band</h2>
<?php
echo $this->Form->create('Band');
echo $this->Form->input('name');
echo $this->Form->end('Save Band');
?>