<?php
/**
 * PhoneFixture
 *
 */
class PhoneFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'person_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'phone' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'length' => 13),
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
			'phone' => ''
		),
	);

}
