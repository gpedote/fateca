<?php
    $data = $this->Js->get($formId)->serializeForm(array('isForm' => false, 'inline' => true));
    $before = $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false));
    $complete = $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false));
    
    $this->Js->get($inputId)->event(
        'change paste keyup',
        $this->Js->request(
            $submitPath,
            array(
                'update' => $update,
                'data' => $data,
                'async' => true,
                'dataExpression'=>true,
                'method' => 'POST',
                'before' => $before,
                'complete' => $complete
            )
        )
    );
    
    echo $this->Js->writeBuffer();
?>

<?php 
 /*
    'update' => '#people-index'
    'submitPath' => array(
        'controller' => 'people', 
        'action' => 'index'
    ), 
    'formId' => '#PersonFindForm'
    'inputId' => '#PersonFind'
*/
?>