<?php
App::uses('SystemRule', 'Model');

/**
 * SystemRule Test Case
 *
 */
class SystemRuleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.system_rule'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SystemRule = ClassRegistry::init('SystemRule');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SystemRule);

		parent::tearDown();
	}

}
