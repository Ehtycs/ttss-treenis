<h3>Heimoi</h3>


<?php foreach($cal as $weekno => $week): ?>

<table id="booking-calendar">
<tr>
<th>Kello</th>
<?php foreach($ajaxForm[$weekno] as $date => $d): ?>
<th><?php echo $date; ?></th>
<?php endforeach; ?>
</tr>

<?php foreach($week as $hour => $row): ?>
<tr>
<td class="hour"><?php echo $hour; ?>:00</td>
<?php foreach($row as $slot):?>
<td rowspan="<?php echo $slot['Slot']['hours']; ?>">
<?php 
// if there are reservations
if($slot['Reservation']) {
	echo "Varattu<br> ".$slot['Reservation']['name'];
}
else if($slot['OwnedTimeSlot']) {
// 	echo $slot['OwnedTimeSlot'];
	echo "Vakio<br>".$slot['OwnedTimeSlot']['OwnedBy']['name'];
}
else {
	echo "Tyhjä";
}
?>
</td>
<?php endforeach;?>
</tr>
<?php endforeach;?>
</table>
<br><br>
<?php endforeach;?>