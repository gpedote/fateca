<?php
App::uses('AppController', 'Controller');
/**
 * Phones Controller
 *
 * FATECA : Library Collection Manager
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author gpedote -- gabriel.pedote@fatec.sp.gov.br
 * @copyright Copyright (c) 2013, G.L.Pedote
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @property Phone $Phone
 */
class PhonesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Phone->recursive = 0;
		$this->set('phones', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Phone->exists($id)) {
			throw new NotFoundException(__('Invalid phone'));
		}
		$options = array('conditions' => array('Phone.' . $this->Phone->primaryKey => $id));
		$this->set('phone', $this->Phone->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Phone->create();
			if ($this->Phone->save($this->request->data)) {
				$this->Session->setFlash(__('The phone has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phone could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$people = $this->Phone->Person->find('list');
		$this->set(compact('people'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->Phone->id = $id;
		if (!$this->Phone->exists($id)) {
			throw new NotFoundException(__('Invalid phone'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Phone->save($this->request->data)) {
				$this->Session->setFlash(__('The phone has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phone could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Phone.' . $this->Phone->primaryKey => $id));
			$this->request->data = $this->Phone->find('first', $options);
		}
		$people = $this->Phone->Person->find('list');
		$this->set(compact('people'));
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
		$this->Phone->id = $id;
		if (!$this->Phone->exists()) {
			throw new NotFoundException(__('Invalid phone'));
		}
		if ($this->Phone->delete()) {
			$this->Session->setFlash(__('Phone deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Phone was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
