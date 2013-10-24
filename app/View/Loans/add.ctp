<div id="page-container" class="row">
	
	<div id="page-content" class="col-sm-12">

		<div class="page-header">
		  <h2><?php echo __('New Loan'); ?> <small><?php echo h(__('TO') . ': ' . $person['Person']['name']); ?></small></h2>
		</div>

		<div id="cart-index" class="cart index">
			<?php echo $this->element('Loans/cart');  ?>
		</div>

		<?php echo $this->element('Books/loan'); ?>

		<?php			
			$this->Js->set('maxAdd', 2);
			echo $this->Js->writeBuffer();
			$this->Html->script('Loans/add', array('block' => 'scriptBottom'));
			$this->Html->script('Loans/remove', array('block' => 'scriptBottom'));
		?>

	</div><!-- /#page-content .col-sm-12 -->

</div><!-- /#page-container .row-fluid -->
