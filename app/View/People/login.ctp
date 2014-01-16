<div class="page-header">
    <h2 class="login"><?php echo 'FATECA'; ?></h2>
</div>
<?php
    echo $this->Form->create('Person', array(
            'url' => array('controller' => 'people', 'action' => 'login'),
            'class' => 'form-signin',
            'role' => 'form',
            'label' => false,
        )
    );
    echo $this->Form->input('Person.username', array(
            'div' => false,
            'class' => 'form-control',
            'autofocus' => 'autofocus',
            'label' => false,
            'placeholder' => __('Username'),
        )
    );
    echo $this->Form->input('Person.password', array(
            'div' => false,
            'class' => 'form-control',
            'label' => false,
            'value' => '',
            'placeholder' => __('Password'),
        )
    );
    echo $this->Form->button(__('Login'), 
        array('class' => 'btn btn-primary btn-block btn-lg', 'title' => __('Login'))
    );
    echo $this->Form->end();
?>