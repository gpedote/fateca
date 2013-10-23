<?php
App::uses('AppController', 'Controller');
/**
 * Loans Controller
 *
 * FATECA : Library Collection Manager
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author gpedote -- gabriel.pedote@fatec.sp.gov.br
 * @copyright Copyright (c) 2013, G.L.Pedote
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @property Loan $Loan
 */
class LoansController extends AppController {

/**
 * Uses (Models)
 * OBS: Keep Person model first
 * @var array
 */    
	public $uses = array('Loan', 'Person', 'Book');

/**
 * Helpers
 *
 * @var array
 */    
	public $helpers = array('Js' => array('Jquery'));

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Loan->recursive = 0;
		$this->Paginator->settings = am($this->paginate, array('findType' => 'currentLoans'));
		$this->set('loans', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Loan->exists($id)) {
			throw new NotFoundException(__('Invalid loan'));
		}
		$options = array('conditions' => array('Loan.' . $this->Loan->primaryKey => $id));
		$this->set('loan', $this->Loan->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($id = null) {
        $this->Person->id = $id;
		if (!$this->Person->exists($id)) {
			throw new NotFoundException(__('Invalid person'));
		}

		$options = array('conditions' => array('Person.' . $this->Person->primaryKey => $id));
		if ($this->request->is('post')) {
			$this->Loan->create();
			if ($this->Loan->save($this->request->data)) {
				$this->Session->setFlash(__('The loan has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The loan could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$person = $this->Person->find('first', $options);

		$this->Session->write('Person', $person);

		$this->set(compact('person', 'books')); 
	}


/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->Loan->id = $id;
		if (!$this->Loan->exists($id)) {
			throw new NotFoundException(__('Invalid loan'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Loan->save($this->request->data)) {
				$this->Session->setFlash(__('The loan has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The loan could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Loan.' . $this->Loan->primaryKey => $id));
			$this->request->data = $this->Loan->find('first', $options);
		}
		$people = $this->Loan->Person->find('list');
		$books = $this->Loan->Book->find('list');
		$this->set(compact('people', 'books'));
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
		$this->Loan->id = $id;
		if (!$this->Loan->exists()) {
			throw new NotFoundException(__('Invalid loan'));
		}
		if ($this->Loan->delete()) {
			$this->Session->setFlash(__('Loan deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Loan was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

/**
 * add_cart method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @return void
 */
	public function add_cart() {
		if ($this->request->is('ajax')) {
			if (!isset($this->request->data['Book']['id'])) {
				throw new NotFoundException(__('Invalid book'));
			}
			$id = $this->request->data['Book']['id'];
			if (!$this->Book->exists($id)) {
				throw new NotFoundException(__('Invalid book'));
			}
			if (!$this->Session->check('Person')) {
				throw new NotFoundException(__('Invalid person'));
			}

			$book = $this->Book->findById($id);

			if (!$this->Session->check('Loan')) {
				$this->Session->write('Loan.' . $id, $book);
			} else {
				if (count($this->Session->read('Loan')) <= 2) {
					$this->Session->write('Loan.' . $id, $book);
		            $this->Session->setFlash($book['Book']['title'] . ' was added to your shopping cart.', 'flash/success');
				} else {
					$this->Session->setFlash(__('Max number of loans by user reached'), 'flash/error');
				}
			}

			$this->set(array('loans' => $this->Session->read('Loan')));
			$this->render('/Elements/Loans/cart', 'ajax');
        }
    }
/**
 * delete_cart method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @return void
 */
    public function delete_cart($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$this->Book->exists($id)) {
			throw new NotFoundException(__('Invalid Book'));
		}
        $book = $this->Cart->remove($id);
        if(!empty($book)) {
                $this->Session->setFlash($book['Book']['title'] . ' was removed from your shopping cart', 'flash/success');
        }
        $this->redirect(array('action' => 'cart'));
	}

    public function cart() {
    	if (empty($this->request->params['requested'])) {
            throw new ForbiddenException();
        }
        if ($this->Session->check('Loan')) {
        	return $this->Session->read('Loan');
    	} else {
    		return array();
    	}
    }
}
