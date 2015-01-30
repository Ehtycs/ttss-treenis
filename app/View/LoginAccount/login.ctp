<h3>Login:</h3>
<?php 
echo $this->Form->create('LoginAccount', array('url' => array('controller' => 'LoginAccount', 'action' => 'login')));
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->end('Login');

?>
