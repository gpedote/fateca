<?php
    if (!isset($loans)) {
        $loans = $this->requestAction('/loans/cart');
    }
?>

<div class="table-responsive">
    <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?php echo __('Book'); ?></th>
                <th><?php echo __('Type'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody id="books-table-body">
    <?php foreach ($loans as $loan): ?>
        <tr>
            <td>
                <?php echo $this->Html->link($loan['Book']['title'], array('controller' => 'books', 'action' => 'view', $loan['Book']['id'])); ?>
            </td>
            <td>
                <?php echo $this->Html->link($loan['Type']['type'], array('controller' => 'types', 'action' => 'view', $loan['Type']['id'])); ?>
            </td>
            <td>        
                <?php echo $this->Form->create(null, array()); ?>
                <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $loan['Book']['id'])); ?>
                <?php echo $this->Form->button(__('Remove'), array('class' => 'rm btn btn-primary btn-xs', 'id' => $loan['Book']['id']));?>
                <?php echo $this->Form->end(); ?>
            </td>
        </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
</div><!-- /.table-responsive -->
