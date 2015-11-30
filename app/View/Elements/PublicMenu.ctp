
<ul>
   <li><?php echo $this->Html->link(_('View Calendar'), array('controller' => 'calendar', 'action'=>'index'));?></li>
   <li><?php 
   echo AuthComponent::user() ? 
   		$this->Html->link(_('Logout'), array(
   				'controller' => 'LoginAccount', 
   				'action' => 'logout' 
   		)) :
   		$this->Html->link(_('Login'),array(
   				'controller' => 'LoginAccount',
   				'action' => 'login' )); 
   ?></li>
      <li>&nbsp;</li>
</ul>
