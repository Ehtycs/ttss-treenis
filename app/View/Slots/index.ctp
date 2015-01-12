

<h2>Slots</h2>

<table>
<tr><th>Id</th><th>Day</th><th>Begin</th><th>End</th><th>Actions</th></tr>
<?php foreach($slots as $s): ?>
<tr>
<td><?php echo $s['Slot']['id']; ?></td>
<td><?php echo $weekdays[$s['Slot']['day']]; ?></td>
<td><?php echo $s['Slot']['start']; ?></td>
<td><?php echo $s['Slot']['end']; ?></td>
<td><?php echo $this->Html->link('edit', array('action' => 'edit', $s['Slot']['id'])); ?></td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add a timeslot</h3>
<?php
echo $this->Form->create('Slot', array('url' => array('action' => 'add')));
echo $this->Form->input('day', 
                        array('options' => array('Monday', 'Tuesday','Wednesday',
                              'Thursday', 'Friday','Saturday', 'Sunday')));
                                   
echo $this->Form->input('start', array('timeFormat' => '24', 'default' => '00:00'));
echo $this->Form->input('end', array('timeFormat' => '24', 'default' => '00:00'));
echo $this->Form->end('Add slot');
?>