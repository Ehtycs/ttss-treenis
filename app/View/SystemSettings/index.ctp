<h2>Edit system settings</h2>
<?php
echo $this->Form->create('SystemSetting');
echo $this->Form->input('first_day_of_year', array('label' => 'First day of next year'));
echo $this->Form->input('release_slots_days', array('label' => 'Days before unbooked owned timeslots are released'));
echo $this->Form->input('release_slots_time', array('label' => 'Time when timeslots are released',
											        'timeFormat' => '24', 'default' => '16:00'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save changes');
?>