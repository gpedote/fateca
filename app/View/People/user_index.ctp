
<div id="page-container" class="row">
	
	<div id="page-content" class="col-sm-9">

		<div class="people index">

		<h2><?php echo __('Manage Users'); ?></h2>
		<div class="table-responsive">
<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
	<thead>
		<tr>
				<th><?php echo $this->Paginator->sort('username');?></th>
				<th><?php echo $this->Paginator->sort('group_id');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
		</tr>
	</thead>
	<tbody>

<?php foreach ($people as $person): ?>
	<tr>
		<td>
			<?php echo h($person['Person']['username']) ?>
		</td>
		<td>
			<?php echo $this->Html->link($person['Group']['name'], array('controller' => 'groups', 'action' => 'view', $person['Group']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $person['Person']['id']), array('class' => 'btn btn-default btn-xs')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $person['Person']['id']), array('class' => 'btn btn-default btn-xs')); ?>
			<?php echo $this->Html->link(__('Permissions'), array('controller' => 'people', 'action' => 'user_permissions', $person['Person']['id']), array('class' => 'btn btn-default btn-xs')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $person['Person']['id']), array('class' => 'btn btn-default btn-xs'), __('Are you sure you want to delete # %s?', $person['Person']['id'])); ?>
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
			?>
	</small></p>

		<ul class="pagination">
	<?php
	echo $this->Paginator->prev('< ' . __('Previous'), array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
	echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'currentClass' => 'disabled'));
	echo $this->Paginator->next(__('Next') . ' >', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
	?>
		</ul><!-- /.pagination -->
			
		</div><!-- /.index -->
	
	</div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
