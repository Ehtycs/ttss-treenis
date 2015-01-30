
<h2>Add a login account</h2>
<?php
echo $this->Form->create('LoginAccount');
echo $this->Form->input('username');
echo $this->Form->input('password');
?>
<p>Login account can be tied either to user (admin account) or to a band (booking account).</p>
<?php 
echo $this->Form->input('Band', array('default' => 0));
echo $this->Form->input('Member', array('default' => 0));
?>


<p>
Is an admin account <?php  
echo $this->Form->checkbox('admin');
?>
</p>

<?php 
echo $this->Form->end('Add account');
?>