<h3>Booking calendar</h3>
<?php 
/*
 * Note of author:
 * 
 * This is a horrible piece of shit. -A Jun/2015
 * This is literally a horrible pile of doodoo. -A Jan/2016
 * 
 * This is pretty much violating the every principle on earth
 * but this page was the easiest way to implement 
 * the calendar. Will be 'optimized' in future versions.
 * 
 * TODO: The 'business logic' could be moved 
 * to calendar model also. That would be very good.
 * Only offer correct stuff to the arrays passed here.
 */

?>

<?php foreach($cal as $weekno => $week): ?>

<table id="booking-calendar">
<tr>
<td class="hour" >Week <?php echo $weekno;?></th>
<?php foreach($ajaxForm[$weekno] as $date => $d): ?>
<th><?php 
$weekday = new DateTime($date);
echo $weekday->format('D').'<br>'.$weekday->format('d.m'); ?></th>
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
// correct class to cell
if($slot['Reservation'] == "gone") {
	echo "gone";
}
else if($slot['Reservation']) {
	echo "booked";
}
else if($slot['OwnedTimeSlot']) {
	// 	echo $slot['OwnedTimeSlot'];
	echo "owned";
}
else {
	echo "free";
}
?>" rowspan="<?php 
// Print the clock hours to this column for each row
echo $slot['Slot']['hours']; 
?>">
<?php
// if there are reservations
if($slot['Reservation'] == "gone") {
	echo "";
}
else if($slot['Reservation']) {
	// if band that's logged in has booked this reservation
	if($slot['Reservation']['ReservedBy']['id'] == AuthComponent::user('band_id')) {
		echo $slot['Reservation']['ReservedBy']['name']."<br>";
		// Add or edit message link
		// if there are messages attached to reservation
		if($slot['Reservation']['ReservationMessage']['id']) {
			// Message already set, show edit link
			echo $this->Html->link(_('Edit message'), array(
				'controller' => 'ReservationMessages', 
				'action' => 'edit',
				$slot['Reservation']['ReservationMessage']['id']
			));
		} else {
			// No messages set, show add link.
			echo $this->Html->link(_('Add message'), array(
				'controller' => 'ReservationMessages', 
				'action' => 'add',
				// this is disgusting :D
				$slot['Reservation']['Reservation']['id']
			));
		}
		

		echo "<br>";
		// display cancellation link
		echo $this->Form->postLink(_('Cancel'), array(
				'controller' => 'Reservations', 
				'action' => 'cancel',
				// this is disgusting :D
				$slot['Reservation']['Reservation']['id']
		));
	}
	else {
		echo $slot['Reservation']['ReservedBy']['name'];
		echo "<br>";
		// if there are messages attached to reservation
		if($slot['Reservation']['ReservationMessage']['id']) {
			//echo $this->Html->link(_('Show message'), array(
			//	'controller' => 'ReservationMessages', 
			//	'action' => 'show',
			//	$slot['Reservation']['ReservationMessage']['id']
			//));
			echo "<a href=\"javascript:;\" onclick=\"showReservationMessage(".
			$slot['Reservation']['ReservationMessage']['id'].")\">Show message</a>";
		}
	}
}
// If no reservations, check if this is owned timeslot
else if($slot['OwnedTimeSlot']) {
	// Check if the band that's logged in is the owner of the slot
	if($slot['OwnedTimeSlot']['OwnedBy']['id'] == AuthComponent::user('band_id')) {
		// display bands name and Book link
		echo $slot['OwnedTimeSlot']['OwnedBy']['name']."<br>";
		echo $this->Form->postLink(_('Book'), array('controller' => 'reservations', 
							'action' => 'book',
							$slot['Slot']['id'],
							$date,
	));
	}
	// Else display band's name that owns the slot
	else {
		echo $slot['OwnedTimeSlot']['OwnedBy']['name'];
	}
}
else {
	// free slot, display booking link. If user is not logged in
	// this will take him through login page
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