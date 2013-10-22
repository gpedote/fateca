
<div id="page-container" class="row">

	<div id="sidebar" class="col-sm-3">
		
		<div class="actions">
			
			<ul class="list-group">			
						<li class="list-group-item"><?php echo $this->Html->link(__('Edit Isbn'), array('action' => 'edit', $isbn['Isbn']['id']), array('class' => '')); ?> </li>
		<li class="list-group-item"><?php echo $this->Form->postLink(__('Delete Isbn'), array('action' => 'delete', $isbn['Isbn']['id']), array('class' => ''), __('Are you sure you want to delete # %s?', $isbn['Isbn']['id'])); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List Isbns'), array('action' => 'index'), array('class' => '')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New Isbn'), array('action' => 'add'), array('class' => '')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List Books'), array('controller' => 'books', 'action' => 'index'), array('class' => '')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New Book'), array('controller' => 'books', 'action' => 'add'), array('class' => '')); ?> </li>
				
			</ul><!-- /.list-group -->
			
		</div><!-- /.actions -->
		
	</div><!-- /#sidebar .span3 -->
	
	<div id="page-content" class="col-sm-9">
		
		<div class="isbns view">

			<h2><?php  echo __('Isbn'); ?></h2>
			
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<tbody>
						<tr>		<td><strong><?php echo __('Id'); ?></strong></td>
		<td>
			<?php echo h($isbn['Isbn']['id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Book'); ?></strong></td>
		<td>
			<?php echo $this->Html->link($isbn['Book']['title'], array('controller' => 'books', 'action' => 'view', $isbn['Book']['id']), array('class' => '')); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Isbn10'); ?></strong></td>
		<td>
			<?php echo h($isbn['Isbn']['isbn10']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Isbn13'); ?></strong></td>
		<td>
			<?php echo h($isbn['Isbn']['isbn13']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
		<td>
			<?php echo h($isbn['Isbn']['created']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
		<td>
			<?php echo h($isbn['Isbn']['modified']); ?>
			&nbsp;
		</td>
</tr>					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->

			
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
