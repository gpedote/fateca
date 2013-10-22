<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * FATECA : Library Collection Manager
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author gpedote -- gabriel.pedote@fatec.sp.gov.br
 * @copyright Copyright (c) 2013, G.L.Pedote
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @property Group $Group
 */
class GroupsController extends AppController {

/**
 * Uses (Models)
 * OBS: Keep Group model first
 * @var array
 */    
	public $uses = array('Group', 'Person');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Group->recursive = 0;
		$this->set(array('groups' => $this->paginate('Group'), 'defaultGroup' => Configure::read('defaultGroup')));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
		$this->set('group', $this->Group->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				//$this->__fixAlias();
				$this->Session->setFlash(__('The group has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'), 'flash/error');
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->Group->id = $id;
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The group has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$this->request->data = $this->Group->find('first', $options);
		}
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
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->Group->delete()) {
			$this->Session->setFlash(__('Group deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Group was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

/**
 * Groups permission method
 * Need to be improved, looks a mess
 * @from https://github.com/rsmartin/NiceAuth
 * @return void
 */
	public function permissions($id = null) {
        $this->Group->id = $id;
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
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

		$group = $this->Group->read();
		$acos = $this->Acl->Aco->find('threaded');

		$this->set('acos', $acos);

		$perms = array();

		$i = 0;
		foreach ($acos as $aco) {
			$perms[$i]['Aco']['alias'] = $aco['Aco']['alias'];
			$perms[$i]['Aco']['layer'] = 1;
			if ($this->Acl->check($group['Group']['name'], $aco['Aco']['alias']) == '1') {
				$perms[$i]['Aco']['perm'] = 'allow';
			} else {
				$perms[$i]['Aco']['perm'] = 'deny';
			}
			$i++;

			//Second Layer
			foreach ($aco['children'] as $aco2) {
				$perms[$i]['Aco']['alias'] = $aco2['Aco']['alias'];
				$perms[$i]['Aco']['layer'] = 2;
				if ($this->Acl->check($group['Group']['name'], $aco2['Aco']['alias']) == '1') {
					$perms[$i]['Aco']['perm'] = 'allow';
				} else {
					$perms[$i]['Aco']['perm'] = 'deny';
				}
				$i++;

				//Third Layer
				foreach ($aco2['children'] as $aco3) {
					$perms[$i]['Aco']['alias'] = $aco2['Aco']['alias']."/".$aco3['Aco']['alias'];
					$perms[$i]['Aco']['layer'] = 3;
					if ($this->Acl->check($group['Group']['name'], $aco2['Aco']['alias']."/".$aco3['Aco']['alias']) == '1') {
						$perms[$i]['Aco']['perm'] = 'allow';
					} else {
						$perms[$i]['Aco']['perm'] = 'deny';
					}
					$i++;

					//Fourth Layer
					foreach ($aco3['children'] as $aco4) {
						$perms[$i]['Aco']['alias'] = $aco2['Aco']['alias']."/".$aco3['Aco']['alias']."/".$aco4['Aco']['alias'];
						$perms[$i]['Aco']['layer'] = 4;
						if ($this->Acl->check($group['Group']['name'], $aco2['Aco']['alias']."/".$aco3['Aco']['alias']."/".$aco4['Aco']['alias']) == '1') {
							$perms[$i]['Aco']['perm'] = 'allow';
						} else {
							$perms[$i]['Aco']['perm'] = 'deny';
						}
						$i++;
					}
				}
			}
		}
		$this->set(compact('perms', 'group'));
	}
}
