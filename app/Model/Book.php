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
        if (isset($data['find'])) {
            $filter = $data['find'];
            $cond = array(
                'OR' => array(
                    'Book.title LIKE ' => '%' . $filter . '%',
                    'Isbn.isbn10 LIKE' => '%' . $filter . '%',
                    'Isbn.isbn13 LIKE' => '%' . $filter . '%',
                    'Types.type LIKE' => '%' . $filter . '%',
                ),
            );
            return $cond;
        }
        return false;
    }

/**
 * Find Book's Isbns
 */
    protected function _findBookIsbns($state, $query, $results = array()) {
        if ($state === 'before') {
            $fields = array('Book.id', 'Book.title', 'Types.id', 'Types.type');
            $joins = array(
                array(
                    'table' => 'isbns',
                    'alias' => 'Isbn',
                    'type' => 'right',
                    'conditions' => array('Isbn.book_id = Book.id'),
                ),
                array(
                    'table' => 'types',
                    'alias' => 'Types',
                    'type' => 'left',
                    'conditions' => array('Book.type_id = Types.id'),
                ),
            );

            // merge, can't merge with empty arrays
            if (count($query['fields'])) {
                $query['fields'] = am($query['fields'], $fields);
            } else {
                $query['fields'] = $fields;
            }

            if (count($query['joins'])) {
                $query['joins'] = am($query['joins'], $joins);
            } else {
                $query['joins'] = $joins;
            }

            return $query;
        }
        return $results;
    }
 
}
