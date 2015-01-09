<h3><?php 
echo $memberData['Member']['first_name']; 
?> <?php 
echo $memberData['Member']['last_name']; 
?></h3>
<p> Email: <?php echo $memberData['Member']['email']; ?> </p>

<h3>This member belongs to following bands</h3>

<?php
echo $this->element('BandList', array('bands' => $memberData['Band']));

?>
