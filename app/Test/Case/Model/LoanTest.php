<?php
App::uses('Loan', 'Model');

/**
 * Loan Test Case
 *
 */
class LoanTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.loan',
		'app.person',
		'app.group',
		'app.email',
		'app.phone',
		'app.book',
		'app.type',
		'app.isbn'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Loan = ClassRegistry::init('Loan');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Loan);

		parent::tearDown();
	}

}
