<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button><!-- /.navbar-toggle -->
		<?php echo $this->Html->Link('#FATECA', array('controller' => 'pages', 'action' => 'display', 'index'), array('class' => 'navbar-brand')); ?>
	</div><!-- /.navbar-header -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Collection'); ?> <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><?php echo $this->Html->Link(__('New Loan'), array('controller' => 'loans', 'action' => 'initLoan')); ?></li>
					<li><?php echo $this->Html->Link(__('Copies'), array('controller' => 'books', 'action' => 'index')); ?></li>
					<li><?php echo $this->Html->Link(__('Devolution'), array('controller' => 'loans', 'action' => 'devolution')); ?></li>
				</ul>
			</li>
		</ul><!-- /.nav navbar-nav -->
		<?php if (isset($authUser)): ?>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $authUser; ?> <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo $this->Html->url(
												array(
												    "controller" => "people",
												    "action" => "logout",
												)
											);?>">
						<?php echo __('Log out')?></a>
					</li>
				</ul>
				</li>
			</ul>
		<?php endif; ?>
	</div><!-- /.navbar-collapse -->
</nav><!-- /.navbar navbar-default -->