
<ul>
   <li><?php echo $this->Html->link(_('View band info'), array('controller' => 'bands', 'action'=>'view'));?></li>
   <li><?php echo $this->Html->link(_('Modify band info'), array('controller' => 'bands', 'action'=>'edit'));?></li>
   <li>&nbsp;</li>
   <li><?php echo $this->Html->link(_('Change password'), array('controller' => 'LoginAccount', 'action'=>'changepw'));?></li>
</ul>
