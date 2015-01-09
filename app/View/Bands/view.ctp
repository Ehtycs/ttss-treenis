<h3><?php echo h($bandData['Band']['name']); ?></h3>

<h3>Members</h3>
<?php echo $this->element('MemberList', array('members' => $bandData['Member'])); ?>
</table>