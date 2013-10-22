<?php if (!$this->request['isAjax']): ?>
<div id="page-container" class="row">

	<div id="sidebar" class="col-sm-3">

		<div class="actions">	
			<ul class="list-group">
				<li class="list-group-item"><?php echo $this->Html->link(__('New Person'), array('action' => 'add'), array('class' => '')); ?></li>
				<li class="list-group-item"><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index'), array('class' => '')); ?></li> 
				<li class="list-group-item"><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add'), array('class' => '')); ?></li> 
				<li class="list-group-item"><?php echo $this->Html->link(__('List Emails'), array('controller' => 'emails', 'action' => 'index'), array('class' => '')); ?></li> 
				<li class="list-group-item"><?php echo $this->Html->link(__('New Email'), array('controller' => 'emails', 'action' => 'add'), array('class' => '')); ?></li> 
				<li class="list-group-item"><?php echo $this->Html->link(__('List Loans'), array('controller' => 'loans', 'action' => 'index'), array('class' => '')); ?></li> 
				<li class="list-group-item"><?php echo $this->Html->link(__('New Loan'), array('controller' => 'loans', 'action' => 'add'), array('class' => '')); ?></li> 
				<li class="list-group-item"><?php echo $this->Html->link(__('List Phones'), array('controller' => 'phones', 'action' => 'index'), array('class' => '')); ?></li> 
				<li class="list-group-item"><?php echo $this->Html->link(__('New Phone'), array('controller' => 'phones', 'action' => 'add'), array('class' => '')); ?></li> 
			</ul><!-- /.list-group -->
		</div><!-- /.actions -->
		
	</div><!-- /#sidebar .col-sm-3 -->
<?php endif; ?>
<?php
	$this->Paginator->options(array(
    	'update' => '#people-index',
    	'evalScripts' => true,
	    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    	'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
	));
?>
<?php if (!$this->request['isAjax']): ?>
	<div id="page-content" class="col-sm-9">
		<h2><?php echo __('People'); ?></h2>

		<?php 
			echo $this->element('form-search', array(
					'title' => 'Person', 
					'submitPath' => array(
				        'controller' => 'people', 
				        'action' => 'index',
				    ), 
		    		'formId' => 'PersonFindForm',
		    		'inputId' => 'PersonFind',
				)
			);
		?>

<?php endif; ?>

		<div id="people-index" class="people index">
			<div class="table-responsive">
				<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('ra'); ?></th>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('group_id'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
			<?php foreach ($people as $person): ?>
				<tr>
					<td><?php echo h($person['Person']['ra']); ?>&nbsp;</td>
					<td><?php echo h($person['Person']['name']); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($person['Group']['name'], array('controller' => 'groups', 'action' => 'view', $person['Group']['id'])); ?>
					</td>
					<td class="actions">
						<?php echo $this->Html->link(__('View'), array('action' => 'view', $person['Person']['id']), array('class' => 'btn btn-default btn-xs')); ?>
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $person['Person']['id']), array('class' => 'btn btn-default btn-xs')); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $person['Person']['id']), array('class' => 'btn btn-default btn-xs'), __('Are you sure you want to delete # %s?', $person['Person']['id'])); ?>
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
			    'update' => '#people-index',
			    'submitPath' => array(
			        'controller' => 'people', 
			        'action' => 'index',
			    ), 
			    'formId' => '#PersonFindForm',
			    'inputId' => '#PersonFind',
			)
		);
	?>
	
	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->
<?php endif; ?>