<?php
    $options = array(
        'update' => '#people-index',
        'evalScripts' => true,
        'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
        'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false))  
    );

    if (!isset($people)) {
        $data = $this->requestAction(array('controller' => 'people', 'action' => 'loan'));
        if(!isset($this->params['paging'])) {
            $this->params['paging'] = array();
        }
        $this->params['paging'] = array_merge( $this->params['paging'] , $data['paging'] );
        $people = $data['people'];
        $options['url'] =  array('controller'=>'people', 'action'=>'loan');
    }

    $this->Paginator->options($options);
?>
<?php if (!$this->request['isAjax']): ?>
    <div class="people form">
        <?php 
            echo $this->element('form-search', array(
                    'title' => 'Person', 
                    'submitPath' => array(
                        'controller' => 'people', 
                        'action' => 'loan',
                    ), 
                    'formId' => 'PersonFindForm',
                    'inputId' => 'PersonFind',
                )
            );
        ?>
    </div>
<?php endif; ?>
<div id="people-index" class="people index">
    <div class="table-responsive">
        <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('ra'); ?></th>
                    <th><?php echo $this->Paginator->sort('person_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('group_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('loans'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody id="books-table-body">
            <?php foreach ($people as $person): ?>
                <tr>
                    <td><?php echo h($person['Person']['ra']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($person['Person']['name'], array('controller' => 'people', 'action' => 'view', $person['Person']['id'])); ?>
                    </td>

                    <td>
                        <?php echo $this->Html->link($person['Group']['name'], array('controller' => 'groups', 'action' => 'view', $person['Group']['id'])); ?>
                    </td>
                    <td>
                        <?php echo h($person[0]['Loans']); ?>
                    </td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Loan'), array('controller' => 'loans', 'action' => 'add', $person['Person']['id']), array('class' => 'btn btn-default btn-xs')); ?>
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
        $this->Html->script('People/query', array('block' => 'scriptBottom'));
    }
?>