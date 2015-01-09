<?php
/**
  *   Print out a table of members based on $members array
  *
  */
?>
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
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
    </tr>
    <?php endforeach; ?>
    <?php unset($m); ?>
</table> 
