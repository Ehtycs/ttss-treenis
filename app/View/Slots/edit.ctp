
<h2>Edit a timeslot</h2>
<?php
echo $this->Form->create('Slot');
echo $this->Form->input('day', 
                        array('options' => array('Monday', 'Tuesday','Wednesday',
                              'Thursday', 'Friday','Saturday', 'Sunday')));
                                   
echo $this->Form->input('start', array('timeFormat' => '24', 'default' => '00:00'));
echo $this->Form->input('end', array('timeFormat' => '24', 'default' => '00:00'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save changes');
?>