<?php
App::uses('AppController', 'Controller');
/**
 * SystemRules Controller
 *
 * FATECA : Library Collection Manager
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author gpedote -- gabriel.pedote@fatec.sp.gov.br
 * @copyright Copyright (c) 2013, G.L.Pedote
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @property SystemRule $SystemRule
 */
class SystemRulesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->SystemRule->recursive = 0;
		$this->set('systemRules', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SystemRule->exists($id)) {
			throw new NotFoundException(__('Invalid system rule'));
		}
		$options = array('conditions' => array('SystemRule.' . $this->SystemRule->primaryKey => $id));
		$this->set('systemRule', $this->SystemRule->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SystemRule->create();
			if ($this->SystemRule->save($this->request->data)) {
				$this->Session->setFlash(__('The system rule has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The system rule could not be saved. Please, try again.'), 'flash/error');
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
        $this->SystemRule->id = $id;
		if (!$this->SystemRule->exists($id)) {
			throw new NotFoundException(__('Invalid system rule'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SystemRule->save($this->request->data)) {
				$this->Session->setFlash(__('The system rule has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The system rule could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('SystemRule.' . $this->SystemRule->primaryKey => $id));
			$this->request->data = $this->SystemRule->find('first', $options);
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
		$this->SystemRule->id = $id;
		if (!$this->SystemRule->exists()) {
			throw new NotFoundException(__('Invalid system rule'));
		}
		if ($this->SystemRule->delete()) {
			$this->Session->setFlash(__('System rule deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('System rule was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
