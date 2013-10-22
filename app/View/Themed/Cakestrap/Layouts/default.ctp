<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$fatecaDescription = __d('fateca', 'FATECA: Library management program');
?>
<?php echo $this->Html->docType('html5'); ?> 
<html>
	<head>
		<?php echo $this->Html->charset(); ?>
		<title>
			<?php echo $fatecaDescription ?>:
			<?php echo $title_for_layout; ?>
		</title>
		<?php
			echo $this->Html->meta('favicon.ico');
			
			echo $this->fetch('meta');

			echo $this->Html->css('bootstrap.min');
			// Uncomment this to enable the bootstrap gradient theme
			//echo $this->Html->css('bootstrap-theme.min');
			echo $this->Html->css('core');
			echo $this->Html->css('main');
			
			echo $this->fetch('css');

			echo $this->Html->script('libs/jquery-1.9.1.min');
			echo $this->Html->script('libs/bootstrap.min');
			//echo $this->Html->script('jquery-ui');
			echo $this->Html->script('main');
			
			echo $this->fetch('script');
		?>
	</head>

	<body>

		<div id="main-container">
		
			<div id="header" class="container">
				<?php echo $this->element('menu/top_menu'); ?>
			</div><!-- /#header .container -->
			
			<div id="content" class="container">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div><!-- /#header .container -->
			
			 <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
			
		</div><!-- /#main-container -->

		
		<!--<div class="container footer">-->
			<?php //echo $this->element('menu/footer_menu'); ?>
		<!--</div>-->

		<div class="container">
			<div class="well well-sm">
				<small>
					<?php echo $this->element('sql_dump'); ?>
				</small>
			</div><!-- /.well well-sm -->
		</div><!-- /.container -->

		<!-- Js included in views -->
		<?php echo $this->fetch('scriptBottom'); ?>
		
	</body>

</html>