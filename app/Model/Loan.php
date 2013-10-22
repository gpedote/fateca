<?php
App::uses('AppModel', 'Model');
/**
 * Loan Model
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
 * @property Book $Book
 */
class Loan extends AppModel {

	public $findMethods = array('currentLoans' => true);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'person_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'book_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Person' => array(
			'className' => 'Person',
			'foreignKey' => 'person_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Book' => array(
			'className' => 'Book',
			'foreignKey' => 'book_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * Find current loans
 *
 */
    protected function _findCurrentLoans($state, $query, $results = array()) {
        if ($state === 'before') {
            $fields = array(
                'Person.id', 'Person.name', 'Book.id', 'Book.title', 'Loan.id', 'Loan.created',
                'CASE
                 WHEN Loan.returned IS NOT NULL THEN
                	DATEDIFF(Loan.returned, Loan.created) 
            	 ELSE
            	 	DATEDIFF(NOW(), Loan.created)
        	 	 END as loan_time'
            );
            $conditions = array(
                'OR' => array(
                	'Loan.returned IS NULL', 
					'Loan.payed < Loan.fine',
				),
            );
            $order = array('loan_time');

            // merge, can't merge with empty arrays
            if (count($query['fields'])) {
                $query['fields'] = am($query['fields'], $fields);
            } else {
                $query['fields'] = $fields;
            }

            if (count($query['conditions'])) {
                $query['conditions'] = am($query['conditions'], $conditions);
            } else {
                $query['conditions'] = $conditions;
            }

            if (count($query['order'])) {
                $query['order'] = am($query['order'], $order);
            } else {
                $query['order'] = $order;
            }

            return $query;
        }
        return $results;
    }
}
