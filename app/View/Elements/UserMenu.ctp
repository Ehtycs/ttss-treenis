

   <li><?php echo $this->Html->link(_('Band info'), array('controller' => 'bands', 'action'=>'view'));?></li>
   <!--<li><?php echo $this->Html->link(_('Modify band info'), array('controller' => 'bands', 'action'=>'edit'));?></li>-->
   <li><?php echo $this->Html->link(_('Change password'), array('controller' => 'LoginAccount', 'action'=>'changepw'));?></li>
   <li><?php 
   echo	$this->Html->link(_('Logout'), array(
   				'controller' => 'LoginAccount', 
   				'action' => 'logout' 
   		))
   ?></li>


