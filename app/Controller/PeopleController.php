<?php
App::uses('AppController', 'Controller');
/**
 * People Controller
 *
 * FATECA : Library Collection Manager
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author gpedote -- gabriel.pedote@fatec.sp.gov.br
 * @copyright Copyright (c) 2013, G.L.Pedote
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @property Person $Person
 */
class PeopleController extends AppController {

/**
 * Uses (Models)
 * OBS: Keep Person model first
 * @var array
 */    
	public $uses = array('Person', 'Group');

/**
 * Helpers
 *
 * @var array
 */    
	public $helpers = array('Js' => array('Jquery'));

/**
 * Components
 *
 * @var array
 */    
    public $components = array(
    	'RequestHandler', 

    	'Search.Prg' => array(
	        'presetForm' => array(
	            'paramType' => 'named',
	            'model' => 'Person',
	        ),
	        'commonProcess' => array(
                'model' => 'Person',
	            'formName' => null,
	            'keepPassed' => true,
	            'action' => null,
	            'modelMethod' => 'validateSearch',
	            'allowlowedParams' => array(),
	            'paramType' => 'named',
	            'filterEmpty' => false,
	        ),
    	),
	);   

    public $presetVars = true;

/**
 * index method
 *
 * @return void
 */
	public function index() {
        if ($this->request->is('ajax')) {
            $this->Prg->commonProcess('Person');
            $searchConditions = array(
                    'conditions' => $this->Person->parseCriteria($this->Prg->parsedParams())
            );
            $this->paginate = am($this->paginate, $searchConditions);
            $this->set('people', $this->paginate());
            $this->render('index', 'ajax');
        }
		$this->Person->recursive = 0;
		$this->set('people', $this->paginate('Person'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Person->exists($id)) {
			throw new NotFoundException(__('Invalid person'));
		}
		$options = array('conditions' => array('Person.' . $this->Person->primaryKey => $id));
		$this->set('person', $this->Person->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Person->create();
			if ($this->Person->save($this->request->data)) {
				$this->Session->setFlash(__('The person has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$groups = $this->Person->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->Person->id = $id;
		if (!$this->Person->exists($id)) {
			throw new NotFoundException(__('Invalid person'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Person->save($this->request->data)) {
				$this->Session->setFlash(__('The person has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Person.' . $this->Person->primaryKey => $id));
			$this->request->data = $this->Person->find('first', $options);
		}
		$groups = $this->Person->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Person->id = $id;
		if (!$this->Person->exists()) {
			throw new NotFoundException(__('Invalid person'));
		}
		if ($this->Person->delete()) {
			$this->Session->setFlash(__('Person deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Person was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * login method
 *
 * @return void
 */
	public function login() {
        $this->layout = 'login';
        /* Strange thing is Auth.User not Auth.Person*/
        if ($this->Session->read('Auth.User')) {
            $this->Session->setFlash(__('You are logged in!'), 'flash/success');
            return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'index'));
        }
	    if ($this->request->is('post')) {
            if ($this->Auth->login()) {
			    return $this->redirect($this->Auth->redirect());
			}
	        $this->Session->setFlash(__('Your username or password was incorrect.'), 'flash/error');
	    }
	}

/**
 * logout method
 *
 * @return void
 */
	public function logout() {
        $this->layout = 'login';
		$this->Auth->logout();
		$this->response->disableCache();
		$this->Session->setFlash(__('You have successfully logged out'), 'flash/success');
		$this->redirect(array('action'=>'login'));
	}

/**
 * beforeFilter method
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login','logout');
    }

/**
 * Loan method
 *
 * @throws MethodNotAllowedException
 * @return void
 */
    public function loan() {
        if (empty($this->request->params['requested']) && !$this->request->is('ajax')) {
            throw new MethodNotAllowedException();
        }
        $this->Prg->commonProcess('Person');
        $searchConditions = array(
            'findType' => 'loansNumber',
            'conditions' => $this->Person->parseCriteria($this->Prg->parsedParams()),
        );
        $this->paginate = am($this->paginate, $searchConditions);

        $this->Person->virtualFields = array(
             'loans' => 'loans',
         );

        //requested action
        if (!$this->request->is('ajax')) {
            return array('people' => $this->paginate(), 'paging' => $this->params['paging']);
        }
        $this->set('people', $this->paginate());
        $this->render('/Elements/People/loan', 'ajax');
    }

/**
 * Users index method (people with username/passwords)
 * @return void
 */
    public function user_index() {
        $this->Person->recursive = 0;
        $this->paginate = array('users');
        $this->set('people', $this->paginate('Person'));
    }

/**
 * Users permission method (people with username/passwords)
 * Need to be improved, looks a mess
 * @from https://github.com/rsmartin/NiceAuth
 * @throws NotFoundException
 * @return void
 */
    public function user_permissions($id = null) {
        $this->Person->id = $id;
        if (!$this->Person->exists()) {
            throw new NotFoundException(__('Invalid person'));
        }
        if (!empty($this->request->query)) {
            $req = $this->request->query;
            if ($req['perm'] == 'allow') {
                $this->Acl->allow($req['aro'], $req['aco']);
                $this->Session->setFlash(__('Aro has been allowed'), 'flash/success');
            } elseif ($req['perm'] == 'deny') {
                $this->Acl->deny($req['aro'], $req['aco']);
                $this->Session->setFlash(__('Aro has been denied'), 'flash/success');
            }
        }
        $person = $this->Person->read();
        $acos = $this->Acl->Aco->find('threaded');
        $perms = array();
        $i = 0;
        foreach ($acos as $aco) {
            $perms[$i]['Aco']['alias'] = $aco['Aco']['alias'];
            $perms[$i]['Aco']['layer'] = 1;
            if ($this->Acl->check($person['Person']['username'], $aco['Aco']['alias']) == '1') {
                $perms[$i]['Aco']['perm'] = 'allow';
            } else {
                $perms[$i]['Aco']['perm'] = 'deny';
            }
            $i++;
            
            //Second Layer
            foreach ($aco['children'] as $aco2) {
                $perms[$i]['Aco']['alias'] = $aco2['Aco']['alias'];
                $perms[$i]['Aco']['layer'] = 2;
                if ($this->Acl->check($person['Person']['username'], $aco2['Aco']['alias']) == '1') {
                    $perms[$i]['Aco']['perm'] = 'allow';
                } else {
                    $perms[$i]['Aco']['perm'] = 'deny';
                }
                $i++;

                //Third Layer
                foreach ($aco2['children'] as $aco3) {
                    $perms[$i]['Aco']['alias'] = $aco2['Aco']['alias']."/".$aco3['Aco']['alias'];
                    $perms[$i]['Aco']['layer'] = 3;
                    if ($this->Acl->check($person['Person']['username'], $aco2['Aco']['alias']."/".$aco3['Aco']['alias']) == '1') {
                        $perms[$i]['Aco']['perm'] = 'allow';
                    } else {
                        $perms[$i]['Aco']['perm'] = 'deny';
                    }
                    $i++;

                    //Fourth Layer
                    foreach ($aco3['children'] as $aco4) {
                        $perms[$i]['Aco']['alias'] = $aco2['Aco']['alias']."/".$aco3['Aco']['alias']."/".$aco4['Aco']['alias'];
                        $perms[$i]['Aco']['layer'] = 4;
                        if ($this->Acl->check($person['Person']['username'], $aco2['Aco']['alias']."/".$aco3['Aco']['alias']."/".$aco4['Aco']['alias']) == '1') {
                            $perms[$i]['Aco']['perm'] = 'allow';
                        } else {
                            $perms[$i]['Aco']['perm'] = 'deny';
                        }
                        $i++;
                    }
                }
            }
        }  
        $this->set(compact('perms', 'person'));
    }

    /*public function initDB() {
        $group = $this->Person->Group;
        // Allow admins to everything
        $group->id = 2;
        $this->Acl->allow($group, 'controllers');

        $person = $this->Person;
        $person->id = 1177; //admin id
        $this->Acl->allow($person, 'controllers');

        echo "all done";
        exit;
    }*/
}
