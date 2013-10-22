<?php
App::uses('Isbn', 'Model');

/**
 * Isbn Test Case
 *
 */
class IsbnTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.isbn',
		'app.book',
		'app.type',
		'app.loan'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Isbn = ClassRegistry::init('Isbn');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Isbn);

		parent::tearDown();
	}

}
