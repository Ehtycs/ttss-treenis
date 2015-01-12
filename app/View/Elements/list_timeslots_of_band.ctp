<?php
/**
 * List timeslots and reservation accounts of a band.
 *
 */


?>
<table>
<tr><th>id</th><th>Type/timeslot</th><th>Year</th><th>Is valid</th><th>Is paid</th><?php
echo $actions ? "<th>Actions</th>" : "";
?></tr>
<?php foreach ($reservationAccountData as $ra): ?>
<tr><td>
<?php
echo $ra['id'];
?></td><td><?php
echo $ra['OwnsSlot'] ? $ra['OwnsSlot']['text'] : "Booking account"; 
?></td><td><?php
echo $ra['year'];
?></td><td><?php 
echo $ra['is_valid'] ? "X" : "";
?></td><td><?php 
echo $ra['is_paid'] ? "X" : "";
?></td><?php
echo $actions ? "<td>".
$this->Form->postLink(
   'Remove', 
   array(
      'controller' => $ra['OwnsSlot'] ? 'ConstReservAccounts' : 'ReservAccounts',
      'action' => 'remove',
      $ra['id']
   ), array(),
   "This deletes the booking account or timeslot permanently. ". 
   "Confirm? (Use of 'is valid' for bans is recommended)" 
)
."</td>" : ""; 
?></tr>
<?php endforeach; ?>
</table>