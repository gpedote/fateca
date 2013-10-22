<div id="page-container" class="row">
	
	<div id="page-content" class="col-sm-12">

		<div class="page-header">
		  <h2><?php echo __('New Loan'); ?> <small><?php echo h(__('TO') . ': ' . $person['Person']['name']); ?></small></h2>
		</div>

		<div id="cart-index" class="cart index"></div>

		<div class="loans form">
		<?php 
			echo $this->element('form-search', array(
					'title' => 'Book', 
					'submitPath' => array(
				        'controller' => 'books', 
				        'action' => 'loan',
				    ), 
		    		'formId' => 'BookFindForm',
		    		'inputId' => 'BookFind',
				)
			);
		?>
		</div><!-- /.form -->
		
		<div id="books-index" class="books index"></div>
		<?php
			echo $this->element('form-search-js', array(
				    'update' => '#books-index',
				    'submitPath' => array(
				        'controller' => 'books', 
				        'action' => 'loan',
				    ), 
				    'formId' => '#BookFindForm',
				    'inputId' => '#BookFind',
				)
			);
		?>

		<?php			
			$this->Js->set('maxAdd', 2);
			echo $this->Js->writeBuffer();
			$this->Html->script('Loans/add', array('block' => 'scriptBottom'));
		?>

	</div><!-- /#page-content .col-sm-12 -->

</div><!-- /#page-container .row-fluid -->
