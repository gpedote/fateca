<?php
/**
 * LoanFixture
 *
 */
class LoanFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'person_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'book_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'returned' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'fine' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'person_id' => 1,
			'book_id' => 1,
			'returned' => '2013-09-25 08:36:00',
			'fine' => 1,
			'created' => '2013-09-25 08:36:00',
			'modified' => '2013-09-25 08:36:00'
		),
	);

}
