<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $theme = "Cakestrap";

    public $components = array(
        'Acl',
        'Session',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array(
                    'actionPath' => 'controllers',
                    'userModel' => 'Person'
                )
            ),
            'loginAction' => array(
                'controller' => 'people',
                'action' => 'login'
            ),
            'loginRedirect' => array(
                'controller' => 'pages', 
                'action' => 'display',
                'index'
            ),
            'logoutRedirect' => array(
                'controller' => 'people', 
                'action' => 'login'
            ),
            'authError' => 'You can\'t access this page',
            'authenticate' => array(
                'Authenticate.MultiColumn' => array(
                    'fields' => array(
                        'username' => 'username',
                        'password' => 'password'
                    ),
                    'columns' => array('username'),
                    'userModel' => 'Person', 
                    //'scope' => array('User.active' => 1)
                )
            ),
        ),
    );
    
    public $helpers = array('Html', 'Form', 'Session');

    public $paginate = array();

/**
 * beforeRender method
 *
 * @return void
 */
    public function beforeRender() {
        parent::beforeRender();
        if ($this->Auth->user()['username'] !== '') {
            $this->set('authUser', $this->Auth->user()['username']);
        }
    }

/**
 * beforeFilter method
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();

        $this->paginate = array('limit' => 10);

        // Disable cake for secure logout
        if ($this->action === 'logout') {
            $this->response->disableCache();
        }
    }
}
    