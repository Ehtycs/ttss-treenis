<h3>Login accounts</h3>

<table>
<tr>
<td></td>
<td></td>
<th colspan="2">Related to</th>
<td></td>
<td></td>
</tr>
<tr>
<th>Id</th>
<th>Username</th>
<th>Band</th>
<th>Member</th>
<th>Account type</th>
<th>Actions</th>
</tr>

<?php foreach($accounts as $m): ?>
    <tr>
         <td><?php echo $m['LoginAccount']['id']; ?></td>
         <td><?php echo $m['LoginAccount']['username']; ?></td>
         <td><?php 
         	echo $m['Band']['id'] ? $m['Band']['name'] : '';
         ?></td>
         <td><?php 
         	echo $m['Member']['id'] ? 
         		$m['Member']['first_name'].' '.$m['Member']['last_name'] : '';
         ?></td>   
         <td><?php 
         	echo $m['LoginAccount']['admin'] ? "Admin" : 'Booking';
         ?>
         </td>     
         <td><?php echo $this->Form->postLink(_('Delete'), 
         		array('action' => 'remove', $m['LoginAccount']['id']), 
         		array(), 'Confirm deletion?'); 
         ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($m); ?>
</table> 

<?php echo $this->Html->link('Add new account', array('action' => 'add'));?>
