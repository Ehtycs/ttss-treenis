
<ul>
   <li>&nbsp;</li>
   <li><?php echo $this->Html->link(_('Make a reservation'), array('controller' => 'Reservations', 'action'=>'add'));?></li>
   <li><?php echo $this->Html->link(_('View band info'), array('controller' => 'bands', 'action'=>'view'));?></li>
   <li><?php echo $this->Html->link(_('View Calendar'), array('controller' => 'calendar', 'action'=>'index'));?></li>
</ul>
