
<ul>
      <li><?php echo $this->Html->link(_('List Members'), array('controller' => 'members', 'action'=>'index'));?></li>
      <li><?php echo $this->Html->link(_('Add Member'), array('controller' => 'members', 'action'=>'add'));?></li>
      <li>&nbsp;</li>
      <li><?php echo $this->Html->link(_('List Bands'), array('controller' => 'bands', 'action'=>'index'));?></li>
      <li><?php echo $this->Html->link(_('Add Band'), array('controller' => 'bands', 'action'=>'add'));?></li>
      <li>&nbsp;</li>
      <li><?php echo $this->Html->link(_('List Login accounts'), array('controller' => 'LoginAccount', 'action'=>'index'));?></li>
      <li><?php echo $this->Html->link(_('Add a login account'), array('controller' => 'LoginAccount', 'action'=>'add'));?></li>
      <li>&nbsp;</li>
      <li><?php echo $this->Html->link(_('Modify Timeslots'), array('controller' => 'slots', 'action'=>'index'));?></li>
      <li><?php echo $this->Html->link(_('Change system settings'), array('controller' => 'systemSettings', 'action'=>'index'));?></li>
      <li>&nbsp;</li>
      <li><?php echo $this->Html->link(_('Change password'), array('controller' => 'LoginAccount', 'action'=>'changepw'));?></li>
      
</ul>
