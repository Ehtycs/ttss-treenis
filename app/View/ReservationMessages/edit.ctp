<h2>Edit a message for reservation</h2>
<?php
echo $this->Form->create('ReservationMessage');
echo $this->Form->input('message');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->input('reservation_id', array('type' => 'hidden'));
echo $this->Form->end('Save message');
?>