

   <li><?php echo $this->Html->link(_('Calendar'), array('controller' => 'calendar', 'action'=>'index'));?></li>
   <?php if(!AuthComponent::user()): ?>
   <li><?php 
   echo $this->Html->link(_('Login'),array(
   				'controller' => 'LoginAccount',
   				'action' => 'login' )); 
   ?></li>
   <li><?php echo $this->Html->link(_('Rehearsal room info'),  'http://www.ttss.fi?page=rehearsal');?></li>
   <?php endif; ?>

