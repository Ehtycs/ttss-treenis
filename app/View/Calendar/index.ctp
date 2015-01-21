<h3>Heimoi</h3>


<?php foreach($cal as $weekno => $week): ?>

<table id="booking-calendar">
<tr>
<th>Kello</th>
<?php foreach($ajaxForm[$weekno] as $date => $d): ?>
<th><?php echo $date; ?></th>
<?php 
endforeach; 
unset($date);
?>
</tr>

<?php foreach($week as $hour => $row): ?>
<tr>
<td class="hour"><?php echo $hour; ?>:00</td>
<?php foreach($row as $date => $slot):?>
<td class="<?php 
if($slot['Reservation']) {
	echo "booked";
}
else if($slot['OwnedTimeSlot']) {
	// 	echo $slot['OwnedTimeSlot'];
	echo "owned";
}
else {
	echo "free";
}
?>" rowspan="<?php echo $slot['Slot']['hours']; ?>">
<?php 
// if there are reservations
if($slot['Reservation']) {
	echo $slot['Reservation']['ReservedBy']['name'];
}
else if($slot['OwnedTimeSlot']) {
// 	echo $slot['OwnedTimeSlot'];
	echo $slot['OwnedTimeSlot']['OwnedBy']['name'];
}
else {
	echo $this->Form->postLink(_('Book'), array('controller' => 'reservations', 
							'action' => 'book',
							$slot['Slot']['id'],
							$date,
	));
}
?>
</td>
<?php endforeach;?>
</tr>
<?php endforeach;?>
</table>
<br><br>
<?php endforeach;?>