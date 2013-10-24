<?php
App::uses('AppController', 'Controller');
/**
 * Books Controller
 *
 * FATECA : Library Collection Manager
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author gpedote -- gabriel.pedote@fatec.sp.gov.br
 * @copyright Copyright (c) 2013, G.L.Pedote
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @property Book $Book
 */
class BooksController extends AppController {

/**
 * Uses (Models)
 * OBS: Keep Book model first
 * @var array
 */    
    public $uses = array('Book', 'Type', 'Isbn');

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
	        //Options for preset form method
	        'presetForm' => array(
	            'paramType' => 'named',
	            'model' => 'Book',
	        ),
	        //Options for commonProcess method
	        'commonProcess' => array(
                'model' => 'Book',
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
		$this->Book->recursive = 0;
		$this->set('books', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Book->exists($id)) {
			throw new NotFoundException(__('Invalid book'));
		}
		$options = array('conditions' => array('Book.' . $this->Book->primaryKey => $id));
		$this->set('book', $this->Book->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Book->create();
			if ($this->Book->save($this->request->data)) {
				$this->Session->setFlash(__('The book has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The book could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$types = $this->Book->Type->find('list');
		$this->set(compact('types'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->Book->id = $id;
		if (!$this->Book->exists($id)) {
			throw new NotFoundException(__('Invalid book'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Book->save($this->request->data)) {
				$this->Session->setFlash(__('The book has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The book could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Book.' . $this->Book->primaryKey => $id));
			$this->request->data = $this->Book->find('first', $options);
		}
		$types = $this->Book->Type->find('list');
		$this->set(compact('types'));
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
		$this->Book->id = $id;
		if (!$this->Book->exists()) {
			throw new NotFoundException(__('Invalid book'));
		}
		if ($this->Book->delete()) {
			$this->Session->setFlash(__('Book deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Book was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
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
        $this->Prg->commonProcess('Book');
        $searchConditions = array(
            'findType' => 'bookIsbns',
            'conditions' => $this->Book->parseCriteria($this->Prg->parsedParams()),
        );
        $this->Paginator->settings = am($this->paginate, $searchConditions);
        $this->Book->virtualFields = array(
             'type' => 'type',
         );
        
        //requested action
        if (!$this->request->is('ajax')) {
            return array('books' => $this->paginate(), 'paging' => $this->params['paging']);
        }
        $this->set('books', $this->paginate());
        $this->render('/Elements/Books/loan', 'ajax');
    }

}
