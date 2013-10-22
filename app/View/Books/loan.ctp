
<?php if (!$this->request['isAjax']): ?>
<div id="page-container" class="row">

	<div id="sidebar" class="col-sm-3">

		<div class="actions">	
			<ul class="list-group">
		<li class="list-group-item"><?php echo $this->Html->link(__('New Book'), array('action' => 'add'), array('class' => '')); ?></li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List Types'), array('controller' => 'types', 'action' => 'index'), array('class' => '')); ?></li> 
		<li class="list-group-item"><?php echo $this->Html->link(__('New Type'), array('controller' => 'types', 'action' => 'add'), array('class' => '')); ?></li> 
		<li class="list-group-item"><?php echo $this->Html->link(__('List Isbns'), array('controller' => 'isbns', 'action' => 'index'), array('class' => '')); ?></li> 
		<li class="list-group-item"><?php echo $this->Html->link(__('New Isbn'), array('controller' => 'isbns', 'action' => 'add'), array('class' => '')); ?></li> 
		<li class="list-group-item"><?php echo $this->Html->link(__('List Loans'), array('controller' => 'loans', 'action' => 'index'), array('class' => '')); ?></li> 
		<li class="list-group-item"><?php echo $this->Html->link(__('New Loan'), array('controller' => 'loans', 'action' => 'add'), array('class' => '')); ?></li> 
			</ul><!-- /.list-group -->
		</div><!-- /.actions -->
		
	</div><!-- /#sidebar .col-sm-3 -->
<?php endif; ?>
<?php
	$this->Paginator->options(array(
    	'update' => '#books-index',
    	'evalScripts' => true,
	    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    	'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
	));
?>
<?php if (!$this->request['isAjax']): ?>
	<div id="page-content" class="col-sm-9">
		<h2><?php echo __('Books'); ?></h2>

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

<?php endif; ?>

		<div id="books-index" class="books index">
			<div class="table-responsive">
				<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('book_id'); ?></th>
							<th><?php echo $this->Paginator->sort('types'); ?></th>
							<th class="actions"><?php echo __('Loan'); ?></th>
						</tr>
					</thead>
					<tbody id="books-table-body">
			<?php foreach ($books as $book): ?>
				<tr>
					<td>
						<?php echo $this->Html->link($book['Book']['title'], array('controller' => 'books', 'action' => 'view', $book['Book']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($book['Types']['type'], array('controller' => 'types', 'action' => 'view', $book['Types']['id'])); ?>
					</td>
					<td>		
		                <?php echo $this->Form->create(null, array()); ?>
		                <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $book['Book']['id'])); ?>
		                <?php echo $this->Form->button(__('Add'), array('class' => 'add btn btn-primary btn-xs', 'id' => $book['Book']['id']));?>
		                <?php echo $this->Form->end(); ?>
					</td>
				</tr>
			<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->

			<p>
				<small>
				<?php
					echo $this->Paginator->counter(array(
					'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
					));
				?>
				</small>
			</p>

			<ul class="pagination">
			<?php
				echo $this->Paginator->prev('< ' . __('Previous'), array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
				echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'currentClass' => 'disabled'));
				echo $this->Paginator->next(__('Next') . ' >', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
	    		echo $this->Js->writeBuffer();
			?>
			</ul><!-- /.pagination -->
		</div><!-- /.index -->

<?php if (!$this->request['isAjax']): ?>
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
	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->
<?php endif; ?>