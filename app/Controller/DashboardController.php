<?php
/**
 * Dashboard Controller
 *
 * FATECA : Library Collection Manager
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author gpedote -- gabriel.pedote@fatec.sp.gov.br
 * @copyright Copyright (c) 2013, G.L.Pedote
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @from https://github.com/rsmartin/NiceAuth  -- Adapted
 */
App::uses('AppController', 'Controller');

class DashboardController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();


	public function index() {
	}

	public function database() {
		if (isset($this->request->params['pass'][0])) {
			if ($this->request->params['pass'][0] == 'aco') {
				if ($this->Acl->Aco->recover()) {
					$this->Session->setFlash(__('Aco Tree Rebuilt'), 'flash/success');
				} else {
					$this->Session->setFlash(__('Aco Tree Rebuilt Failed'), 'flash/error');
				}
			} elseif ($this->request->params['pass'][0] == 'aro') {
				if ($this->Acl->Aro->recover()) {
					$this->Session->setFlash(__('Aro Tree Rebuilt'), 'flash/success');
				} else {
					$this->Session->setFlash(__('Aro Tree Rebuilt Failed'), 'flash/error');
				}
			}
		}
		$this->render('index');
	}
}