<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * Person Model
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
 * @property Email $Email
 * @property Loan $Loan
 * @property Phone $Phone
 */
class Person extends AppModel {

/**
 * Display Field
 * @var string
 */
    public $displayField = 'name';

    public $actsAs = array('Search.Searchable', 'Acl' => array('type' => 'requester'));

    public $filterArgs = array(
        'find' => array('type' => 'query', 'method' => 'orConditions'),
    );

    public $findMethods = array('users' =>  true, 'loansNumber' => true);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
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
		'Email' => array(
			'className' => 'Email',
			'foreignKey' => 'person_id',
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
			'foreignKey' => 'person_id',
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
		'Phone' => array(
			'className' => 'Phone',
			'foreignKey' => 'person_id',
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

    public function beforeSave($options = array()) {
    	parent::beforeSave($options);
        $this->data['Person']['password'] = AuthComponent::password($this->data['Person']['password']);
        return true;
    }

    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['Person']['group_id'])) {
            $groupId = $this->data['Person']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        } else {
            return array('Group' => array('id' => $groupId));
        }
    }

    public function afterSave($created, $options = array()) {
    	parent::afterSave($created, $options);
    	$this->Aro->save(array('alias'=>$this->data[$this->alias]['username']));
	}

    public function orConditions($data = array()) {
        if (isset($data['find'])) {
            $filter = $data['find'];
            $cond = array(
                'OR' => array(
                    $this->alias . '.ra LIKE' => '%' . $filter . '%',
                    $this->alias . '.name LIKE' => '%' . $filter . '%',
                ));
            return $cond;
        }
        return false;
    }

/**
 * Find just users (people with username/passwords)
 */
    protected function _findUsers($state, $query, $results = array()) {
        if ($state === 'before') {
            $fields = array(
                'Person.id', 'Person.username', 'Group.id', 'Group.name',
            );
            $conditions = array(
                'NOT' => array('ISNULL( Person.username )', 'Person.username LIKE \'%admin%\''),
            );

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

            return $query;
        }
        return $results;
    }

/**
 * SELECT people.name, people.id, Count(loans.id) FROM `people` left join loans on loans.person_id = people.id WHERE isnull(loans.returned) group by people.id
 * Loans Number of a Person (not returned to collection)
 */
    protected function _findLoansNumber($state, $query, $results = array()) {
        if ($state === 'before') {
            $fields = array(
                'Person.ra', 'Person.name', 'Group.id', 
                'Group.name', 'COUNT(Loan.id) AS Loans'
            );
            $conditions = array(
                'AND' => array('ISNULL(Loan.returned)')
            );
            $joins = array(
                array(
                    'table' => 'loans',
                    'alias' => 'Loan',
                    'type' => 'left',
                    'conditions' => array('Loan.person_id = Person.id'),
                ),
            );
            $group = array('Person.id');

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
            
            if (count($query['joins'])) {
                $query['joins'] = am($query['joins'], $joins);
            } else {
                $query['joins'] = $joins;
            }
            
            if (count($query['group'])) {
                $query['group'] = am($query['group'], $group);
            } else {
                $query['group'] = $group;
            }
                
            return $query;
        } elseif ($state === 'after') {
            if (isset($query['sort']) && isset($query['direction'])) {
                return Set::sort($results, '{n}.Person.' . $query['sort'], $query['direction']);
            } else {
                return Set::sort($results, '{n}.Person.name', 'asc');
            }
        }
        return $results;
    }
}
