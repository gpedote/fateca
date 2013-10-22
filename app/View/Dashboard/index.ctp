<h2><?php echo __('Dashboard'); ?></h2>
<ul>
    <li><?php echo $this->Html->link(__('Rebuild ACO Tree'), array('controller' => 'dashboard', 'action' => 'database', 'aco'), null, __('Are you sure you want to rebuild this tree?')); ?> <small><?php echo __('(Actions & Controllers)'); ?></small></li>
    <li><?php echo $this->Html->link(__('Rebuild ARO Tree'), array('controller' => 'dashboard', 'action' => 'database', 'aro'), null, __('Are you sure you want to rebuild this tree?')); ?> <small><?php echo __('(Users & Groups)'); ?></small></li>
    <li><?php echo $this->Html->link(__('Manage Users'), array('controller' => 'people', 'action' => 'user_index'), array('class' => '')); ?></li>
    <li><?php echo $this->Html->link(__('Manage Groups'), array('controller' => 'groups', 'action' => 'index'), array('class' => '')); ?></li>
</ul>