<?php
App::uses('AppController', 'Controller');
/**
 * Isbns Controller
 *
 * FATECA : Library Collection Manager
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author gpedote -- gabriel.pedote@fatec.sp.gov.br
 * @copyright Copyright (c) 2013, G.L.Pedote
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @property Isbn $Isbn
 */
class IsbnsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Isbn->recursive = 0;
		$this->set('isbns', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Isbn->exists($id)) {
			throw new NotFoundException(__('Invalid isbn'));
		}
		$options = array('conditions' => array('Isbn.' . $this->Isbn->primaryKey => $id));
		$this->set('isbn', $this->Isbn->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Isbn->create();
			if ($this->Isbn->save($this->request->data)) {
				$this->Session->setFlash(__('The isbn has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The isbn could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$books = $this->Isbn->Book->find('list');
		$this->set(compact('books'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->Isbn->id = $id;
		if (!$this->Isbn->exists($id)) {
			throw new NotFoundException(__('Invalid isbn'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Isbn->save($this->request->data)) {
				$this->Session->setFlash(__('The isbn has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The isbn could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Isbn.' . $this->Isbn->primaryKey => $id));
			$this->request->data = $this->Isbn->find('first', $options);
		}
		$books = $this->Isbn->Book->find('list');
		$this->set(compact('books'));
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
		$this->Isbn->id = $id;
		if (!$this->Isbn->exists()) {
			throw new NotFoundException(__('Invalid isbn'));
		}
		if ($this->Isbn->delete()) {
			$this->Session->setFlash(__('Isbn deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Isbn was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
