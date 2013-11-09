<?php
App::uses('AppModel', 'Model');
/**
 * Book Model
 *
 * FATECA : Library Collection Manager
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author gpedote -- gabriel.pedote@fatec.sp.gov.br
 * @copyright Copyright (c) 2013, G.L.Pedote
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @property Type $Type
 * @property Isbn $Isbn
 * @property Loan $Loan
 */
class Book extends AppModel {

/**
 * Display Field
 * @var string
 */
    public $displayField = 'title';

    public $actsAs = array('Search.Searchable');

    public $filterArgs = array(
        'find' => array('type' => 'query', 'method' => 'orConditions'),
    );

    public $findMethods = array('bookIsbns' =>  true,);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'type_id' => array(
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
		'Type' => array(
			'className' => 'Type',
			'foreignKey' => 'type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Isbn' => array(
			'className' => 'Isbn',
			'foreignKey' => 'book_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Loan' => array(
			'className' => 'Loan',
			'foreignKey' => 'book_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

    public function orConditions($data = array()) {
        if (!isset($data['find']) || empty($data['find'])) {
            return false;
        }
        $filter = $data['find'];

        $this->Isbn->Behaviors->attach('Search.Searchable');
        $subQuery = $this->Isbn->getQuery('all', array(
            'conditions' => array(
                'OR' => array(
                    'Isbn.isbn10 LIKE ?' => '%' . $filter . '%',
                    'Isbn.isbn13 LIKE ?' => '%' . $filter . '%',
                ),),
            'fields' => array('Isbn.book_id'),
            )
        );
    
        $cond = array(
            'OR' => array(
                'Type.type LIKE ?' => '%' . $filter . '%',
                'Book.title LIKE ?' => '%' . $filter . '%',
                'Book.id in ('. $subQuery .')', // as array it gets quotation marks and don't work
            ),
        );
        return $cond;
    }
 
}
