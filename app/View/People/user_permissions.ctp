
<div id="page-container" class="row">
	
	<div id="page-content" class="col-sm-9">

		<div class="people index">

		<h2><?php echo __('Manage %s Permissions', $person['Person']['username']); ?></h2>
		<div class="table-responsive">
<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th><?php echo __('Aco'); ?></th>
			<th><?php echo __('Permissions'); ?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach($perms as $perm): ?>
	<tr>
		<td><?php echo $perm['Aco']['alias']; ?></td>
		<td  class="actions">
			<?php
				if ($perm['Aco']['perm'] === 'allow') {
					echo $this->Html->link(__('Deny'), array(
						'controller' => 'people', 
						'action' => 'user_permissions', 
						$person['Person']['id'], 
						'?' => array(
							'perm' => 'deny',
							'aro' => $person['Person']['username'],
							'aco' => $perm['Aco']['alias'],
						)
					), array('class' => 'btn btn-default btn-xs btn-danger'));
				} else if ($perm['Aco']['perm'] === 'deny') {
					echo $this->Html->link(__('Allow'), array(
						'controller' => 'people', 
						'action' => 'user_permissions', 
						$person['Person']['id'], 
						'?' => array(
							'perm' => 'allow',
							'aro' => $person['Person']['username'],
							'aco' => $perm['Aco']['alias'],
						)
					), array('class' => 'btn btn-default btn-xs btn-success'));
				}
			?>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
</div><!-- /.table-responsive -->

		</div><!-- /.index -->
	
	</div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
