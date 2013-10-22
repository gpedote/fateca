<div class="row">
    <div class="col-md-6 col-lg-4">
        <?php
            echo $this->Form->create($title, array(
                'url' => array_merge($submitPath, $this->params['pass']), 
                'default' => false, 
                'class' => 'form-inline',
                'role' => 'form',
                'id' => $formId,
                'inputDefaults' => array('label' => false),
            ));
        ?>

        <div class="input-group">
            <?php
                echo $this->Form->input('find', array(
                        'id' => $inputId,
                        'div' => false, 
                        'class' => 'form-control',
                        'placeholder' => __('Search'),
                    )
                );
            ?>
              <span class="input-group-btn">
                <?php
                    echo $this->Form->button(__('Go!'), array('class' => 'btn btn-default', 'title' => __('Go!'))
                    );
                ?>
              </span>
        </div><!-- /input-group -->
        <?php
            echo $this->Form->end();
        ?>
    </div>
</div>
<?php 
 /*
    'title' => 'Person', 
    'submitPath' => array(
        'controller' => 'people', 
        'action' => 'index'
    ), 
    'formId' => 'PersonFindForm'
    'inputId' => 'PersonFind'
*/
?>