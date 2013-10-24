<div id="page-container" class="row">
	
	<div id="page-content" class="col-sm-12">
		
			<h2><?php echo __('Loans'); ?></h2>
		
		<div class="loans index">
			<div class="table-responsive">
				<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('person_id'); ?></th>
							<th><?php echo $this->Paginator->sort('book_id'); ?></th>
							<th><?php echo $this->Paginator->sort('created', __('Loan')); ?></th>
							<th><?php echo $this->Paginator->sort('loan_time'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php foreach ($loans as $loan): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($loan['Person']['name'], array('controller' => 'people', 'action' => 'view', $loan['Person']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($loan['Book']['title'], array('controller' => 'books', 'action' => 'view', $loan['Book']['id'])); ?>
		</td>
		<td><?php echo h($loan['Loan']['created']); ?>&nbsp;</td>
		<td><?php echo h($loan[0]['loan_time']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $loan['Loan']['id']), array('class' => 'btn btn-default btn-xs')); ?>
		</td>
	</tr>
<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
			
			<p><small>
				<?php
				echo $this->Paginator->counter(array(
				'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
				));
				?>			</small></p>

			<ul class="pagination">
				<?php
		echo $this->Paginator->prev('< ' . __('Previous'), array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
		echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'currentClass' => 'disabled'));
		echo $this->Paginator->next(__('Next') . ' >', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
	?>
			</ul><!-- /.pagination -->
			
		</div><!-- /.index -->

		<?php echo $this->element('People/loan'); ?>

	</div><!-- /#page-content .col-sm-12 -->

</div><!-- /#page-container .row-fluid -->
