<div id="page-container" class="row">
    <div class="col-6 col-sm-4 col-md-4 col-lg-3">
        <?php 
            echo $this->Html->image(
                'home/books_s.jpg', 
                array(
                    'alt' => __('Copies'),
                    'url' => array('controller' => 'books', 'action' => 'index'),
                    'class' => array('img-responsive', 'img-rounded'),
                )
            );
        ?>
        <h3><?php echo __('Copies'); ?></h3>
        <p class="text-left"><?php echo __('In this section you can make loans of copies and consult the collection.'); ?></p>
    </div>
    <div class="col-6 col-sm-4 col-md-4 col-lg-3">
        <?php 
            echo $this->Html->image(
                'home/dev_s.jpg', 
                array(
                    'alt' => __('Devolution'),
                    'url' => array('controller' => 'loans', 'action' => 'devolution'),
                    'class' => array('img-responsive', 'img-rounded'),
                )
            );
        ?>
        <h3><?php echo __('Devolution'); ?></h3>
        <p class="text-left"><?php echo __('In this section you can receive the loans and take the fines.'); ?></p>
    </div> 
    <div class="col-6 col-sm-4 col-md-4 col-lg-3">
        <?php 
            echo $this->Html->image(
                'home/people_s.jpg', 
                array(
                    'alt' => __('People'),
                    'url' => array('controller' => 'people', 'action' => 'index'),
                    'class' => array('img-responsive', 'img-rounded'),
                )
            );
        ?>
        <h3><?php echo __('People'); ?></h3>
        <p class="text-left"><?php echo __('In this section you can see registered people and information about them.'); ?></p>
    </div>
    <div class="col-6 col-sm-4 col-md-4 col-lg-3">
        <?php 
            echo $this->Html->image(
                'home/admin_s.jpg', 
                array(
                    'alt' => __('Administrator'),
                    'url' => array('controller' => 'dashboard', 'action' => 'index'),
                    'class' => array('img-responsive', 'img-rounded'),
                )
            );
        ?>
        <h3><?php echo __('Administrator'); ?></h3>
        <p class="text-left"><?php echo __('In this section you can edit users permissions and configurations'); ?></p>
    </div>
</div>