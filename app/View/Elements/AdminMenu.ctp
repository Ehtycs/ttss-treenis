
   <ul>
      <li><?php echo $this->Html->link(__d('members', 'List Members'), array('controller' => 'members', 'action'=>'index'));?></li>
      <li><?php echo $this->Html->link(__d('members','Add Members'), array('controller' => 'members', 'action'=>'add'));?></li>
      <li>&nbsp;</li>
      <li><?php echo $this->Html->link(__d('bands', 'List Bands'), array('controller' => 'bands', 'action'=>'index'));?></li>
      <li><?php echo $this->Html->link(__d('bands', 'Add Bands'), array('controller' => 'bands', 'action'=>'add'));?></li>
      <li>&nbsp;</li>
      <li><?php echo $this->Html->link(__d('slots', 'Modify Timeslots'), array('controller' => 'slots', 'action'=>'index'));?></li>
      <!--<li><?php echo $this->Html->link(__d('slots', 'Add Bands'), array('controller' => 'slots', 'action'=>'add'));?></li>-->
</ul>
