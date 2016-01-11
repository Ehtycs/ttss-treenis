<h2>Add a message for reservation</h2>
<?php
echo $this->Form->create('ReservationMessage');
echo $this->Form->input('message');
echo $this->Form->input('reservation_id', array('type' => 'hidden', 'value' => $reservationId));
echo $this->Form->end('Save message');
?>