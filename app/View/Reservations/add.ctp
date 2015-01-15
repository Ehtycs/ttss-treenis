
<p>A simple form to add reservations to test stuff out, makes reservation for current week</p>

<?php 
echo $this->Form->create('Reservation');
echo $this->Form->input('Slot');
echo $this->Form->end('Save');
?>