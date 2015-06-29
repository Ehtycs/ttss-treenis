<?php
/**
  *   Print out a table of members based on $members array
  *!!! $memberships variable should contain true if list is !!! 
  *   printed to Band's info page and false if to general member listing page
  */
?>
<table>
    <tr>
        <!--<th>Id</th>-->
        <th>Name</th>
        <th>Email</th>
        <th>TTYY cur. y.</th>
        <th>Member fee cur. y.</th>
        <th>Access</th>
        <?php echo AuthComponent::user('admin') && isset($memberships) && $memberships ? "<th>Actions</th>" : "";?>
    </tr>
    
    <?php foreach($members as $m): ?>
    <tr>
         <!--<td><?php echo $m['id']; ?></td>-->
         <td><?php 
            echo AuthComponent::user('admin') ? $this->Html->link(
               $m['first_name'].' '.$m['last_name'], 
               array('controller' => 'members', 'action' => 'view', $m['id'])
            ) : $m['first_name'].' '.$m['last_name'];
         ?></td>
         <td><?php echo $m['email']; ?></td>
         <td><?php 
         
         //if($m['ttyy']) {echo "X";} 
         if(isset($m['MembershipFee'][0]) && $m['MembershipFee'][0]['ttyy']) {
         	echo "X";
         }
         ?></td>
         <td><?php 
         if(isset($m['MembershipFee'][0])) {
         	echo "X";
         }
         ?></td>
         <td><?php if($m['access']) {echo "X";} ?></td>
         <td><?php 
         
         if(AuthComponent::user('admin') && isset($memberships) && $memberships) {
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
