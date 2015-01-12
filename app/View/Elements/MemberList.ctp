<?php
/**
  *   Print out a table of members based on $members array
  *   $membership to true if delete is a membership delete 
  */
?>
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>TTYY</th>
        <th>Access</th>
        <th>Actions</th>
    </tr>
    
    <?php foreach($members as $m): ?>
    <tr>
         <td><?php echo $m['id']; ?></td>
         <td><?php 
            echo $this->Html->link(
               $m['first_name'].' '.$m['last_name'], 
               array('controller' => 'members', 'action' => 'view', $m['id'])
            );
         ?></td>
         <td><?php echo $m['email']; ?></td>
         <td><?php if($m['ttyy']) {echo "X";} ?></td>
         <td><?php if($m['access']) {echo "X";} ?></td>
         <td><?php 
         
         if(isset($membership) and $membership) {
            echo $this->Html->link(_('Remove'), array('controller' => 'BandMemberships', 
                                                      'action' => 'remove', $m['BandsMember']['id']));
         } /*else {
            echo $this->Html->link(_('Delete'), array('controller' => 'members', 
                                                      'action' => 'remove', $m['id']));
         } */
         
         ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($m); ?>
</table> 
