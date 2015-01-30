
   <ul>
      <li><?php echo $this->Html->link(_('List Members'), array('controller' => 'members', 'action'=>'index'));?></li>
      <li><?php echo $this->Html->link(_('Add Members'), array('controller' => 'members', 'action'=>'add'));?></li>
      <li>&nbsp;</li>
      <li><?php echo $this->Html->link(_('List Bands'), array('controller' => 'bands', 'action'=>'index'));?></li>
      <li><?php echo $this->Html->link(_('Add Bands'), array('controller' => 'bands', 'action'=>'add'));?></li>
      <li>&nbsp;</li>
      <li><?php echo $this->Html->link(_('List Login accounts'), array('controller' => 'LoginAccount', 'action'=>'index'));?></li>
      <li><?php echo $this->Html->link(_('Add a login account'), array('controller' => 'LoginAccount', 'action'=>'add'));?></li>
      <li>&nbsp;</li>
      <li><?php echo $this->Html->link(_('Modify Timeslots'), array('controller' => 'slots', 'action'=>'index'));?></li>
      <!--<li><?php echo $this->Html->link(_('Add Bands'), array('controller' => 'slots', 'action'=>'add'));?></li>-->
</ul>
