<?php
    $options = array(
        'update' => '#books-index',
        'evalScripts' => true,
        'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
        'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false))  
    );

    if (!isset($books)) {
        $data = $this->requestAction(array('controller' => 'books', 'action' => 'loan'));
        if(!isset($this->params['paging'])) {
            $this->params['paging'] = array();
        }
        $this->params['paging'] = array_merge( $this->params['paging'] , $data['paging'] );
        $books = $data['books'];
        $options['url'] =  array('controller'=>'books', 'action'=>'loan');
    }

    $this->Paginator->options($options);
?>
<?php if (!$this->request['isAjax']): ?>
    <div class="books form">
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
    </div>
<?php endif; ?>
<div id="books-index" class="books index">
    <div class="table-responsive">
        <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('title', 'Book'); ?></th>
                    <th><?php echo $this->Paginator->sort('type', 'Types'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
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
<?php
    if (!$this->request['isAjax']) {
        $this->Html->script('Books/query', array('block' => 'scriptBottom'));
    }
?>