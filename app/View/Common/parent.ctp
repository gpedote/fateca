<div id="page-container" class="row">
    
    <?php if ($this->fetch('sidebar')): ?>
        <div id="sidebar" class="col-3 col-sm-3">
            <?php echo $this->fetch('sidebar'); ?>
        </div>

        <div id="page-content" class="col-9 col-sm-9">
    <?php else: ?>
        <div id="page-content" class="col-12 col-sm-12">
    <?php endif; ?>

        <?php if ($this->fetch('title')): ?>
            <div class="page-header">
                <h2><?php echo $this->fetch('title'); ?></h2>
            </div>
        <?php endif; ?>
        
        <?php if ($this->fetch('pagecontent')): ?>
            <?php echo $this->fetch('pagecontent'); ?>
        <?php endif; ?>

        <?php if ($this->fetch('pagination')): ?>
            <p><small>
                <?php 
                    echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
                ?>
            </small></p>
            <ul class="pagination">
            <?php 
                echo $this->Paginator->prev('< ' . __('Previous'), array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
                echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'currentClass' => 'disabled'));
                echo $this->Paginator->next(__('Next') . ' >', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
            ?>
            </ul><!-- /.pagination -->
        <?php endif; ?>

    </div><!-- /#page-content -->

</div><!-- /#page-container .row-fluid -->