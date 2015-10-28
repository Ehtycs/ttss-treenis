<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo "TTSS Rehearsal room reservation system" ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	
	<?php
		echo $this->Html->meta('ttss-icon.gif');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('booking-calendar');
		//echo $this->Html->css('navigation');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	
</head>
<body>
	<div id="container" class="container">
		<div>
			<!-- <h1>TTSS - Tampereen teekkarien soitannollinen seura, rehearsal room reservation system</h1> -->
			<?php echo $this->Html->image("ttss-logo.png", array("style" => "display: block; margin-bottom: -50px;")); ?>
			<?php if (AuthComponent::user('id')): ?>
  				 Logged in as <?php 
  				 if(AuthComponent::user('Member')['id']) {
  				 		echo AuthComponent::user('Member')['first_name'].' '.AuthComponent::user('Member')['last_name'];
  				 }
  				 else {
  				 		echo AuthComponent::user('Band')['name'];
  				 }
  				 ?> (<?= AuthComponent::user('username')?>) <?= $this->Html->link('Logout', array('controller' => 'LoginAccount', 'action' => 'logout')) ?>
  				 
			<?php endif; ?>
		</div>
		<nav class="navbar navbar-nav">
		<div class="container-fluid">
		<ul class="nav navbar-nav"> 
			<?php echo $this->element('PublicMenu'); ?>
			<?php if (AuthComponent::user('band_id')): ?>
			<?php echo $this->element('UserMenu');?>
			<?php endif; ?>
			
			<?php if(AuthComponent::user('admin')) {
				echo $this->element('AdminMenu');
			}?>
		</ul>
		</div>
		</nav>
		
		<div id="content">
         <!--<div class="view"> -->
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
			</div>
			  <!--  <div class="actions">
		
			</div> -->
		<!-- </div>-->
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
	<?php echo $this->Session->flash(); ?>
   <?php echo $this->Session->flash('email'); ?>
</body>
</html>
